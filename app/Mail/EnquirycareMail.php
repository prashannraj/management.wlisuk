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

class EnquirycareMail extends Mailable
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
        $subject = "Att: ENQ{$data['enquiry']->id} - {$data['enquiry']->full_name} - List of Documents/Information required";

        $this->from(getEmailSender(3)->email, getEmailSender(3)->name)
            ->to($data['enquiry']->email)
            ->bcc(getEmailSender(6)->email, getEmailSender(6)->name)
            ->replyTo(optional($data['advisor'])->email, optional($data['advisor'])->name)
            ->subject($subject);

        $filename = $data['filename'] . ".pdf";

        // create & attach generated file
        $returned_path = $this->createDocument($filename);
        $this->attach(public_path($returned_path), ['as' => "01_" . $filename]);

        $attachments_string = $filename . "<br>";

        // Attach uploaded files
        if (!empty($data['attachments']) && is_array($data['attachments'])) {
            foreach ($data['attachments'] as $index => $attach) {
                $this->attachData($attach->get(), '0' . ($index + 2) . "_" . $attach->getClientOriginalName());
                $attachments_string .= $attach->getClientOriginalName() . "<br>";
            }
        }

        // Attach selected company documents
        if (!empty($data['documents']) && is_array($data['documents'])) {
            foreach ($data['documents'] as $docId) {
                $attachDoc = CompanyDocument::find($docId);
                if ($attachDoc && file_exists($attachDoc->document_path)) {
                    $this->attach($attachDoc->document_path);
                    $attachments_string .= $attachDoc->name . "<br>";
                }
            }
        }

        // prepare email content
        $description = $subject . "<br>Attachments: " . $attachments_string . "<br>";
        $email_content = $description . view('admin.inquiry.email.enquirycare', compact('data'))->render();

        // log communication
        CommunicationLog::create([
            'to' => $data['enquiry']->full_name,
            'description' => "Enquiry Care",
            'enquiry_id' => $data['enquiry']->id,
            'email_content' => $email_content,
            'basic_info_id' => null,
        ]);

        return $this->view("admin.inquiry.email.enquirycare", compact('data'));
    }


    public function createDocument($filename)
    {
        $client_id = $this->data['enquiry']->id;

        $folder = "/uploads/files/enquirycares/";
        $file_name = time() . "_{$filename}";

        $absolutePath = public_path($folder);

        if (!File::isDirectory($absolutePath)) {
            File::makeDirectory($absolutePath, 0777, true, true);
        }

        // Relative path to be stored
        $db = $folder . $file_name;

        $data = $this->data;
        $pdf = Pdf::loadView("admin.inquiry.pdf.enquiry_care", compact('data'));
        $pdf->save(public_path($db));

        $document = new Document();
        $document->enquiry_id = $client_id;
        $document->name = $filename;
        $document->note = "Generated on " . date("d/M/Y H:i:s");
        $document->documents = $db;   // Store full relative path
        $document->ftype = 'pdf';
        $document->created_by = Auth::id();
        $document->created = now();
        $document->modified = now();
        $document->modified_by = Auth::id();
        $document->save();

        return $db;
    }
}
