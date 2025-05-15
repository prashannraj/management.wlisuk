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
        // $pdf = PDF::loadView("admin.inquiry.pdf.enquiry_care", compact('data'));

        $subject = "Att: ENQ{$data['enquiry']->id} - {$data['enquiry']->full_name} - List of Documents/Information required";
        $this->from(getEmailSender(3)->email,getEmailSender(3)->name);
        $this->to($data['enquiry']->email);
        $this->bcc(getEmailSender(6)->email,getEmailSender(6)->name);
        $this->replyTo($data['advisor']->email, $data['advisor']->name);
        //attach generated file
        $filename = $data['filename'] . ".pdf";

        $returned_path = $this->createDocument($filename);
        $this->attach(public_path('uploads/files'.$returned_path),['as'=> "01_".$filename ] );

        //attach files uploaded
        $attachments_string = $filename . "<br>";
        if (is_array($data['attachments'])) {
            foreach ($data['attachments'] as $index => $attach) {
                $this->attachData($attach->get(),'0'.($index+2)."_". $attach->getClientOriginalName());
                $attachments_string .= $attach->getClientOriginalName() . "<br>";
            }
        }

        //attach selected documents
        if (array_key_exists('documents',$data) && is_array($data['documents'])) {
            foreach ($data['documents'] as $attach) {
                $attach = CompanyDocument::find($attach);
              if($attach)
              {  $this->attach($attach->document_path);
                $attachments_string .= $attach->name . "<br>";}
            }
        }

        // $filename = $data['filename'] . ".pdf";
        // $this->attachData($pdf->stream(), $filename);

        $this->subject($subject);
        $description = $subject . "<br>" . "Attachments: " . $attachments_string . "<br>";
        $email_content = $description .= view('admin.inquiry.email.enquirycare', compact('data'));
        $this->view("admin.inquiry.email.enquirycare", compact('data'));




        CommunicationLog::create([
            'to' => $data['enquiry']->full_name,
            'description' => "Enquiry Care",
            'enquiry_id' => $data['enquiry']->id,
            'email_content' => $email_content,
            'basic_info_id' => null,
        ]);
        return $this;
    }


    public function createDocument($filename)
    {
        $client_id = $this->data['enquiry']->id;

        $file_path = "/uploads/files/";
        $file_name = time() . "_{$filename}";

        $path = public_path('uploads/files/enquirycares');
        if (!File::isDirectory($path)) {

            File::makeDirectory($path, 0777, true, true);
        }



        $db = "/enquirycares/" . $file_name;
        $data = $this->data;
        $pdf = PDF::loadView("admin.inquiry.pdf.enquiry_care", compact('data'));

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
