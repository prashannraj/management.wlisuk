<?php

namespace App\Mail;

use App\Models\CommunicationLog;
use App\Models\CompanyDocument;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;


class ClientcareMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    private $data ;
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

        $subject = "Att: {$data['enquiry']->full_name} - Client care letter (ENQ{$data['enquiry']->id})";
        $filename = $data['filename'] . ".pdf";
        $count = 1;

        // Generate the PDF
        $returnedPath = $this->createDocument($filename);

        // Attach generated PDF directly from public_path
        $this->attach(public_path($returnedPath), [
            'as' => "0" . $count++ . "_" . $filename
        ]);

        // Track attachments string
        $attachments_string = $filename . "<br>";

        // Uploaded attachments
        if (!empty($data['attachments']) && is_array($data['attachments'])) {
            foreach ($data['attachments'] as $attach) {
                if ($attach) {
                    $this->attachData($attach->get(), "0" . $count++ . "_" . $attach->getClientOriginalName());
                    $attachments_string .= $attach->getClientOriginalName() . "<br>";
                }
            }
        }

        // Selected company documents
        if (!empty($data['documents']) && is_array($data['documents'])) {
            foreach ($data['documents'] as $docId) {
                $doc = CompanyDocument::find($docId);
                if ($doc && file_exists(public_path($doc->document_path))) {
                    $this->attach(public_path($doc->document_path));
                    $attachments_string .= $doc->name . "<br>";
                }
            }
        }

        // Subject + Email body
        $this->subject($subject)
            ->from(getEmailSender(3)->email, getEmailSender(3)->name)
            ->replyTo(optional($data['advisor'])->email, optional($data['advisor'])->name)
            ->view("admin.inquiry.email.clientcare", compact('data'));

        // Email log content
        $description = $subject . "<br><b>Attachments:</b><br>" . $attachments_string;
        $email_content = $description . view('admin.inquiry.email.clientcare', compact('data'))->render();

        CommunicationLog::create([
            'to' => $data['enquiry']->full_name,
            'description' => "Client Care",
            'enquiry_id' => $data['enquiry']->id,
            'email_content' => $email_content,
            'basic_info_id' => null,
        ]);

        return $this;
    }

    public function createDocument($filename)
    {
        $client_id = $this->data['enquiry']->id;

        $folder = "/uploads/files/clientcares/";
        $file_name = time() . "_{$filename}";

        // Ensure folder exists
        $path = public_path($folder);
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        // Full DB path
        $db = $folder . $file_name;

        $data = $this->data;
        $pdf = Pdf::loadView("admin.inquiry.pdf.client_care_another", compact('data'));
        $pdf->save(public_path($db));

        // Save Document record
        $document = new Document();
        $document->enquiry_id = $client_id;
        $document->name = $filename;
        $document->note = "Generated on " . date("d/M/Y H:i:s");
        $document->documents = $db;
        $document->ftype = 'pdf';
        $document->created_by = Auth::id();
        $document->created = now();
        $document->modified = now();
        $document->modified_by = Auth::id();
        $document->save();

        return $db;
    }
}
