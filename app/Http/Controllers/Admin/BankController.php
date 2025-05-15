<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Bank;
use App\Models\IsoCountry;
use Illuminate\Http\Request;

class BankController extends BaseController
{

    public function show($id){
        $data =array();
        $data['row'] = Bank::findOrFail($id);

        return view('admin.bank.show',compact('data'));
    }
    //
    public function index(){
        $data=array();
        $data['panel_name']= "Banks";
        $data['banks'] = Bank::all();
        return view('admin.bank.index',compact('data'));
    }


    public function create(){
        $data = array();
        $bank = new Bank;
        $data['bank']=$bank;
        $data['countries']= IsoCountry::all();

        return view('admin.bank.create',compact("data"));
    }


    public function edit($id){

        $data = array();
        $bank = Bank::findOrFail($id);
        $data['bank']=$bank;
        $data['countries']= IsoCountry::all();

        return view('admin.bank.edit',compact("data"));
    }


    public function update(Request $request,$id){
        $data = $this->validate($request,[
            'title'=>"required",
            'account_number'=>"required",
            'account_name'=>"required",
            'swift_code_bic'=>"nullable",
            'iso_countrylist_id'=>"required",
            'iban'=>"nullable",
            'sort_code'=>"nullable",
            'branch_address'=>"required",
            'account_ref'=>"nullable",
            'status'=>"required"
            ]);

        $bank = Bank::findOrFail($id);
        $bank->update($data);

        return redirect()->route('finance.bank.index')->with('success',"Successfully updated bank details");
    }


    public function store(Request $request){
        $data = $this->validate($request,[
            'title'=>"required",
            'account_number'=>"required",
            'account_name'=>"required",
            'swift_code_bic'=>"nullable",
            'iso_countrylist_id'=>"required",
            'iban'=>"nullable",
            'sort_code'=>"nullable",
            'branch_address'=>"required",
            'account_ref'=>"nullable",
            'status'=>"required"
            ]);

        Bank::create($data);

        return redirect()->route('finance.bank.index')->with('success',"Successfully updated bank details");
    }
}
