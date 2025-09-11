<?php

namespace App\Mail;

use App\Models\CommunicationLog;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class EnquiryProcessedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;

        // Base view
        $mail = $this->view('enquiryform.emails.processed', compact('data'));
        $email_content = view('enquiryform.emails.processed', compact('data'))->render();

        // Sender
        $sender = getEmailSender(4);
        $mail->from($sender->email, $sender->name);

        // Subject
        $mail->subject("Attn: {$data['row']->full_name}, Enquiry Process Confirmation");

        // Recipients
        if ($data['row']->validated_at === null) {
            $mail->to(['admin@wlisuk.com']);
        } else {
            $mail->to([$data['row']->email, 'admin@wlisuk.com']);
        }

        // Generate PDF
        $formType = $data['row']->form_type 
            ? "enquiryform.pdfs." . $data['row']->form_type 
            : "enquiryform.pdfs.processed";

        $pdf = Pdf::loadView($formType, compact('data'));

        $filename = "ENQ. {$data['enquiry']->id} - Enquiry Confirmation - {$data['row']->full_name}.pdf";

        // Attach PDF
        $mail->attachData($pdf->output(), $filename);

        // Save PDF to server and record in Document table
        $this->createDocument($filename);

        // Log communication
        CommunicationLog::create([
            'to' => $data['enquiry']->full_name,
            'description' => "Enquiry processed",
            'enquiry_id' => $data['enquiry']->id,
            'email_content' => $email_content,
            'basic_info_id' => null,
        ]);

        return $mail;
    }

        /**
         * Save PDF to server and store in Document table
         *
         * @param string $filename
         * @return string
         */
        /**
     * Save PDF to server and store in Document table
     *
     * @param string $filename
     * @return string
     */
    public function createDocument(string $filename)
    {
        $data = $this->data;
        $client_id = $data['enquiry']->id;

        $filePath = 'uploads/files/enquiryprocessed/';
        $fileName = time() . "_{$filename}";
        $fullPath = public_path($filePath);

        // Create directory if not exists
        if (!File::isDirectory($fullPath)) {
            File::makeDirectory($fullPath, 0777, true, true);
        }

        // Generate PDF
        $formType = $data['row']->form_type 
            ? "enquiryform.pdfs." . $data['row']->form_type 
            : "enquiryform.pdfs.processed";

        $pdf = Pdf::loadView($formType, compact('data'));

        // Save PDF to server
        $pdf->save($fullPath . $fileName);

        // Store document record
        $document = new Document();
        $document->enquiry_id  = $client_id;
        $document->name        = $filename;
        $document->note        = "Generated on " . now()->format('d/M/Y H:i:s');
        $document->documents   = "/enquiryprocessed/" . $fileName;
        $document->ftype       = 'pdf';
        $document->created_by  = Auth::id();   // REQUIRED
        $document->modified_by = Auth::id();   // REQUIRED
        $document->created     = now();
        $document->modified    = now();
        $document->save();

        return $filePath . $fileName;
    }

}
