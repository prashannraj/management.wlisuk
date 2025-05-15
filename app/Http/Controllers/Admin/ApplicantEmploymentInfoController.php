<?php

namespace App\Http\Controllers\Admin;

use App\ApplicantEmploymentInfo;
use App\ApplicationAssessment;
use App\Models\IsoCurrency;
use Illuminate\Http\Request;

class ApplicantEmploymentInfoController extends BaseController
{
    //

    public function store(Request $request, $id)
    {
        $app = ApplicationAssessment::findOrFail($id);
        $data = $this->validate($request, [
            'company_name' => 'required', 'position' => 'required', 'start_date' => 'required', 'end_date' => 'nullable', 'position' => 'required',
            'currency_id' => 'required','sponsor_name'=>'nullable',
            'calculation_type' => 'required', 'salary_requirement' => 'nullable','currency_rate'=>'required',
        ]);
        if($request->ongoing){
            $data['end_date'] = null;
        }
        $data['salary_requirement'] = 0;
        $data['application_assessment_id'] = $app->id;

        ApplicantEmploymentInfo::create($data);
        return back()->with('success',"Successfully created an employment info");
    }



    public function show($id){
        $data['row'] = ApplicantEmploymentInfo::findOrFail($id);
        $data['currencies'] = IsoCurrency::all();
        $data['sponsors'] = ApplicantEmploymentInfo::where('application_assessment_id',$data['row']->application_assessment_id)->where('sponsor_name',"!=",null)->select("sponsor_name")->get();
        return view("applicantemploymentinfo.edit",compact('data'));
    }

    public function update(Request $request, $id)
    {
        $app = ApplicantEmploymentInfo::findOrFail($id);
        $data = $this->validate($request, [
            'company_name' => 'required', 'position' => 'required', 'start_date' => 'required', 'end_date' => 'nullable', 'position' => 'required',
            'currency_id' => 'required','sponsor_name'=>'nullable','currency_rate'=>'required',
            'calculation_type' => 'required', 'salary_requirement' => 'nullable'
        ]);
        if($request->ongoing){
            $data['end_date'] = null;
        }
        $data['salary_requirement'] = 0;

        $data['application_assessment_id'] = $app->application_assessment_id;
        // dd($data);

        $app->update($data);
 
        
        return back()->with('success',"Successfully updated the employment info");
    }

    public function destroy($id){
        $app = ApplicantEmploymentInfo::findOrFail($id);
        if($app->payslips()->count() != 0){
          
        return back()->with('success',"Can't delete not empty employment.");
        }
        $app->delete();
        return back()->with("success","Successfully deleted the section");
    }
}
