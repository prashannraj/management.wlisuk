<?php

namespace App\Http\Controllers\Admin;

use App\ApplicationAssessment;
use App\CoverLetter;
use App\Mail\CoverLetterMail;
use App\Models\CompanyInfo;
use App\Models\ImmigrationApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PDF;

class CoverLetterController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        $data = array();
        $data['application_id'] = $id;
        $data['application'] = ImmigrationApplication::findOrFail($id);
        $data['application_assessments'] = ApplicationAssessment::whereStatus('completed')->where('basic_info_id',$data['application']->basic_info_id)->get();
        $data['payload'] = $data['application']->coverletter;
        if($data['payload'] == null ) $data['payload'] = new CoverLetter;
        $data['payload']->application_id = $id;
        return view('coverletter.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $app = ImmigrationApplication::findOrFail($id);
        //
        $data = $this->validate($request,[
            're'=>'required',
            'to_address'=>'required',
            'text'=>'nullable',
            'application_assessment_id'=>'required',
            'date'=>'required'
            
        ]);
        if($request->include_financial_assessment){
            $data['include_financial_assessment'] = true;
        }else{
            $data['include_financial_assessment']= false;
        }
        // dd($data);
        
        $data['coverletter'] = CoverLetter::updateOrCreate(['application_id'=>$id],$data);
        $data['companyinfo'] = CompanyInfo::first();
        $data['filename'] = "{$data['coverletter']->id}-{$data['coverletter']->application_assessment->name}-Cover-Letter.pdf";

        if($request->action == "aacl"){
            // $data['pdf'] = $pdf;
            Mail::send(new CoverLetterMail($data));
            return back()->with('success',"Successfully sent mail");
        }
        $pdf = PDF::loadView("coverletter.pdf",compact('data'));
        if($request->action == "preview_aacl"){
            return $pdf->stream();
        }

        if($request->action == "pdf_aacl"){
            return $pdf->download($data['filename']);
        }

        


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CoverLetter  $coverLetter
     * @return \Illuminate\Http\Response
     */
    public function show(CoverLetter $coverLetter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CoverLetter  $coverLetter
     * @return \Illuminate\Http\Response
     */
    public function edit(CoverLetter $coverLetter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CoverLetter  $coverLetter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CoverLetter $coverLetter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CoverLetter  $coverLetter
     * @return \Illuminate\Http\Response
     */
    public function destroy(CoverLetter $coverLetter)
    {
        //
    }
}
