<?php

namespace App\Mail;

use App\Models\CommunicationLog;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;
use File;
use Auth;

class EnquiryProcessedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $data;
    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;

        $maal =  $this->view('enquiryform.emails.processed', compact('data'));
        $email_content = view('enquiryform.emails.processed', compact('data'));

        $maal->from(getEmailSender(4)->email,getEmailSender(4)->name);
        $maal->subject("Attn: {$data['row']->full_name}, Enquiry process confirmation");
        if($data['row']->validated_at == null)
        $maal->to(['admin@wlisuk.com']);
        else{
            $maal->to([$data['row']->email,'admin@wlisuk.com']);
        }
        // $pdf = PDF::loadView('enquiryform.pdfs.processed',compact('data'));

        $formType = isset($data['row']->form_type)? "enquiryform.pdfs.".$data['row']->form_type: "enquiryform.pdfs.processed";
        $pdf = PDF::loadView($formType,compact('data'));
        $filename = "ENQ. {$data['enquiry']->id} -Enquiry confirmation-{$data['row']->full_name}.pdf";
        $maal->attachData($pdf->stream(),$filename);

        $this->createDocument($filename);


        CommunicationLog::create([
            'to'=>$data['enquiry']->full_name,
            'description'=>"Enquiry processed",
            'enquiry_id'=> $data['enquiry']->id,
            'email_content'=>$email_content,
            'basic_info_id'=>null,
        ]);

        return $maal;
    }


    public function createDocument($filename)
    {
        $client_id = $this->data['enquiry']->id;

        $file_path = "/uploads/files/";
        $file_name = time() . "_{$filename}";

        $path = public_path('uploads/files/enquiryprocessed');
        if (!File::isDirectory($path)) {

            File::makeDirectory($path, 0777, true, true);
        }



        $db = "/enquiryprocessed/" . $file_name;
        $data = $this->data;
        // $pdf = PDF::loadView("enquiryform.pdfs.processed", compact('data'));
$formType = isset($data['row']->form_type)? "enquiryform.pdfs.".$data['row']->form_type: "enquiryform.pdfs.processed";
        $pdf = PDF::loadView($formType,compact('data'));
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
