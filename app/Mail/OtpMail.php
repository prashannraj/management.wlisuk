<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
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

        $initial =  $this->view('auth.emails.otp',compact('data'));
        $initial->to($data['email'],"Registered User");
        $initial->from(getEmailSender(1)->email,getEmailSender(1)->name);
        $initial->subject("WLIS Authentication");
        return $initial;
    }
}
