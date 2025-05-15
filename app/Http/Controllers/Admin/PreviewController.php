<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdditionalDocumentData;
use App\Models\BasicInfo;
use App\Models\CompanyInfo;
use App\Models\Employee;
use App\Models\EmploymentInfo;
use Illuminate\Http\Request;
use Pdf;
class PreviewController extends BaseController
{
    //


    public function contentEc(Request $request,$id)
    {
        $client = Employee::findOrFail($id);
        $rules = [
            'action' => 'required',
            'to_address' => 'required',
            'address' => 'required',
            'employee_id' => 'required',
            'employment_info_id' => "required",
            'employee_name' => 'required',
            'type' => 'required',
            'letter_signer_id' => 'required',
            'date' => 'required',
        ];
        // $rules['passport_number'] = 'required';
        // $rules['immigration_application_id'] = 'required';


        $data = $this->validate($request, $rules);

        AdditionalDocumentData::updateOrInsert(['employee_id' => $id, 'type' => 'ec'], ['content' => json_encode($request->all())]);
        $data['employee'] = $client;
        $data['employee_id'] = $id;
        $data['letter_signer'] = Employee::findOrFail($data['letter_signer_id']);
        $data['company_info'] = CompanyInfo::first();
        $data['employment_info'] = EmploymentInfo::findOrFail($data['employment_info_id']);
    
        $content = view('admin.additionaldocument.ec.content',compact('data'))->render();
      
        return response()->json($content);
    }


    public function loadEc(Request $request,$id)
    {
        $client = Employee::findOrFail($id);
        $rules = [
            'content' => 'required',
        ];
        // $rules['passport_number'] = 'required';
        // $rules['immigration_application_id'] = 'required';


        $this->validate($request, $rules);

        $data = AdditionalDocumentData::where(['employee_id' => $id, 'type' => 'ec'])->get()->content;
        dd($data);
        $data['employee'] = $client;
        $data['employee_id'] = $id;
        $data['letter_signer'] = Employee::findOrFail($data['letter_signer_id']);
        $data['company_info'] = CompanyInfo::first();
        $data['employment_info'] = EmploymentInfo::findOrFail($data['employment_info_id']);
        $data['content'] = $request->content;

        if ($request->action == "pdf_ec") {
            $filename = $data['employee_id'] . '- ' . $data['employee_name'] . " - Employment Confirmation.pdf";
            $pdf = PDF::loadView('admin.additionaldocument.ec.master', compact('data'));
            return $pdf->download($filename);
        }

        if ($request->action == "preview_ec") {
            $filename = $data['employee_id'] . '- ' . $data['employee_name'] . " - Employment Confirmation.pdf";
            $pdf = PDF::loadView('admin.additionaldocument.ec.master', compact('data'));
            return $pdf->stream($filename);
        }


        // Mail::send(new AdditionalDocumentMail($data));

        return back()->with('success', "Successfully sent the email");
    }


    public function contentLoa(Request $request, $id)
    {

        $client = BasicInfo::findOrFail($id);
        $rules = [
            'client_name' => "required",
            'address' => "required",
            'mobile' => "nullable",
            'email' => "nullable",
            'action' => 'required',
            'parental_address' => 'nullable',
            'date' => 'nullable|string'
        ];
        $data = $this->validate($request,$rules);
       
        AdditionalDocumentData::updateOrInsert(['basic_info_id' => $id, 'type' => 'loa'], ['content' => json_encode($request->all())]);

        $data['client'] = $client;
        $data['basic_info_id'] = $id;
        $data['company_info'] = CompanyInfo::first();

        $filename = $data['basic_info_id'] . '-' . $data['client_name'] . " - LOA.pdf";

        $content = view('admin.additionaldocument.loa.content', compact('data'))->render();
        return response()->json($content);

     

       

       

        // return back()->with('success', "Successfully sent the email");
    }
}
