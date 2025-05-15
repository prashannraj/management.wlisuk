<?php

namespace App\Http\Controllers\Admin;

use App\ApplicationAssessment;
use App\ApplicationAssessmentFile;
use App\AssessmentSection;
use App\Models\BasicInfo;
use Illuminate\Http\Request;
use Str;
class AssessmentSectionController extends BaseController
{
    //
    public function show($id)
    {
        $data['row'] = ApplicationAssessment::findOrFail($id);
        return view('admin.application_assessment.show', compact('data'));
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
            'name' => 'required', 
           
        ]);

        $data['application_assessment_id'] = $id;

        $app =new AssessmentSection;
        $app->name = $data['name'];
        $app->application_assessment_id = $data['application_assessment_id'];
        $app->save();
        // TODO
        return back()->with("success", "Successfully created application assessment section");;
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
       if($request->name){
           $i = AssessmentSection::find($id);
           $i->name = $request->name;
           $i->save();

           return response()->json($i);
       }

       return response()->json("failed",404);


    }

    public function uploadFiles(Request $request,$id){
        $app = ApplicationAssessment::findOrFail($id);
        $data = $this->validate($request,[
            'documents'=>"array|required",
            'documents.*' => 'file|mimes:pdf,doc,docx|required'
        ]);

        foreach($data['documents'] as $file ){
            $name = $file->getClientOriginalName();
            $filename = "applicationassessment_".time().".".$file->getClientOriginalExtension();
            $db = $file->storeAs('application_assessements',$filename,'uploads');
            // $db = "lol";
            ApplicationAssessmentFile::create(['name'=>$name,'description'=>'','location'=>$db,'application_assessment_id'=>$id]);

        }
        return back()->with("success","Successfully updated files lists");
    }


    public function updateStatus(Request $request,$id){
        $app = ApplicationAssessment::findOrFail($id);
        $app->status = $request->status;
        $app->save();
        return back()->with('status',"Successfully updated application status");
    }

    

    public function destroy($id){
        $app = AssessmentSection::findOrFail($id);
        if($app->documents()->count() != 0){
          
        return back()->with('success',"Can't delete not empty section.");
        }
        $app->delete();
        return back()->with("success","Successfully deleted the file");
    }

    public function toggle(Request $request,$id){
        $app = AssessmentSection::findOrFail($id);
        if($app->status == 'pending') $app->status="completed";
        else if($app->status == 'completed') $app->status="pending";
        $app->save();
        return back()->with('success',"Successfully updated assessment section.");
    }

}
