<?php

namespace App\Mail;

use App\Models\CommunicationLog;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use PDF;
use Auth;
use File;

class IncomeMail extends Mailable
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
        $initial= $this->view('financial_assessment.email_income',compact('data'));
        $initial->to("admin@wlisuk.com","WLIS Admin");
        $initial->subject("Re: Income Statement");

        $pdf = PDF::loadView('financial_assessment.pdf',compact('data'));

        $email_content = view('financial_assessment.email_income', compact('data'));

        //create document for client id
        $filename=$data['filename'];
        $filepath = $this->createDocument($pdf,$data['row'],$filename );

        $initial->attachFromStorageDisk('uploads', $filepath, $filename);
        // $initial->attachData($pdf->stream(), $filename);
        $attachments = $filename;

        $initial->from(getEmailSender(3)->email,getEmailSender(3)->name);

          //creating email log
          CommunicationLog::create([
            'to' => "WLISUK",
            'description' => "Income statement",
            'email_content' => $email_content,
            'basic_info_id' => $data['row']->basic_info_id,
        ]);

        return $initial;

    }


    public function createDocument($pdf, $cover_letter,$file_name)
    {
        $client_id = $cover_letter->basic_info_id;

        $file_path = "/uploads/files/";
        $file_name = time() . "$file_name";

        $db = "income_statements/" . $file_name;

        $path = public_path('uploads/files/income_statements');
        if (!File::isDirectory($path)) {

            File::makeDirectory($path, 0777, true, true);
        }

        $pdf->save(public_path($file_path . $db));

        $document                    = new Document();
        $document->basic_info_id     = $client_id;
        $document->name         = "Income statement";
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
