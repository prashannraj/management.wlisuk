<?php

namespace App\Mail;

use App\Models\CommunicationLog;
use App\Models\CompanyDocument;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use PDF;
use File;
use Illuminate\Support\Facades\Storage;

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

        // Attach generated PDF
        $pdf_path = $this->createDocument($filename);
        $this->attach(public_path('uploads/files' . $pdf_path), ['as' => "" . $filename]);

        // Attach uploaded files
        if (!empty($data['attachments'])) {
            foreach ($data['attachments'] as $index => $path) {
                $this->attach(storage_path('app/public/' . $path), [
                    'as' => '0' . ($index + 2) . "_" . basename($path)
                ]);
            }
        }

        // Attach company documents
        if (isset($data['documents']) && is_array($data['documents'])) {
            foreach ($data['documents'] as $documentId) {
                $doc = CompanyDocument::find($documentId);
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

        $file_path = "/uploads/files/";
        $file_name = time() . "_{$filename}";

        $path = public_path('uploads/files/requesttomedical');
        if (!File::isDirectory($path)) {

            File::makeDirectory($path, 0777, true, true);
        }



        $db = "/requesttomedical/" . $file_name;
        $data = $this->data;
        $pdf = PDF::loadView("admin.inquiry.pdf.request_to_medical", compact('data'));

        $pdf->save(public_path($file_path . $db));

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
