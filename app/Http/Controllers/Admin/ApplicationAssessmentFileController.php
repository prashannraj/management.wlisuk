<?php

namespace App\Http\Controllers\Admin;

use App\ApplicationAssessment;
use App\ApplicationAssessmentFile;
use App\Models\BasicInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;
class ApplicationAssessmentFileController extends BaseController
{
    //
    
    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'name' => 'required', 'description' => 'nullable', 'document' => 'nullable|file|mimes:pdf,doc,docx',
        ]);


        $app = ApplicationAssessmentFile::findOrFail($id);
        if($request->hasFile('document')){
            Storage::disk('uploads')->delete($app->location);
            $file = $request->file('document');
            $filename = "applicationassessment_".time().".".$file->getClientOriginalExtension();
            $db = $request->file('document')->storeAs('application_assessements',$filename,'uploads');
            $data['location'] = $db;
        }
        $app->update($data);
        // TODO
        return redirect()->route('application_assessment.show',['id'=>$app->application_assessment_id,'clicked'=>$app->id])->with("success", "Successfully updated application assessment file");
    }

    public function preview($id){
        $app = ApplicationAssessmentFile::findOrFail($id);
        return Storage::disk('uploads')->download($app->location);

    }

    public function destroy($id){
        $app = ApplicationAssessmentFile::findOrFail($id);
        $app->delete();
        return back()->with("success","Successfully deleted the file");
    }

  
}
