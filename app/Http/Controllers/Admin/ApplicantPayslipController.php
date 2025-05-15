<?php

namespace App\Http\Controllers\Admin;

use App\ApplicantPayslip;
use App\Imports\ApplicantPayslipsImport;
use Illuminate\Http\Request;
use Excel;
class ApplicantPayslipController extends BaseController
{
    //

    public function store(Request $request,$id){
        $data = $this->validate($request,[
            'date'=>'required',
            'bank_date'=>'required',
            'employment_info_id'=>'required',
            'gross_pay'=>'required',
            'net_pay'=>'required',
            'proof_sent'=>'required',
            'note'=>'nullable'
        ]);

        ApplicantPayslip::create($data);

        return redirect()->route('financial_assessment.show',['id'=>$id,'clicked'=>$data['employment_info_id']])->with("success","Sucessfully added payslip");
    }

    public function import(Request $request){
        $this->validate($request,[
            'file'=>'file|mimes:xlsx,xls,csv',
            'employment_info_id'=>'required'
        ]);
        if($request->hasFile('file')){
            Excel::import(new ApplicantPayslipsImport($request->employment_info_id), $request->file('file')->store('temp'));
        }

        return back()->with("success","Successfully imported from excel sheet");
    }

    public function destroy($id){
        $app = ApplicantPayslip::findOrFail($id);
       
        $app->delete();
        return back()->with("success","Successfully deleted the slip");
    }

    public function toggle($id){
        $app = ApplicantPayslip::findOrFail($id);
        if($app->proof_sent == 'Yes') $app->proof_sent="No";
        else if($app->proof_sent == 'No') $app->proof_sent="Yes";
        $app->save();
        return back()->with('success',"Successfully updated slip proof sent");
    }

    public function edit($id){
        $data['row'] = ApplicantPayslip::with('employment_info')->findOrFail($id);
        // $data['countries'] = IsoCountry::all();
        return view("applicantpayslip.edit",compact('data'));
    }

    public function update(Request $request, $id)
    {
        $app = ApplicantPayslip::findOrFail($id);
        $data = $this->validate($request, [
            'date'=>'required',
            'bank_date'=>'required',
            'gross_pay'=>'required',
            'net_pay'=>'required',
            'proof_sent'=>'required',
            'note'=>'nullable'
        ]);
      
        $data['employment_info_id'] = $app->employment_info_id;
        // dd($data);

        $app->update($data);
        return back()->with('success',"Successfully updated the payslip info");
    }
}
