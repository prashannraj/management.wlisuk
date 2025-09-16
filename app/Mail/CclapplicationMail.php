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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class CclapplicationMail extends Mailable
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
        $addedNames = json_decode($data['newccl']->added_names_input ?? '[]', true);

        $subject  = "Att: ENQ{$data['enquiry']->id} - {$data['newccl']->full_name_with_title} - Client Care Letter";
        $filename = $data['filename'] . ".pdf";

        // Attach generated PDF
        $pdf_path = $this->createDocument($filename);
        $this->attach(public_path($pdf_path), ['as' => $filename]);

        // Attach uploaded files (user attachments)
        if (!empty($data['attachments'])) {
            foreach ($data['attachments'] as $index => $path) {
                $filePath = storage_path('app/public/' . $path);
                if (file_exists($filePath)) {
                    $this->attach($filePath, [
                        'as' => '0' . ($index + 2) . "_" . basename($path)
                    ]);
                }
            }
        }

        // Attach company documents
        if (!empty($data['documents']) && is_array($data['documents'])) {
            foreach ($data['documents'] as $documentId) {
                $doc = CompanyDocument::find($documentId);
                if ($doc && file_exists(public_path($doc->document_path))) {
                    $this->attach(public_path($doc->document_path), [
                        'as' => basename($doc->document_path)
                    ]);
                }
            }
        }

        // Render email content (for logging)
        $email_content = view('admin.inquiry.email.clientcare', compact('data', 'addedNames'))->render();

        // Save log
        CommunicationLog::create([
            'to'           => $data['newccl']->full_name_with_title,
            'description'  => "Client Care Letter",
            'enquiry_id'   => $data['enquiry']->id,
            'email_content'=> $email_content,
            'basic_info_id'=> null,
        ]);

        // Safe sender
        $sender = getEmailSender(3);

        return $this->from($sender->email ?? config('mail.from.address'), $sender->name ?? config('mail.from.name'))
            ->to($sender->email ?? config('mail.from.address'))
            ->replyTo(optional($data['advisor'])->email, optional($data['advisor'])->name)
            ->subject($subject)
            ->view('admin.inquiry.email.clientcare', compact('data', 'addedNames'));
    }

    public function createDocument($filename)
    {
        $client_id = $this->data['enquiry']->id;

        // Path inside /public/uploads/files/newccl/
        $file_path = "/uploads/files/newccl/";
        $file_name = time() . "_{$filename}";

        $path = public_path($file_path);
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        // Save PDF
        $db   = $file_path . $file_name;
        $data = $this->data;
        $addedNames = json_decode($data['newccl']->added_names_input ?? '[]', true);

        $pdf = Pdf::loadView("admin.inquiry.pdf.new_ccl", compact('data', 'addedNames'));
        $pdf->save(public_path($db));

        // Save in DB
        $document = new Document();
        $document->enquiry_id  = $client_id;
        $document->name        = $filename;
        $document->note        = "Generated on " . now()->format("d/M/Y H:i:s");
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
