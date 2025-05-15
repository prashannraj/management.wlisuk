<?php

namespace App\Http\Controllers\Admin;

use App\Mail\ReceiptMail;
use App\Models\CompanyInfo;
use App\Models\Document;
use App\Models\Invoice;
use App\Models\IsoCurrency;
use App\Models\Receipt;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PDF;


class ReceiptController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            return $this->datatable($request);
        }
        $data = [];
        $data['panel_name'] = 'List of Receipts';
        // $data['invoices'] = \App\Models\Invoice::all();              
        return view('admin.receipt.index', compact('data'));
    }

    public function datatable($request)
    {
        $data = \App\Models\Receipt::with('invoice')->select("*");
        // dd($data);
        return Datatables::of($data)
            // ->addIndexColumn()
            ->editColumn('invoice', function ($row) {
                return $row->invoice->invoice_no;
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('finance.receipt.edit', $row->id);
                $viewUrl = route('finance.receipt.show', $row->id);
                
                $btn =  '   <a href="' . $viewUrl . '" class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a> ' .
                    '   <a href="' . $editUrl . '" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i></a>'
                    . '   <a href="#deleteModal" data-id="'.$row->id.'" data-toggle="modal" class="edit btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $data = array();
        $receipt = new Receipt;
        $receipt->invoice_id = optional(Invoice::find($request->from_invoice))->id;
        $data['receipt'] = $receipt;
        
        $data['currencies'] = IsoCurrency::all();
        $data['next_id'] = optional(Receipt::latest()->first())->id ?? "1";
        $data['fromClient'] = $request->from_client;
        return view('admin.receipt.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $this->validate($request, [
            'invoice_id' => 'required|integer',
            'amount_received' => 'required|numeric',
            'remarks' => 'string|max:255|nullable',
            'date' => 'required',
        ]);
        $invoice = Invoice::findOrFail($data['invoice_id']);
        $data['client_name'] = $invoice->client_name;
        $data['address'] = $invoice->address;
        $data['basic_info_id']=$invoice->basic_info_id;
        $data['iso_currency_id']=$invoice->iso_currencylist_id;


        $r = Receipt::create($data);
        if($r->invoice)
        $r->invoice->recalculateTotals();
        $route =redirect()->route('finance.receipt.index');

        if($request->from_client){
            $route = redirect()->route('client.show',['id'=>$request->from_client,'click'=>'finances']);
        }
        if($request->from_invoice){
            $route = redirect()->route('finance.invoice.show',$request->from_invoice);
        }
        return $route->with('success','Successfully created the receipt');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function show(Receipt $receipt)
    {
        //
        $data  = array();
        $data['receipt'] = $receipt;
        $data['company_info'] = CompanyInfo::first();

        return view('admin.receipt.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Receipt $receipt)
    {
        //
        $data = array();
        $data['receipt'] = $receipt;
        $data['next_id'] = optional(Receipt::latest()->first())->id ?? "1";
        $data['fromClient'] = $request->from_client;
        return view('admin.receipt.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receipt $receipt)
    {
        //
        $data = $this->validate($request, [
            'invoice_id' => 'required|integer',
            'amount_received' => 'required|numeric',
            'remarks' => 'string|max:255|nullable',
            'date' => 'required',
        ]);
        $invoice = Invoice::findOrFail($data['invoice_id']);
        $data['client_name'] = $invoice->client_name;
        $data['address'] = $invoice->address;
        $data['basic_info_id']=$invoice->basic_info_id;
        $data['iso_currency_id']=$invoice->iso_currencylist_id;


        $receipt->update($data);
        if($receipt->invoice)
        $receipt->invoice->recalculateTotals();
        $route =redirect()->route('finance.receipt.index');

        if($request->from_client){
            $route = redirect()->route('client.show',['id'=>$request->from_client,'click'=>'finances']);
        }
        if($request->from_invoice){
            $route = redirect()->route('finance.invoice.show',$request->from_invoice);
        }
        return $route->with('success','Successfully updated the receipt');
    }


    public function updateFromInvoice(Request $request, $id)
    {
        $receipt = Receipt::findOrFail($request->receipt_id);
        //
        $data = $this->validate($request, [
            'amount_received' => 'required|numeric',
            'remarks' => 'string|max:255|nullable',
            'date' => 'required',
        ]);
      


        $receipt->update($data);

        if($receipt->invoice)
        $receipt->invoice->recalculateTotals();
        $route = redirect()->route('finance.invoice.show',['invoice'=>$receipt->invoice_id]);

        return $route->with('success','Successfully updated the receipt');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$receipt)
    {
        //
        $receipt = Receipt::findOrFail($request->id);
        $inv = $receipt->invoice;
        $receipt->delete();
        if($inv) $inv->recalculateTotals();
        return back()->with('success','Successfully deleted the receipt');

    }



    public function downloadPdf($id)
    {
        $data  = array();
        $data['receipt'] = Receipt::with('invoice')->findOrFail($id);
        $data['company_info'] = CompanyInfo::first();

        $pdf = PDF::loadView('admin.receipt.pdf_with_css', compact('data'));

        // return view('admin.receipt.pdf_with_css',compact('data'));
        return $pdf->stream('receipt.pdf');
    }

    public function generateDocument($id)
    {
        $data  = array();
        $data['receipt'] = Receipt::with('invoice')->whereHas("client")->findOrFail($id);
        $data['company_info'] = CompanyInfo::first();

        $pdf = PDF::loadView('admin.receipt.pdf_with_css', compact('data'));
        $filename = "Receipt-".$data['receipt']->receipt_no."-".$data['receipt']->invoice->client_name.".pdf";
        return $pdf->download($filename);
        // $path = 'uploads/files' . '/' . "receipts";
		// $fileName = $data['receipt']->receipt_no . "-" . time() . ".pdf";
        // $file_uploaded_path = $path ."/".$fileName ;
        // $file_uploaded_path_public = public_path($file_uploaded_path);

        // $pdf->save($file_uploaded_path_public);

        // $document                    = new Document();
        // $document->basic_info_id     = $data['receipt']->basic_info_id;
        // $document->name         = $data['receipt']->receipt_no;
        // $document->note       = "Generated on " . date("d/M/Y H:i:s");
        // $document->documents      = "receipts/".$fileName;
        // $document->ftype      = 'pdf';
        // $document->created_by        = Auth::user()->id;
        // $document->created           = now();
        // $document->modified          = now();
        // $document->modified_by       = Auth::user()->id;
        // if ($document->save()) {
        //     return redirect()->back()->with('success', 'Generated and created in client document');
        // }

        // return view('admin.invoice.pdf_with_css',compact('data'));

    }


    public function sendEmail(Request $request)
    {
        $data = array();
        //test
        
        $data =  $this->validate($request, [
            'receipt_id' => 'required|integer',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpeg,bmp,png,pdf'
        ]);
        $data['attachments']=$request->attachments;
        $data['receipt'] = Receipt::findOrFail($request->receipt_id);
        $data['company_info'] = CompanyInfo::first();

		// return view('admin.emails.invoice',compact('data'));
        Mail::to("admin@wlisuk.com")
            ->send(new ReceiptMail($data));

            return back()->with('success','successfully sent an email');
    }


}
