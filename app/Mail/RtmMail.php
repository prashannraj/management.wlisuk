<?php

namespace App\Mail;

use App\Models\CommunicationLog;
use App\Models\CompanyDocument;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;


class RtmMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    private $data;
    public function __construct($dat)
    {
        //
        $this->data = $dat;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;

        $subject = "Att: ENQ{$data['enquiry']->id} - {$data['enquiry']->full_name} - Medical Data Request Form -{$data['requesttomedical']->paitent_name}";
        $filename = $data['filename'] . ".pdf";

            // Generate FO PDF and attach
        $returnedPath = $this->createDocument($filename);
        $this->attach(public_path($returnedPath), ['as' => "01_" . $filename]);

        // Attach uploaded files
        if (!empty($data['attachments'])) {
            foreach ($data['attachments'] as $index => $file) {
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $path = $file->store('attachments', 'public');
                    $this->attach(storage_path('app/public/' . $path), [
                        'as' => '0' . ($index + 2) . "_" . $file->getClientOriginalName(),
                    ]);
                }
            }
        }

        // Attach selected documents
        if (!empty($data['documents']) && is_array($data['documents'])) {
            foreach ($data['documents'] as $docId) {
                $doc = CompanyDocument::find($docId);
                if ($doc && file_exists($doc->document_path)) {
                    $this->attach($doc->document_path, ['as' => basename($doc->document_path)]);
                }
            }
        }

        // Email body and log
        $email_content = view('admin.inquiry.email.requesttomedical', compact('data'))->render();

        CommunicationLog::create([
            'to' => $data['enquiry']->full_name,
            'description' => "Request To Medical",
            'enquiry_id' => $data['enquiry']->id,
            'email_content' => $email_content,
            'basic_info_id' => null,
        ]);

        return $this->from(getEmailSender(3)->email, getEmailSender(3)->name)
            ->to(getEmailSender(3)->email)
            ->replyTo($data['advisor']->email, $data['advisor']->name)
            ->subject($subject)
            ->view('admin.inquiry.email.requesttomedical', compact('data'));
    }


    public function createDocument($filename)
    {
        $client_id = $this->data['enquiry']->id;

        $folder = "/uploads/files/requesttomedical"; 
        $file_name = time() . "_{$filename}";

        // Ensure folder exists
        $absPath = public_path($folder);
        if (!File::isDirectory($absPath)) {
            File::makeDirectory($absPath, 0777, true, true);
        }

        // Full relative path to save in DB
        $db   = $folder . $file_name;

        $data = $this->data;

        $pdf = PDF::loadView("admin.inquiry.pdf.request_to_medical", compact('data'));
        $pdf->save(public_path($db));

        // Safe fallback for user id
        $userId = Auth::check() ? Auth::id() : 0;

    // Save document record
        $document                    = new Document();
        $document->enquiry_id     = $client_id;
        $document->name         = $filename;
        $document->note       = "Generated on " . date("d/M/Y H:i:s");
        $document->documents      = $db;
        $document->ftype      = 'pdf';
        $document->created_by        = Auth::user()->id;
        $document->created           = now();
        $document->modified          = now();
        $document->modified_by       = Auth::user()->id;

        $document->save();

        return $db;
    }
}
