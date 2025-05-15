<?php

namespace App\Mail;

use App\Models\BasicInfo;
use App\Models\CommunicationLog;
use App\Models\CompanyDocument;
use App\Models\EmailSender;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MassMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
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
        $receiver = BasicInfo::find($data['receiver']);
        if ($receiver == null) return;
        $sender = EmailSender::find($data['sender_id']);
        $this->to($receiver->email_address);
        $this->bcc("rupak@wlisuk.com");
        // $this->to($receiver->email_address);
        $this->from($sender->email, $sender->name);
        $this->subject($data['subject']);
        foreach ($data['attachment_paths'] as $path) {
            $this->attachFromStorageDisk('local', $path);
        }
        $attachments_string = "";
        if (array_key_exists('documents', $data) && is_array($data['documents'])) {
            foreach ($data['documents'] as $attach) {
                $attach = CompanyDocument::find($attach);
                if ($attach) {
                    $this->attach($attach->document_path);
                    $attachments_string .= $attach->name . "<br>";
                }
            }
        }



        //creating email log
        $comm = CommunicationLog::create([
            'to' => $receiver->full_name,
            'description' => $data['subject'],
            'email_content' => $data['content'],
            'basic_info_id' => $receiver->id
        ]);
        // $this->
        return $this->view('layouts.empty', ['content' => $data['content']]);
    }
}
