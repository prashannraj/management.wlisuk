<?php

namespace App\Mail;

use App\Models\CommunicationLog;
use App\Models\Document;
use App\Models\EmployeeDocument;
use App\Models\ImmigrationApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use PDF;

class AdditionalDocumentMail extends Mailable
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
        if (method_exists($this, $this->data['action'])) {
            return $this->{$this->data['action']}();
        } else {
            return $this;
        }
    }

    //employee
    public function coe()
    {
        $data = $this->data;
        $initial = $this;
        $initial->view('admin.additionaldocument.emails.coe', compact('data'));
       $email_content= view('admin.additionaldocument.emails.coe', compact('data'));
        $pdf = PDF::loadView('admin.additionaldocument.pdfs.coe', compact('data'));
        //create document for client id
        $filename=$data['employee_id'].'-'.$data['employee_name']." - coe.pdf";
        // $filepath = $this->createDocument($pdf,$filename );
        $filepath = $this->createDocumentEmployee($pdf,$filename );


        $initial->attachFromStorageDisk('uploads', $filepath, $filename);
        $attachments = $filename;

        $initial->subject("Attn: {$data['employee_id']}-{$data['employee_name']} - Documents Requiring Signature");
        $initial->to("admin@wlisuk.com");
        $initial->from(getEmailSender(3)->email,getEmailSender(3)->name);

        //creating email log
        CommunicationLog::create([
            'to' => $data['employee_name'],
            'description' => "Contract of employment",
            'email_content' => $email_content,
            'employee_id' => $data['employee_id'],
        ]);
        return $initial;
    }

    //employee
    public function epp()
    {
        $data = $this->data;
        $initial = $this;
        $initial->view('admin.additionaldocument.emails.epp', compact('data'));
        $email_content= view('admin.additionaldocument.emails.epp', compact('data'));
        $pdf = PDF::loadView('admin.additionaldocument.pdfs.epp', compact('data'));
        //create document for client id
        $filename=$data['employee_id'].'-'.$data['employee_name']." - epp.pdf";
        // $filepath = $this->createDocument($pdf,$filename );
        $filepath = $this->createDocumentEmployee($pdf,$filename );


        $initial->attachFromStorageDisk('uploads', $filepath, $filename);
        $attachments = $filename;

        $initial->subject("Attn: {$data['employee_id']}-{$data['employee_name']} - Documents Requiring Signature");
        $initial->to("admin@wlisuk.com");
        $initial->from(getEmailSender(3)->email,getEmailSender(3)->name);

        //creating email log
        CommunicationLog::create([
            'to' => $data['employee_name'],
            'description' => "Employment Privacy Notice",
            'email_content' => $email_content,
            'employee_id' => $data['employee_id'],
        ]);
        return $initial;
    }


    //employee
    public function ec()
    {
        $data = $this->data;
        $initial = $this;
        $initial->view('admin.additionaldocument.emails.ec', compact('data'));
        $email_content= view('admin.additionaldocument.emails.ec', compact('data'));
        $pdf = PDF::loadView('admin.additionaldocument.pdfs.ec', compact('data'));
        //create document for client id
        $filename=$data['employee_id'].'-'.$data['employee_name']." - ec.pdf";
        $filepath = $this->createDocumentEmployee($pdf,$filename );


        $initial->attachFromStorageDisk('uploads', $filepath, $filename);
        $attachments = $filename;

        $initial->subject("Attn: {$data['employee_id']}-{$data['employee_name']} - Employment Confirmation");
        $initial->to("admin@wlisuk.com");
        $initial->from(getEmailSender(3)->email,getEmailSender(3)->name);

        //creating email log
        CommunicationLog::create([
            'to' => $data['employee_name'],
            'description' => "Employment Confirmation",
            'email_content' => $email_content,
            'employee_id' => $data['employee_id'],
        ]);
        return $initial;
    }

    //employee
    public function nok()
    {
        $data = $this->data;
        $initial = $this;
        $initial->view('admin.additionaldocument.emails.nok', compact('data'));
        $email_content= view('admin.additionaldocument.emails.nok', compact('data'));
        $pdf = PDF::loadView('admin.additionaldocument.pdfs.nok', compact('data'));
        $another_pdf = $pdf;
        //create document for client id
        $filename=$data['employee_id'].'-'.$data['employee_name']." - nok.pdf";
        // $filepath = $this->createDocument($pdf,$filename );
        $filepath = $this->createDocumentEmployee($pdf,$filename );


        $initial->attachFromStorageDisk('uploads', $filepath, $filename);
        $attachments = $filename;

        $initial->subject("Attn: {$data['employee_id']}-{$data['employee_name']} - Documents Requiring Signature");
        $initial->to("admin@wlisuk.com");
        $initial->from(getEmailSender(3)->email,getEmailSender(3)->name);

        //creating email log
        CommunicationLog::create([
            'to' => $data['employee_name'],
            'description' => "Employee Next of Kin",
            'email_content' => $email_content,
            'employee_id' => $data['employee_id'],
        ]);
        return $initial;
    }


    //employee
    public function eci()
    {
        $data = $this->data;
        $initial = $this;
        $initial->view('admin.additionaldocument.emails.eci', compact('data'));
        $email_content= view('admin.additionaldocument.emails.eci', compact('data'));
        $pdf = PDF::loadView('admin.additionaldocument.pdfs.eci', compact('data'));
        //create document for client id
        $filename=$data['employee_id'].'-'.$data['employee_name']." - eci.pdf";
        // $filepath = $this->createDocument($pdf,$filename );
        $filepath = $this->createDocumentEmployee($pdf,$filename );


        $initial->attachFromStorageDisk('uploads', $filepath, $filename);
        $attachments = $filename;

        $initial->subject("Attn: {$data['employee_id']}-{$data['employee_name']} - Documents Requiring Signature");
        $initial->to("admin@wlisuk.com");
        $initial->from(getEmailSender(3)->email,getEmailSender(3)->name);

        //creating email log
        CommunicationLog::create([
            'to' => $data['employee_name'],
            'description' => "Employee Contact Information",
            'email_content' => $email_content,
            'employee_id' => $data['employee_id'],
        ]);
        return $initial;
    }

    //employee
    public function eicl()
    {
        $data = $this->data;
        $initial = $this;
        $initial->view('admin.additionaldocument.emails.eicl', compact('data'));
        $email_content= view('admin.additionaldocument.emails.eicl', compact('data'));
        $pdf = PDF::loadView('admin.additionaldocument.pdfs.eicl', compact('data'));
        //create document for client id
        $filename=$data['employee_id'].'-'.$data['employee_name']." - eicl.pdf";
        // $filepath = $this->createDocument($pdf,$filename );
        $filepath = $this->createDocumentEmployee($pdf,$filename );


        $initial->attachFromStorageDisk('uploads', $filepath, $filename);
        $attachments = $filename;

        $initial->subject("Attn: {$data['employee_id']}-{$data['employee_name']} - Employee Immigration Confirmation");
        $initial->to("admin@wlisuk.com");
        $initial->from(getEmailSender(3)->email,getEmailSender(3)->name);

        //creating email log
        CommunicationLog::create([
            'to' => $data['employee_name'],
            'description' => "Employee Immigration Confirmation",
            'email_content' => $email_content,
            'employee_id' => $data['employee_id'],
        ]);
        return $initial;
    }


    public function fof()
    {
        $data = $this->data;
        $initial = $this;
        $initial->view('admin.additionaldocument.emails.fof', compact('data'));
       $email_content= view('admin.additionaldocument.emails.fof', compact('data'));
        $pdf = PDF::loadView('admin.additionaldocument.pdfs.fof', compact('data'));
        //create document for client id
        $filename=$data['basic_info_id'].'-'.$data['client_name']." - FOF.pdf";
        // $filepath = $this->createDocument($pdf,$filename );

        // $initial->attachFromStorageDisk('uploads', $filepath, $filename);
        $initial->attachData($pdf->stream(),$filename);
        $attachments = $filename;

        $initial->subject("Attn: {$data['basic_info_id']}-{$data['client_name']} - Documents Requiring Signature");
        $initial->to("admin@wlisuk.com");
        $initial->from(getEmailSender(3)->email,getEmailSender(3)->name);

        //creating email log
        CommunicationLog::create([
            'to' => $data['client_name'],
            'description' => "File opening form",
            'email_content' => $email_content,
            'basic_info_id' => $data['basic_info_id'],
        ]);
        return $initial;
    }


    public function loc()
    {
        $data = $this->data;
        $initial = $this;
        $initial->view('admin.additionaldocument.emails.loc', compact('data'));
        $email_content= view('admin.additionaldocument.emails.loc', compact('data'));
        $pdf = PDF::loadView('admin.additionaldocument.pdfs.loc', compact('data'));
        //create document for client id
        if($data['joint_name'] ==null)
        $filename=$data['basic_info_id'].'-'.$data['client_name']." - LOC.pdf";
        else{
            $filename=$data['basic_info_id'].'-'.$data['joint_name']." - LOC.pdf";

        }
        // $filepath = $this->createDocument($pdf,$filename );

        // $initial->attachFromStorageDisk('uploads', $filepath, $filename);
        $initial->attachData($pdf->stream(),$filename);
        $attachments = $filename;

        $initial->subject("Attn: {$data['basic_info_id']}-{$data['client_name']} - Documents Requiring Signature");
        $initial->to("admin@wlisuk.com");
        $initial->from(getEmailSender(3)->email,getEmailSender(3)->name);

        //creating email log
        CommunicationLog::create([
            'to' => $data['client_name'],
            'description' => "Third party consent",
            'email_content' => $email_content,
            'basic_info_id' => $data['basic_info_id'],
        ]);
        return $initial;
    }

    public function loa()
    {
        $data = $this->data;
        $initial = $this;
        $initial->view('admin.additionaldocument.emails.loa', compact('data'));
        $email_content = view('admin.additionaldocument.emails.loa', compact('data'));
        $pdf = PDF::loadView('admin.additionaldocument.pdfs.loa', compact('data'));
        //create document for client id
        $filename=$data['basic_info_id'].'-'.$data['client_name']." - LOA.pdf";
        // $filepath = $this->createDocument($pdf,$filename );

        // $initial->attachFromStorageDisk('uploads', $filepath, $filename);
        $initial->attachData($pdf->stream(), $filename);
        $attachments = $filename;

        if (is_array($data['attachments'])) {
            foreach ($data['attachments'] as $index => $attach) {
              if($attach)
              {  $this->attachData($attach->get(), $attach->getClientOriginalName());
                $attachments .= $attach->getClientOriginalName() . "<br>";}
            }
        }

        $initial->subject("Attn: {$data['basic_info_id']}-{$data['client_name']} - Documents Requiring Signature");
        $initial->to("admin@wlisuk.com");
        $initial->from(getEmailSender(3)->email,getEmailSender(3)->name);

          //creating email log
          CommunicationLog::create([
            'to' => $data['client_name'],
            'description' => "Letter of Authority",
            'email_content' => $email_content,
            'basic_info_id' => $data['basic_info_id'],
        ]);


        return $initial;
    }


    public function rel()
    {
        $data = $this->data;
        $initial = $this;
        $data['application'] = ImmigrationApplication::findOrFail($data['immigration_application_id']);
        $initial->view('admin.additionaldocument.emails.rel', compact('data'));
        $email_content = view('admin.additionaldocument.emails.rel', compact('data'));
        $pdf = PDF::loadView('admin.additionaldocument.pdfs.rel', compact('data'));
        //create document for client id
        $filename=$data['basic_info_id'].'-'.$data['client_name']." - Representation Letter.pdf";
        // $filepath = $this->createDocument($pdf,$filename );

        // $initial->attachFromStorageDisk('uploads', $filepath, $filename);
        $initial->attachData($pdf->stream(), $filename);
        $attachments = $filename;

        $initial->subject("RE: Representation Confirmation Letter ({$data['client_name']})");
        $initial->to("admin@wlisuk.com");
        $initial->from(getEmailSender(3)->email,getEmailSender(3)->name);

          //creating email log
          CommunicationLog::create([
            'to' => $data['client_name'],
            'description' => "Representation letter",
            'email_content' => $email_content,
            'basic_info_id' => $data['basic_info_id'],
        ]);


        return $initial;
    }


    public function spd()
    {
        $data = $this->data;
        $initial = $this;
        $initial->view('admin.additionaldocument.emails.spd', compact('data'));
        $email_content = view('admin.additionaldocument.emails.spd', compact('data'));
        $pdf = PDF::loadView('admin.additionaldocument.pdfs.spd', compact('data'));
        //create document for client id
        $filename=$data['basic_info_id'].'- '.$data['client']->full_name." - Sponsor declaration.pdf";
        // $filepath = $this->createDocument($pdf,$filename );

        // $initial->attachFromStorageDisk('uploads', $filepath, $filename);
        $initial->attachData($pdf->stream(), $filename);
        $attachments = $filename;

        $initial->subject("RE: Sponsor declaration ({$data['client']->full_name})");
        $initial->to("admin@wlisuk.com");
        $initial->from(getEmailSender(3)->email,getEmailSender(3)->name);

          //creating email log
          CommunicationLog::create([
            'to' => $data['client']->full_name,
            'description' => "Sponsor declaration",
            'email_content' => $email_content,
            'basic_info_id' => $data['basic_info_id'],
        ]);


        return $initial;
    }


    public function apd()
    {
        $data = $this->data;
        $initial = $this;
        $initial->view('admin.additionaldocument.emails.apd', compact('data'));
        $email_content = view('admin.additionaldocument.emails.apd', compact('data'));
        $pdf = PDF::loadView('admin.additionaldocument.pdfs.apd', compact('data'));
        //create document for client id
        $filename=$data['basic_info_id'].'- '.$data['client']->full_name." - Applicant declaration.pdf";
        // $filepath = $this->createDocument($pdf,$filename );

        // $initial->attachFromStorageDisk('uploads', $filepath, $filename);
        $initial->attachData($pdf->stream(), $filename);
        $attachments = $filename;

        $attachments_string = $filename . "<br>";
        if (is_array($data['attachments'])) {
            foreach ($data['attachments'] as $index => $attach) {
              if($attach)
              {  $this->attachData($attach->get(), $attach->getClientOriginalName());
                $attachments_string .= $attach->getClientOriginalName() . "<br>";}
            }
        }

        $initial->subject("RE: Applicant declaration ({$data['client']->full_name})");
        $initial->to("admin@wlisuk.com");
        $initial->from(getEmailSender(3)->email,getEmailSender(3)->name);

          //creating email log
          CommunicationLog::create([
            'to' => $data['client']->full_name,
            'description' => "Applicant declaration",
            'email_content' => $email_content,
            'basic_info_id' => $data['basic_info_id'],
        ]);


        return $initial;
    }

    public function createDocument($pdf, $filename)
    {
        $client_id = $this->data['basic_info_id'];

        $file_path = "/uploads/files/";
        $file_name = time() . " $filename";

        $db = "/additional_documents/" . $file_name;

        $pdf->save(public_path($file_path . $db));

        $document                    = new Document();
        $document->basic_info_id     = $client_id;
        $document->name         = "$file_name";
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


    public function createDocumentEmployee($pdf, $filename)
    {
        $client_id = $this->data['employee_id'];

        $file_path = "/uploads/files/";
        $file_name = time() . " $filename";

        $db = "/employee_documents/" . $file_name;

        $pdf->save(public_path($file_path . $db));

        $document                    = new EmployeeDocument();
        $document->employee_id     = $client_id;
        $document->name         = "$file_name";
        $document->note       = "Generated on " . date("d/M/Y H:i:s");
        $document->document      = $db;
        $document->ftype      = 'pdf';
        $document->created_by        = Auth::user()->id;
        $document->modified_by       = Auth::user()->id;

        $document->save();

        return $db;
    }
}
