<?php

namespace App\Mail;

use App\Models\CommunicationLog;

use PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OldInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    private $data;
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
        $subject = "Att: {$data['invoice']->client_name} - WLIS Invoice {$data['invoice']->invoice_no}";
        $attachments_string = '';

        $pdf = PDF::loadView('admin.invoice.pdf_with_css', compact('data'));
        $filename = "Invoice-".$data['invoice']->invoice_no.'-'.$data['invoice']->client_name.".pdf";
        $initial =  $this
            ->subject($subject)->view('admin.emails.invoice', compact('data'))->attachData($pdf->stream(), $filename, [
                'mime' => 'application/pdf',
            ]);;
         if(is_array($data['attachments'])){
        foreach($data['attachments'] as $index=>$attach){
            $initial->attachData($attach->get(),$attach->getClientOriginalName());
            $attachments_string .= $attach->getClientOriginalName() .", ";
        }
         }

         $description = $subject;
         $description.= "\n";
         $description .= "Attachments: ".$attachments_string;
         $email_content = $description.= "\n\n". view('admin.emails.invoice', compact('data'));
         //creating email log
         CommunicationLog::create([
         	  'to'=>$data['invoice']->client_name,
             'description'=>"invoice",
             'email_content'=>$email_content,
         ]);

        return $initial;
    }
}
