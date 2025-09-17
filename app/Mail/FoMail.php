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

class FoMail extends Mailable
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

        $subject  = "Att: ENQ{$data['enquiry']->id} - " 
                . optional($data['fileopeningform'])->client_name 
                . " - File Open Form";

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

        // Email body & log
        $email_content = view('admin.inquiry.email.fileopen', compact('data'))->render();

        CommunicationLog::create([
            'to' => optional($data['fileopeningform'])->client_name,
            'description' => "File Opening Forms",
            'enquiry_id' => $data['enquiry']->id,
            'email_content' => $email_content,
            'basic_info_id' => null,
        ]);

        return $this->from(getEmailSender(3)->email, getEmailSender(3)->name)
                    ->to(getEmailSender(3)->email)
                    ->replyTo(optional($data['advisor'])->email, optional($data['advisor'])->name)
                    ->subject($subject)
                    ->view('admin.inquiry.email.fileopen', compact('data'));
    }


    public function createDocument($filename)
    {
        $client_id  = $this->data['enquiry']->id;
        $folder     = "/uploads/files/fileopen/";
        $file_name  = time() . "_{$filename}";

        // Ensure folder exists
        $absPath = public_path($folder);
        if (!File::isDirectory($absPath)) {
            File::makeDirectory($absPath, 0777, true, true);
        }

        // Full relative path to save in DB
        $db   = $folder . $file_name;

        $data = $this->data;

        // Generate PDF and save
        $pdf  = Pdf::loadView("admin.inquiry.pdf.file_open", compact('data'));
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