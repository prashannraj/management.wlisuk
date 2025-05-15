<?php

namespace App\Mail;

use App\Models\CommunicationLog;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Str;


class AdmissionApplicationProcessMail extends Mailable
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
        $this->data  = $data;
    }


    public function application_submitted()
    {
        $data = $this->data;

        $initial = $this;
        $client = $data['application_process']->application->client;
        $client_name = $data['application_process']->application->client->full_name;
        // $pdf ;
        $pdf = PDF::loadView('admin.application.admission.log.pdf.application_submitted', compact('data'));

        //create document for client id
        $filepath = $this->createDocument($pdf, $data['application_process']);

        $initial->attachFromStorageDisk('uploads', $filepath, $client->id . '_Application_Submitted.pdf');
        // $initial->attachData($pdf->stream(), $client->id . '_Application_Submitted.pdf');
        $attachments = "application_submitted.pdf";
        $document = $data['application_process']->document;
        if ($document) {
            $initial->attachFromStorageDisk('uploads', $document);
            $attachments .= ", " . $document;
        }

        if (is_array($data['attachments'])) {
            foreach ($data['attachments'] as $index => $attach) {
                $initial->attachData($attach->get(), $attach->getClientOriginalName());
                $attachments .=",".$attach->getClientOriginalName();
            }
        }

        $initial->from(getEmailSender(2)->email, getEmailSender(2)->name);
        $subject = "Application Submitted ($client_name)";
        $initial->subject($subject);

        $initial->view('admin.application.admission.emails.application_submitted', compact('data'));


        //Communication Log

        $description = $subject;
        $description .= "<br><br>";
        $description .= "Attachments: " . $attachments;
        $email_content = $description .= "<br><br><br>" . view('admin.application.admission.emails.application_submitted', compact('data'));
        //creating email log
        CommunicationLog::create([
            'to' => $data['application_process']->application->client->full_name,
            'description' => "Application Submitted",
            'email_content' => $email_content,
            'basic_info_id' => $data['application_process']->application->basic_info_id,
        ]);

        return $initial;
    }

    public function generic_process()
    {
        $data = $this->data;

        $initial = $this;
        $application_process = $data['application_process'];
        $client = $application_process->application->client;
        $client_name = $data['application_process']->application->client->full_name;
        // $pdf ;
        $attachments = '';

        $document = $data['application_process']->document;
        if ($document) {
            $initial->attachFromStorageDisk('uploads', $document);
            $attachments .= ", " . $document;
        }

        if (is_array($data['attachments'])) {
            foreach ($data['attachments'] as $index => $attach) {
                $initial->attachData($attach->get(), $attach->getClientOriginalName());
                $attachments .=",".$attach->getClientOriginalName();
            }
        }

        $initial->from(getEmailSender(2)->email, getEmailSender(2)->name);
        $subject = "{$application_process->applicationStatus->title} ($client_name)";
        $initial->subject($subject);

        $initial->view('admin.application.admission.emails.generic_mail', compact('data'));


        //Communication Log

        $description = $subject;
        $description .= "<br><br>";
        $description .= "Attachments: " . $attachments;
        $email_content = $description .= "<br><br><br>" . view('admin.application.admission.emails.generic_mail', compact('data'));
        //creating email log
        CommunicationLog::create([
            'to' => $data['application_process']->application->client->full_name,
            'description' => $application_process->applicationStatus->title,
            'email_content' => $email_content,
            'basic_info_id' => $application_process->application->basic_info_id,
        ]);

        return $initial;
    }


    public function file_closed()
    {
        $data = $this->data;

        $initial = $this;
        $client = $data['application_process']->application->client;
        $client_name = $data['application_process']->application->client->full_name;
        // $pdf ;
        $pdf = PDF::loadView('admin.application.admission.log.pdf.file_closed', compact('data'));

        //create document for client id
        $filepath = $this->createDocument($pdf, $data['application_process']);

        $initial->attachFromStorageDisk('uploads', $filepath, $client->id . '_File_Closed.pdf');
        // $initial->attachData($pdf->stream(), $client->id . '_Application_Submitted.pdf');
        $attachments = $client->id . '_File_Closed.pdf';
        $document = $data['application_process']->document;
        if ($document) {
            $initial->attachFromStorageDisk('uploads', $document);
            $attachments .= ", " . $document;
        }

        if (is_array($data['attachments'])) {
            foreach ($data['attachments'] as $index => $attach) {
                $initial->attachData($attach->get(), $attach->getClientOriginalName());
                $attachments .=",".$attach->getClientOriginalName();
            }
        }

        $initial->from(getEmailSender(2)->email, getEmailSender(2)->name);
        $subject = "File Closed ($client_name)";
        $initial->subject($subject);

        $initial->view('admin.application.admission.emails.file_closed', compact('data'));


        //Communication Log

        $description = $subject;
        $description .= "<br><br>";
        $description .= "Attachments: " . $attachments;
        $email_content = $description .= "<br><br><br>" . view('admin.application.admission.emails.file_closed', compact('data'));
        //creating email log
        CommunicationLog::create([
            'to' => $data['application_process']->application->client->full_name,
            'description' => "File Closed",
            'email_content' => $email_content,
            'basic_info_id' => $data['application_process']->application->basic_info_id,
        ]);

        return $initial;
    }



    public function createDocument($pdf, $application_process)
    {
        $client_id = $application_process->application->client->id;

        $file_path = "/uploads/files/";
        $file_name = time() . "_$client_id-{$application_process->applicationStatus->title}.pdf";

        $db = "/application_processes/" . $file_name;

        $pdf->save(public_path($file_path . $db));

        $document                    = new Document();
        $document->basic_info_id     = $client_id;
        $document->name         = $application_process->applicationStatus->title . " letter";
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



    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $data = $this->data;
        $application_process = $data['application_process'];

        $slug = Str::slug($application_process->applicationStatus->title, "_");


        if (method_exists($this, $slug)) {
            return $this->{$slug}();
        } else {
            return $this->generic_process();
        }
    }
}
