<?php

namespace App\Http\Controllers\Admin;

use App\ApplicantSavingInfo;
use App\Models\IsoCountry;
use App\Models\IsoCurrency;
use Illuminate\Http\Request;

class ApplicantSavingInfoController extends BaseController
{
    //
    public function store(Request $request,$id){
        $data = $this->validate($request,[
            'start_date'=>'required',
            'closing_date'=>'required',
            'country_id'=>'required',
            'minimum_balance'=>'required',
            'closing_balance'=>'required',
            'account_number'=>'required',
            'account_name'=>'required',
            'bank_name'=>'required',
            'sponsor_name'=>'nullable',
            'currency_id'=>'required',
            'currency_rate'=>'required',
            'application_assessment_id'=>'required'
        ]);

        ApplicantSavingInfo::create($data);

        return redirect()->route('financial_assessment.show',['id'=>$id])->with("success","Sucessfully added saving info");
    }

    public function destroy($id){
        $app = ApplicantSavingInfo::findOrFail($id);
       
        $app->delete();
        return back()->with("success","Successfully deleted the saving info");
    }

    public function edit($id){
        $data['row'] = ApplicantSavingInfo::findOrFail($id);
        $data['countries'] = IsoCountry::all();
        $data['currencies'] = IsoCurrency::all();
        $data['sponsors'] = ApplicantSavingInfo::where('application_assessment_id',$data['row']->application_assessment_id)->where('sponsor_name',"!=",null)->select("sponsor_name")->get();


        return view("applicantsavinginfo.edit",compact('data'));
    }

    public function update(Request $request, $id)
    {
        $app = ApplicantSavingInfo::findOrFail($id);
        $data = $this->validate($request, [
            'start_date'=>'required',
            'closing_date'=>'required',
            'country_id'=>'required',
            'currency_id'=>'required',
            'currency_rate'=>'required',
            'minimum_balance'=>'required',
            'closing_balance'=>'required',
            'account_number'=>'required',
            'account_name'=>'required',
            'sponsor_name'=>'nullable',
            'bank_name'=>'required',
        ]);
      
        $data['application_assessment_id'] = $app->application_assessment_id;
        // dd($data);

        $app->update($data);
        return back()->with('success',"Successfully updated the saving info");
    }
}
