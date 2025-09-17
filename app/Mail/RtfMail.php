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

class RtfMail extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    public function __construct(array $dat)
    {
        $this->data = $dat;
    }

    public function build()
    {
        $data = $this->data;

        $subject = "Att: ENQ{$data['enquiry']->id} - {$data['requesttofinance']->client_name} - Financial Data Request Form";

        $filename = $data['filename'] . ".pdf";

        // Attach generated PDF
        $pdf_path = $this->createDocument($filename);
        $fullPdfPath = public_path($pdf_path);
        if (file_exists($fullPdfPath)) {
            $this->attach($fullPdfPath, ['as' => "01_" . $filename]);
        }

        // Attach uploaded files (UploadedFile instances or paths)
        if (!empty($data['attachments']) && is_array($data['attachments'])) {
            foreach ($data['attachments'] as $index => $file) {
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $path = $file->store('attachments', 'public');
                    $fullPath = storage_path('app/public/' . $path);
                    if (file_exists($fullPath)) {
                        $this->attach($fullPath, [
                            'as' => '0' . ($index + 2) . "_" . $file->getClientOriginalName(),
                        ]);
                    }
                } elseif (is_string($file)) {
                    $fullPath = storage_path('app/public/' . $file);
                    if (file_exists($fullPath)) {
                        $this->attach($fullPath, [
                            'as' => '0' . ($index + 2) . "_" . basename($file),
                        ]);
                    }
                }
            }
        }

        // Attach company documents safely
        if (!empty($data['documents']) && is_array($data['documents'])) {
            foreach ($data['documents'] as $documentId) {
                $doc = CompanyDocument::find($documentId);
                if ($doc && !empty($doc->document_path) && file_exists($doc->document_path)) {
                    $this->attach($doc->document_path, ['as' => basename($doc->document_path)]);
                }
            }
        }

        // Email body and log
        $email_content = view('admin.inquiry.email.requesttofinance', compact('data'))->render();

         CommunicationLog::create([
            'to' => $data['requesttofinance']->client_name,
            'description' => "Request To Finance",
            'enquiry_id' => $data['enquiry']->id,
            'email_content' => $email_content,
            'basic_info_id' => null,
        ]);

        return $this->from(getEmailSender(3)->email, getEmailSender(3)->name)
            ->to(getEmailSender(3)->email)
            ->replyTo(
                optional($data['advisor'])->email ?? getEmailSender(3)->email,
                optional($data['advisor'])->name ?? getEmailSender(3)->name
            )
            ->subject($subject)
            ->view('admin.inquiry.email.requesttofinance', compact('data'));
    }

    private function createDocument(string $filename): string
    {
        $clientId = $this->data['enquiry']->id ?? 0;

        $folder = "/uploads/files/requesttofinance/";
        $fileName = time() . "_{$filename}";

        // Ensure folder exists
        $absPath = public_path($folder);
        if (!File::isDirectory($absPath)) {
            File::makeDirectory($absPath, 0777, true, true);
        }

        $relativePath = $folder . $fileName;

        $data = $this->data;

        $pdf = Pdf::loadView("admin.inquiry.pdf.request_to_finance", compact('data'));
        $pdf->save(public_path($relativePath));

        // Save document record safely
        $userId = Auth::check() ? Auth::id() : 0;

        $document = new Document();
        $document->enquiry_id  = $clientId;
        $document->name        = $filename;
        $document->note        = "Generated on " . date("d/M/Y H:i:s");
        $document->documents   = $relativePath;
        $document->ftype       = 'pdf';
        $document->created_by  = $userId;
        $document->created     = now();
        $document->modified    = now();
        $document->modified_by = $userId;
        $document->save();

        return $relativePath;
    }
}
