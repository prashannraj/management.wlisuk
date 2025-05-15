<?php

namespace App\Mail;

use App\Models\CommunicationLog;
use App\Models\CompanyInfo;
use App\Models\Document;
use App\Models\Receipt;
use PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Auth;

class ReceiptMail extends Mailable
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
        $subject = "Att: {$data['receipt']->invoice->client_name} - WLIS Receipt {$data['receipt']->receipt_no}";
        $attachments_string = '';

        // $pdf = PDF::loadView('admin.receipt.pdf_with_css', compact('data'));
        $data['receipt']->generate();
        $media = $data['receipt']->pdf;
        $filename = "Receipt-" . $data['receipt']->receipt_no . "-" . $data['receipt']->invoice->client_name . ".pdf";
        $initial =  $this
            ->subject($subject)->view('admin.emails.receipt', compact('data'));
        $initial->attach($media->getPath(), ['as' => $filename]);

        if (is_array($data['attachments'])) {
            foreach ($data['attachments'] as $index => $attach) {
                $initial->attachData($attach->get(), $attach->getClientOriginalName());
                $attachments_string .= $attach->getClientOriginalName() . ", ";
            }
        }

        $this->createDocument($filename, $media);


        $description = $subject;
        $description .= "\n";
        $description .= "Attachments: " . $attachments_string;
        $email_content = $description .= "\n\n" . view('admin.emails.receipt', compact('data'));

        //create emaillog

        CommunicationLog::create([
            'to' => $data['receipt']->client_name,
            'description' => "receipt",
            'email_content' => $email_content,
            'basic_info_id' => $data['receipt']->invoice->basic_info_id,
        ]);

        return $initial;
    }

    public function createDocument($filename,$media)
    {
        $client_id = $this->data['receipt']->invoice->basic_info_id;

        $file_path = "/uploads/files/";
        $file_name = time() . "_{$filename}";

        $path = public_path('uploads/files/receipts');
        if (!File::isDirectory($path)) {

            File::makeDirectory($path, 0777, true, true);
        }



        $db = "/receipts/" . $file_name;
        $data = $this->data;
       

        File::copy($media->getPath() ,public_path($file_path . $db));

        $document                    = new Document();
        $document->basic_info_id     = $client_id;
        $document->name         = $filename;
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
