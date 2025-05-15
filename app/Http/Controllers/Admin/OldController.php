<?php

namespace App\Http\Controllers\Admin;

use App\Mail\OldInvoiceMail;
use App\Models\CompanyInfo;
use App\Models\GeneralInvoice;
use App\Models\ImmigrationInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Support\Facades\Mail;
use PDF;

class OldController extends BaseController
{
    //
    public function indexImmigrationInvoice(Request $request){

        if ($request->ajax()) {
            return $this->datatable($request);
        }
        $data = [];
        $data['panel_name'] = 'List of Invoices';
        // $data['invoices'] = \App\Models\Invoice::all();              
        return view('old.immigrationinvoice.index', compact('data'));
    }

    public function datatable($request)
    {
        $data = DB::table('immigration_invoices')->select("*");
        // dd($data);
        return Datatables::of($data)
            // ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $viewUrl = route('old.immigrationinvoice.show', $row->id);
                // $deleteUrl = route('enquiry.delete', ['id' => $row->id]);
                $btn =  '<a href="' . $viewUrl . '" class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function showImmigrationInvoice($id)
    {
        $data  = array();
        $data['invoice'] = ImmigrationInvoice::with('invoice_items')->findOrFail($id);
        $data['invoice_items'] = $data['invoice']->invoice_items;
        $data['company_info'] = CompanyInfo::first();

        return view('old.immigrationinvoice.show', compact('data'));
    }


    public function sendEmailImmigrationInvoice(Request $request)
    {
        $data = array();
        //test
        
        $data =  $this->validate($request, [
            'invoice_id' => 'required|integer',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpeg,bmp,png,pdf'
        ]);

        
        $data['attachments']=$request->attachments;
    
        $data['invoice'] = ImmigrationInvoice::findOrFail($request->invoice_id);
        $data['company_info'] = CompanyInfo::first();

		// return view('admin.emails.invoice',compact('data'));
        Mail::to("admin@wlisuk.com")
            ->send(new OldInvoiceMail($data));

            return back()->with('success','successfully sent an email');
    }




    public function indexGeneralInvoice(Request $request){

        if ($request->ajax()) {
            return $this->gdatatable($request);
        }
        $data = [];
        $data['panel_name'] = 'List of Invoices';
        // $data['invoices'] = \App\Models\Invoice::all();              
        return view('old.generalinvoice.index', compact('data'));
    }

    public function gdatatable($request)
    {
        $data = DB::table('general_invoices')->select("*");
        // dd($data);
        return Datatables::of($data)
            // ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $viewUrl = route('old.generalinvoice.show', $row->id);
                // $deleteUrl = route('enquiry.delete', ['id' => $row->id]);
                $btn =  '<a href="' . $viewUrl . '" class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function showGeneralInvoice($id)
    {
        $data  = array();
        $data['invoice'] = GeneralInvoice::with('invoice_items')->findOrFail($id);
        $data['invoice_items'] = $data['invoice']->invoice_items;
        $data['company_info'] = CompanyInfo::first();

        return view('old.generalinvoice.show', compact('data'));
    }


    public function sendEmailGeneralInvoice(Request $request)
    {
        $data = array();
        //test
        
        $data =  $this->validate($request, [
            'invoice_id' => 'required|integer',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpeg,bmp,png,pdf'
        ]);

        
        $data['attachments']=$request->attachments;
    
        $data['invoice'] = GeneralInvoice::findOrFail($request->invoice_id);
        $data['company_info'] = CompanyInfo::first();

		// return view('admin.emails.invoice',compact('data'));
        Mail::to("admin@wlisuk.com")
            ->send(new OldInvoiceMail($data));

            return back()->with('success','successfully sent an email');
    }
}
