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

class LoaMail extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    public function __construct($dat)
    {
        $this->data = $dat;
    }

    public function build()
    {
        $data = $this->data;

        $subject = "Att: ENQ{$data['enquiry']->id} - {$data['enquiry']->full_name} - Letter of Authority for Signature";
        $filename = $data['filename'] . ".pdf";

        // Attach generated PDF
        $pdf_path = $this->createDocument($filename);
        $this->attach(public_path('uploads/files' . $pdf_path), ['as' => "01_" . $filename]);

        // Attach uploaded files
        if (!empty($data['attachments']) && is_array($data['attachments'])) {
            foreach ($data['attachments'] as $index => $path) {
                $fullPath = storage_path('app/public/' . $path);
                if (!empty($path) && file_exists($fullPath)) {
                    $this->attach($fullPath, [
                        'as' => '0' . ($index + 2) . "_" . basename($path)
                    ]);
                }
            }
        }

        // Attach company documents
        if (!empty($data['documents']) && is_array($data['documents'])) {
            foreach ($data['documents'] as $documentId) {
                $doc = CompanyDocument::find($documentId);
                if ($doc && !empty($doc->document_path) && file_exists($doc->document_path)) {
                    $this->attach($doc->document_path, ['as' => basename($doc->document_path)]);
                }
            }
        }

        // Email body and log
        $email_content = view('admin.inquiry.email.letterofauthority', compact('data'))->render();

        CommunicationLog::create([
            'to'            => $data['enquiry']->full_name,
            'description'   => "Letter of Authority for Signature",
            'enquiry_id'    => $data['enquiry']->id,
            'email_content' => $email_content,
            'basic_info_id' => null,
        ]);

        return $this->from(getEmailSender(3)->email, getEmailSender(3)->name)
            ->to($data['enquiry']->email)
            // ✅ Null-safe advisor
            ->replyTo(
                optional($data['advisor'])->email ?? getEmailSender(3)->email,
                optional($data['advisor'])->name ?? getEmailSender(3)->name
            )
            ->subject($subject)
            ->view('admin.inquiry.email.letterofauthority', compact('data'));
    }

    public function createDocument($filename)
    {
        $client_id = $this->data['enquiry']->id;

        $file_path = "/uploads/files/";
        $file_name = time() . "_{$filename}";

        $path = public_path('uploads/files/letterofauthority');
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $db = "/letterofauthority/" . $file_name;
        $data = $this->data;
        $pdf = PDF::loadView("admin.inquiry.pdf.letter_of_authority", compact('data'));

        $pdf->save(public_path($file_path . $db));

        $document              = new Document();
        $document->enquiry_id  = $client_id;
        $document->name        = $filename;
        $document->note        = "Generated on " . date("d/M/Y H:i:s");
        $document->documents   = $db;
        $document->ftype       = 'pdf';
        $document->created_by  = Auth::id();
        $document->created     = now();
        $document->modified    = now();
        $document->modified_by = Auth::id();
        $document->save();

        return $db;
    }
}
