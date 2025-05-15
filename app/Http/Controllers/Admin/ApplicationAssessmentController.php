<?php

namespace App\Http\Controllers\Admin;

use App\ApplicantEmploymentInfo;
use App\ApplicantSavingInfo;
use App\ApplicationAssessment;
use App\ApplicationAssessmentFile;
use App\FinancialAssessmentDocument;
use App\Mail\CoverLetterMail;
use App\Mail\IncomeMail;
use App\Models\Advisor;
use App\Models\BasicInfo;
use App\Models\CompanyInfo;
use App\Models\IsoCountry;
use App\Models\IsoCurrency;
use Illuminate\Http\Request;
use Str;
use PDF;
use Mail;
class ApplicationAssessmentController extends BaseController
{
    //
    public function show($id)
    {
        $data['row'] = ApplicationAssessment::findOrFail($id);
        return view('admin.application_assessment.show', compact('data'));
    }

    public function showFinancial($id)
    {
        
        $data['row'] = ApplicationAssessment::findOrFail($id);
        $data['currencies'] = IsoCurrency::all();
        $data['countries']= IsoCountry::all();
        $data['parameters'] = optional(FinancialAssessmentDocument::where('application_assessment_id',$id)->first())->content;
        if($data['parameters'] == null) $data['parameters']= array();
        $data['employment_sponsors'] = ApplicantEmploymentInfo::where('application_assessment_id',$data['row']->application_assessment_id)->where('sponsor_name',"!=",null)->select("sponsor_name")->get();
        $data['saving_sponsors'] = ApplicantSavingInfo::where('application_assessment_id',$data['row']->application_assessment_id)->where('sponsor_name',"!=",null)->select("sponsor_name")->get();
        $data['advisors'] = Advisor::whereStatus("active")->get();
        return view('admin.application_assessment.financial', compact('data'));
    }

    public function generateFinancial(Request $request,$id){
        $this->validate($request,[
            'document_type'=>'required',
            'advisor_id'=>'required'
        ]);
        if($request->document_type =="salary_saving"){
            $this->validate($request,[
                'minimum_salary'=>"required"
            ]);
        }
        $input = $request->all();
        $p = FinancialAssessmentDocument::updateOrCreate(['application_assessment_id'=>$id],[
            'content'=>$input
        ]);
        $data['parameters'] = $p->content;
        // dd($data['parameters']->content);
        $data['row'] = ApplicationAssessment::findOrFail($id);
        $data['advisor'] = Advisor::findOrFail($request->advisor_id);
        $data['employment_details'] = ApplicantEmploymentInfo::orderBy("sponsor_name")->where('application_assessment_id',$id)->get();
        $data['saving_infos'] =  ApplicantSavingInfo::where('application_assessment_id',$id)->orderBy("sponsor_name")->get();
        $data['filename'] = "Income Report {$data['row']->name}.pdf";
        $data['companyinfo'] = CompanyInfo::first();
        $pdf = PDF::loadView("financial_assessment.pdf",compact('data'));
        if($request->action == 'pdf_fad'){
            return $pdf->download($data['filename']);
        }

        if($request->action == 'preview_fad'){
            return $pdf->stream();
        }

        Mail::send(new IncomeMail($data));
        return back()->with('success',"Successfully sent the email");

    }

    public function create($id)
    {
        $data['client'] = $data['basic_info'] = BasicInfo::findOrFail($id);
        $data['row'] = new ApplicationAssessment;
        $data['countries'] = $this->getCountryCode();

        return view('admin.application_assessment.create', compact('data'));
    }

    public function store(Request $request, $id)
    {
        $data = $this->validate($request, [
            'name' => 'required', 'applying_from' => 'required', 'applying_to' => 'required',
            'application_detail_id' => 'required',
            'description' => 'nullable'
        ]);

        $data['basic_info_id'] = $id;

        $app = ApplicationAssessment::create($data);
        // TODO
        return redirect()->route('client.show', ['id'=>$id,'click'=>'applications'])->with("success", "Successfully created application assessment");;
    }


    public function edit($id)
    {
        $data['row'] = ApplicationAssessment::findOrFail($id);
        $data['client'] = $data['row']->client;

        $data['countries'] = $this->getCountryCode();

        return view('admin.application_assessment.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'name' => 'required', 'applying_from' => 'required', 'applying_to' => 'required',
            'application_detail_id' => 'required',
            'description' => 'nullable'
        ]);


        $app = ApplicationAssessment::findOrFail($id);
        $app->update($data);
        // TODO
        return redirect()->route('client.show', $app->basic_info_id)->with("success", "Successfully updated application assessment");
    }

    public function uploadFiles(Request $request,$id){
        $app = ApplicationAssessment::findOrFail($id);
        $data = $this->validate($request,[
            'documents'=>"array|required",
            'documents.*' => 'file|mimes:pdf,doc,docx|required',
            'assessment_section_id'=>'required'
        ]);

        foreach($data['documents'] as $file ){
            $name = $file->getClientOriginalName();
            $filename = "applicationassessment_".time().".".$file->getClientOriginalExtension();
            $db = $file->storeAs('application_assessements',$filename,'uploads');
            // $db = "lol";
            ApplicationAssessmentFile::create(['name'=>$name,'description'=>'','location'=>$db,
            'application_assessment_id'=>$id
            ,'assessment_section_id'=>$data['assessment_section_id']
            ]);

        }
        return back()->with("success","Successfully updated files lists");
    }


    public function updateStatus(Request $request,$id){
        $app = ApplicationAssessment::findOrFail($id);
        $app->status = $request->status;
        $app->save();
        return back()->with('status',"Successfully updated application status");
    }

    public function toggle(Request $request,$id){
        $app = ApplicationAssessment::findOrFail($id);
        if($app->status == 'pending') $app->status="completed";
        else if($app->status == 'completed') $app->status="pending";
        else if($app->status == 'cancelled') $app->status="pending";
        $app->save();
        return back()->with('success',"Successfully updated application assessment status");
    }

}
