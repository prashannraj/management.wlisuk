<?php

namespace App\Http\Controllers\Admin;

use Session;
use DataTables;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\BaseController;
use App\Models\CompanyInfo;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;

class InvoiceItemController extends BaseController
{


    public function __construct()
    {
        $this->middleware('auth');
        $this->title = $this->getTitle();
        $this->country_code = $this->getCounrtyCode();
        // $this->users = User::select('id', 'username')->orderBy('username', 'asc')->get();
    }

    public function store(Request $request){

        $data = $this->validate($request,[
            'vat_amount'=>'nullable|numeric',
            'vat'=>'nullable|numeric',
            'quantity'=>'required|integer',
            'detail'=>'required|string',
            'unit_price'=>'required|numeric',
            'invoice_id'=>'required|integer',
        ]);

        $data['sub_total']= $data['unit_price']*$data['quantity'];
        $data['vat_amount']=$data['sub_total']*$data['vat']/100;
        $data['sub_total']+= $data['vat_amount'];

        $inv = InvoiceItem::create($data);
        $inv->invoice->recalculateTotals();

        return back()->with("success",'Successfully added invoice items');

    }


    public function update(Request $request){

        $invoice = InvoiceItem::findOrFail($request->invoice_item_id);
        $data = $this->validate($request,[
            'vatamount'=>'nullable|numeric',
            'vat'=>'nullable|numeric',
            'quantity'=>'required|integer',
            'detail'=>'required|string',
            'unit_price'=>'required|numeric',
        ]);

        $data['sub_total']= $data['unit_price']*$data['quantity'];
        $data['vatamount']=$data['sub_total']*$data['vat']/100;
        $data['sub_total']+= $data['vatamount'];


        $invoice->update($data);
        $invoice->invoice->recalculateTotals();

        return back()->with("success",'Successfully updated invoice item');

    }


    public function destroy(Request $request){

        $inv = InvoiceItem::findOrFail($request->invoice_item_id);
        $invoice = $inv->invoice;
        $inv->delete();

        $invoice->recalculateTotals();
        return back()->with("success",'Successfully deleted invoice item');


    }

}
