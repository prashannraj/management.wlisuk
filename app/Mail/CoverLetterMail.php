<?php

namespace App\Mail;

use App\Models\CommunicationLog;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
class CoverLetterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $data ;
    public function __construct($d)
    {
        //
        $this->data = $d;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        $initial= $this->view('coverletter.email',compact('data'));
        $initial->to("admin@wlisuk.com","WLIS Admin");
        $initial->subject("Re: Application cover letter");

        $pdf = PDF::loadView('coverletter.pdf',compact('data'));

        $email_content = view('coverletter.email', compact('data'));

        //create document for client id
        $filename=$data['filename'];
        $filepath = $this->createDocument($pdf,$data['coverletter'],$filename );

        $initial->attachFromStorageDisk('uploads', $filepath, $filename);
        // $initial->attachData($pdf->stream(), $filename);
        $attachments = $filename;

        $initial->from(getEmailSender(3)->email,getEmailSender(3)->name);

          //creating email log
          CommunicationLog::create([
            'to' => "WLISUK",
            'description' => "Application Cover letter",
            'email_content' => $email_content,
            'basic_info_id' => $data['coverletter']->application->basic_info_id,
        ]);

        return $initial;

    }


    public function createDocument($pdf, $cover_letter,$file_name)
    {
        $client_id = $cover_letter->application->basic_info_id;

        $file_path = "/uploads/files/";
        $file_name = time() . "$file_name";

        $db = "additional_documents/" . $file_name;

        $pdf->save(public_path($file_path . $db));

        $document                    = new Document();
        $document->basic_info_id     = $client_id;
        $document->name         = "Cover letter";
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
