<?php

namespace App\Http\Controllers\Admin;

use Session;
use DataTables;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\BaseController;
use App\Mail\InvoiceMail;
use App\Models\BasicInfo;
use App\Models\CompanyInfo;
use App\Models\Document;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDF;

class InvoiceController extends BaseController
{
    private $title;
    private $country_code;
    private $currency;
    private $users;
    private $destinationPath;

    public function __construct()
    {
        $this->middleware('auth');
        $this->title = $this->getTitle();
        $this->country_code = $this->getCounrtyCode();
        $this->users = User::select('id', 'username')->orderBy('username', 'asc')->get();
        $this->destinationPath = 'uploads/files';
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->datatable($request);
        }
        $data = [];
        $data['panel_name'] = 'List of Invoices';
        // $data['invoices'] = \App\Models\Invoice::all();
        return view('admin.invoice.index', compact('data'));
    }


    public function ajaxIndex(Request $request){
        $search = $request->q ?? "";

        $data = \App\Models\Invoice::with('currency')->select("*");
        $data->where('id','LIKE','%'.$search."%");
        $data->limit(6);
        return response()->json($data->get());
    }


    public function show($id)
    {
        $data  = array();
        $data['invoice'] = Invoice::with('invoice_items')->findOrFail($id);
        $data['company_info'] = CompanyInfo::first();

        return view('admin.invoice.show', compact('data'));
    }


    public function datatable($request)
    {
        $data = \App\Models\Invoice::with('type')->select("*");
        // dd($data);
        return Datatables::of($data)
            // ->addIndexColumn()
            ->addColumn('type', function ($row) {
                if ($row->type != null) {
                    return $row->type->title;
                } else {
                    return "-";
                }
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('finance.invoice.edit', $row->id);
                $viewUrl = route('finance.invoice.show', $row->id);
                $profileUrl = route('client.show', ['id' => $row->id]);
                // $deleteUrl = route('enquiry.delete', ['id' => $row->id]);
                $btn =  '   <a href="' . $viewUrl . '" class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a> ' .
                    '   <a href="' . $editUrl . '" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function create(Request $request)
    {
        $data = array();
        $fromClient = BasicInfo::find($request->from_client);
        $invoice = null;
        if ($fromClient) {
            $invoice = new Invoice;
            $invoice->basic_info_id = $fromClient->id;
            $invoice->client_name = $fromClient->full_name;
            $invoice->address = $fromClient->address;
        }
        $data['fromClient'] = $fromClient;
        $data['invoice'] = $invoice;

        $data['currencies'] = DB::table('iso_currencylists')->get();

        $data['invoicetypes'] = DB::table('invoice_types')->get();
        $data['banks'] = DB::table('banks')->where('status','=','active')->get();
        $data['next_id'] = DB::table('invoices')->orderBy("id", 'desc')->first()->id + 1;
        return view("admin.invoice.create", compact('data'));
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'client_name' => 'required',
            'address' => 'required',
            'invoice_type_id' => 'required',
            'iso_currencylist_id' => 'required',
            'bank_id' => 'required',
            'basic_info_id' => 'nullable',

            'date' => 'required',
            'payment_due_by' => 'nullable',
            'note' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:255'

        ]);


        Invoice::create($data);
        if ($request->from_client) {
            return redirect()->route('client.show', ['id'=>$request->from_client,'click'=>'finances'])->with("success", "Successfully created the invoice");
        }

        return redirect()->route('finance.invoice.index')->with("success", "Successfully created the invoice");
    }


    public function edit($id)
    {
        $data = array();
        $data['fromClient'] = null;

        $data['invoice'] = Invoice::findOrFail($id);
        $data['currencies'] = DB::table('iso_currencylists')->get();

        $data['invoicetypes'] = DB::table('invoice_types')->get();
        $data['banks'] = DB::table('banks')->get();
        $data['next_id'] = $data['invoice']->id;
        return view("admin.invoice.edit", compact('data'));
    }

    public function update(Request $request, $invoice)
    {
        $data = $this->validate($request, [
            'client_name' => 'required',
            'address' => 'required',
            'invoice_type_id' => 'required',
            'iso_currencylist_id' => 'required',
            'bank_id' => 'required',
            'date' => 'required',
            'basic_info_id' => 'nullable',
            'payment_due_by' => 'nullable',
            'note' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:255'

        ]);


        $invoice = Invoice::findOrFail($invoice);
        $invoice->update($data);

        if ($request->from_client) {
            return redirect()->route('client.show', ['id'=>$request->from_client,'click'=>'finances'])->with("success", "Successfully updated the invoice");
        }

        return redirect()->route('finance.invoice.index')->with("success", "Successfully updated the invoice");
    }


    public function destroy()
    {
    }


    public function downloadPdf($id)
    {
        $data  = array();
        $data['invoice'] = Invoice::with('invoice_items')->findOrFail($id);
        $data['company_info'] = CompanyInfo::first();

        $pdf = PDF::loadView('admin.invoice.pdf_with_css', compact('data'));

        // return view('admin.invoice.pdf_with_css',compact('data'));
        return $pdf->stream('invoice.pdf');
    }

    public function generateDocument($id)
    {
        $data  = array();
        $data['invoice'] = Invoice::with('invoice_items')->whereHas("client")->findOrFail($id);
        $data['company_info'] = CompanyInfo::first();
        $filename = "Invoice-".$data['invoice']->invoice_no.'-'.$data['invoice']->client_name.".pdf";

        $pdf = PDF::loadView('admin.invoice.pdf_with_css', compact('data'));

        return $pdf->download($filename);
        // $path = $this->destinationPath . '/' . "invoices";
		// $fileName = $data['invoice']->invoice_no . "-" . time() . ".pdf";
        // $file_uploaded_path = $path ."/".$fileName ;
        // $file_uploaded_path_public = public_path($file_uploaded_path);

        // $pdf->save($file_uploaded_path_public);

        // $document                    = new Document();
        // $document->basic_info_id     = $data['invoice']->basic_info_id;
        // $document->name         = $data['invoice']->invoice_no;
        // $document->note       = "Generated on " . date("d/M/Y H:i:s");
        // $document->documents      = "invoices/".$fileName;
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
            'invoice_id' => 'required|integer',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpeg,bmp,png,pdf'
        ]);
        $data['attachments']=$request->attachments;

        $data['invoice'] = Invoice::findOrFail($request->invoice_id);
        $data['company_info'] = CompanyInfo::first();

		// return view('admin.emails.invoice',compact('data'));
        Mail::to("admin@wlisuk.com")
            ->send(new InvoiceMail($data));

            return back()->with('success','successfully sent an email');
    }
}
