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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class LtfMail extends Mailable
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

        // Null-safe access
        $letter = $data['lettertofirms'] ?? null;
        $enquiry = $data['enquiry'] ?? null;
        $advisor = $data['advisor'] ?? null;

        $firmsname = $letter->firmsname ?? 'No Firm';
        $your = $letter->your ?? 'No Name';
        $enquiryId = $enquiry->id ?? '0';
        $filenameBase = $data['filename'] ?? "ENQ{$enquiryId}-NoFile";
        $filename = $filenameBase . ".pdf";

        $subject = "Att: {$firmsname} - Your client: {$your} - File/Data request - Our Ref: ENQ{$enquiryId}";

        // Generate PDF safely
        $pdf_path = null;
        if ($enquiry) {
            try {
                $pdf_path = $this->createDocument($filenameBase);
            } catch (\Exception $e) {
                Log::error("PDF generation failed: " . $e->getMessage());
            }
        }

        $mail = $this->from(
            optional(getEmailSender(3))->email ?? config('mail.from.address'),
            optional(getEmailSender(3))->name ?? config('mail.from.name')
        )->subject($subject);

        // Attach PDF if exists
        if ($pdf_path && file_exists(public_path('uploads/files' . $pdf_path))) {
            $mail->attach(public_path('uploads/files' . $pdf_path), [
                'as' => $filename,
            ]);
        }

        // Attach uploaded files safely
        if (!empty($data['attachments']) && is_array($data['attachments'])) {
            foreach ($data['attachments'] as $index => $path) {
                $fullPath = storage_path('app/public/' . $path);
                if (file_exists($fullPath)) {
                    $mail->attach($fullPath, [
                        'as' => '0' . ($index + 2) . "_" . basename($path)
                    ]);
                }
            }
        }

        // Attach company documents safely
        if (!empty($data['documents']) && is_array($data['documents'])) {
            foreach ($data['documents'] as $documentId) {
                $doc = CompanyDocument::find($documentId);
                if ($doc && file_exists($doc->document_path)) {
                    $mail->attach($doc->document_path, [
                        'as' => basename($doc->document_path)
                    ]);
                }
            }
        }

        // Render email content safely
        $email_content = view('admin.inquiry.email.lettertofirm', compact('data'))->render();

        if ($enquiry) {
            CommunicationLog::create([
                'to' => $enquiry->full_name ?? 'Unknown',
                'description' => "Letter to firms (Data request)",
                'enquiry_id' => $enquiry->id ?? null,
                'email_content' => $email_content,
                'basic_info_id' => null,
            ]);
        }

        // To and ReplyTo safely
        if ($enquiry && $advisor) {
            $mail->to($enquiry->email)
                ->replyTo($advisor->email ?? null, $advisor->name ?? null);
        } elseif ($enquiry) {
            $mail->to($enquiry->email);
        }

        // Finally, set view
        return $mail->view('admin.inquiry.email.lettertofirm', compact('data'));
    }



    public function createDocument($filename)
    {
        $client_id = $this->data['enquiry']->id;

        $file_path = "/uploads/files/";
        $file_name = time() . "_{$filename}";

        $path = public_path('uploads/files/lettertofirm');
        if (!File::isDirectory($path)) {

            File::makeDirectory($path, 0777, true, true);
        }



        $db = "/lettertofirm/" . $file_name;
        $data = $this->data;
        $pdf = PDF::loadView("admin.inquiry.pdf.letter_to_firm", compact('data'));

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
