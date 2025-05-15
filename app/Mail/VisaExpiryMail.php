<?php

namespace App\Mail;

use App\Models\Advisor;
use App\Models\CommunicationLog;
use App\Models\CompanyDocument;
use App\Models\EmailSender;
use App\Models\Visa;
use App\Models\VisaExpiryEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VisaExpiryMail extends Mailable
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
        $visa = Visa::find($data['receiver_id']);
        $receiver = $visa->client;
        $sender = Advisor::find($data['sender_id']);
        if(array_key_exists("client_email",$data) && $data['client_email']!="Select an option"){
            $this->to($data['client_email']);
            $this->bcc('rupak@wlisuk.com');

        }else{
            $this->to('rupak@wlisuk.com');
        }

        if(array_key_exists("kin_email",$data) && $data['kin_email']!="Select an option" ){
            $this->bcc($data['kin_email']);
        }
        // $this->to($receiver->email_address);
        $this->from($sender->email, $sender->name);
        $this->subject($data['subject']);
        foreach ($data['attachment_paths'] as $path) {
            $this->attachFromStorageDisk('local', $path);
        }
        $attachments_string = "";
        if (array_key_exists('documents',$data) && is_array($data['documents'])) {
            foreach ($data['documents'] as $attach) {
                $attach = CompanyDocument::find($attach);
              if($attach)
              {  $this->attach($attach->document_path);
                $attachments_string .= $attach->name . "<br>";}
            }
        }



        //creating email log
        $comm = CommunicationLog::create([
            'to' => $receiver->full_name,
            'description' => "Visa Expiry Mail",
            'email_content' => $data['email_content'],
            'basic_info_id' => $receiver->id
        ]);

        VisaExpiryEmail::updateOrCreate([
            'visa_id' => $receiver->id,
        ], ['communication_log_id' => $comm->id]);

        // $this->
        return $this->view('layouts.empty', ['content' => $data['email_content']]);
    }
}
