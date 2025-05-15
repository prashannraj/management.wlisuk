<?php

namespace App\Mail;

use App\Models\CommunicationLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PayyslipMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $data;
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
        $subject = "Att: {$data['row']->employee->full_name} ({$data['row']->employee_id}) Payslip [{$data['row']->year_month}]";
        $attachments_string = '';
        $full_path  = $data['row']->document;
        $full_path  = $data['row']->document;
        $extension =explode('.',$full_path );
        $extension = end($extension);

        $filename = "Payslip-" . $data['row']->year_month . '-' . $data['row']->employee->full_name . ".$extension";
        $initial =  $this
            ->subject($subject)->view('admin.emails.payslip', compact('data'));
        $initial->attachFromStorageDisk('uploads', $data['row']->document, $filename);

        if (is_array($data['attachments'])) {
            foreach ($data['attachments'] as $index => $attach) {
                $initial->attachData($attach->get(), $attach->getClientOriginalName());
                $attachments_string .= $attach->getClientOriginalName() . ", ";
            }
        }

        $description = $subject;
        $description .= "\n";
        $description .= "Attachments: " . $attachments_string;
        $email_content = $description .= "\n\n" . view('admin.emails.payslip', compact('data'));
        //creating email log
        CommunicationLog::create([
            'to' => $data['row']->employee->full_name,
            'description' => "Payslip",
            'employee_id'=>$data['row']->employee_id,
            'email_content' => $email_content,
            'employee_id'=>$data['row']->employee_id
        ]);

        $initial->from(getEmailSender(1)->email,getEmailSender(1)->name);
        return $initial;
    }
}
