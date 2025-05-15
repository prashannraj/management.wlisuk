<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnquiryVerifyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $data;
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
        $maal =  $this->view('enquiryform.emails.verify', compact('data'));
        $maal->from(getEmailSender(4)->email,getEmailSender(4)->name);
        $maal->subject("Re: Verify your email before your enquiry is registered.");
        $maal->to($data['row']->email);

        return $maal;
    }
}
