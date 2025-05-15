<?php

namespace App\Http\Controllers\Admin;

use App\Mail\AdditionalDocumentMail;
use App\Models\AdditionalDocumentData;
use App\Models\Advisor;
use App\Models\BasicInfo;
use App\Models\CompanyInfo;
use App\Models\Employee;
use App\Models\EmploymentInfo;
use App\Models\ImmigrationApplication;
use App\Models\Visa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Matrix\Operators\Addition;
use PDF;

class AdditionalDocumentController extends BaseController
{
    //

    public function createLoa(Request $request, $id)
    {
        $data = array();
        $data['basic_info_id'] = $id;
        $data['basic_info'] = BasicInfo::findOrFail($id);
        $data['payload'] = optional($data['basic_info']->additionaldata()->where('type', 'loa')->first())->content;
        return view('admin.additionaldocument.create.loa', compact('data'));
    }





    public function storeLoa(Request $request, $id)
    {

        $client = BasicInfo::findOrFail($id);
        $rules = [
            'client_name' => "required",
            'address' => "required",
            'mobile' => "nullable",
            'email' => "nullable",
            'action' => 'required',
            'parental_address' => 'nullable',
            'date' => 'nullable|string',
            'content'=>'nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:5120'
        ];
  
        $data = $this->validate($request, $rules);

        AdditionalDocumentData::updateOrInsert(['basic_info_id' => $id, 'type' => 'loa'], ['content' => json_encode($request->all())]);

        $data['client'] = $client;
        $data['basic_info_id'] = $id;
        $data['company_info'] = CompanyInfo::first();

     
        if ($request->action == "pdf_loa") {
            $filename = $data['basic_info_id'] . '-' . $data['client_name'] . " - LOA.pdf";

            $pdf = PDF::loadView('admin.additionaldocument.pdfs.loa', compact('data'));
            return $pdf->download($filename);
        }

        if ($request->action == "preview_loa") {
            $filename = $data['basic_info_id'] . '-' . $data['client_name'] . " - LOA.pdf";

            $pdf = PDF::loadView('admin.additionaldocument.pdfs.loa', compact('data'));
            return $pdf->stream($filename);
        }

    
        Mail::send(new AdditionalDocumentMail($data));

        return back()->with('success', "Successfully sent the email");
    }


    public function createLoc(Request $request, $id)
    {
        $data = array();
        $data['basic_info_id'] = $id;
        $data['basic_info'] = BasicInfo::findOrFail($id);
        $data['payload'] = optional($data['basic_info']->additionaldata()->where('type', 'loc')->first())->content;
        return view('admin.additionaldocument.create.loc', compact('data'));
    }





    public function storeLoc(Request $request, $id)
    {

        $client = BasicInfo::findOrFail($id);
        $rules = [
            'client_name' => "required",
            'address' => "required",
            'action' => 'required',
            'joint_name' => 'nullable',

            'joint_address' => 'nullable',
            'date' => 'nullable|string'
        ];


        $data = $this->validate($request, $rules);

        AdditionalDocumentData::updateOrInsert(['basic_info_id' => $id, 'type' => 'loc'], ['content' => json_encode($request->all())]);

        $data['client'] = $client;
        $data['basic_info_id'] = $id;
        $data['company_info'] = CompanyInfo::first();



        if ($request->action == "pdf_loc") {
            if ($data['joint_name'])
                $filename = $data['basic_info_id'] . '-' . $data['joint_name'] . " - TPC.pdf";
            else
                $filename = $data['basic_info_id'] . '-' . $data['client_name'] . " - TPC.pdf";

            $pdf = PDF::loadView('admin.additionaldocument.pdfs.loc', compact('data'));
            return $pdf->download($filename);
        }


        Mail::send(new AdditionalDocumentMail($data));

        return back()->with('success', "Successfully sent the email");
    }


    public function createFof(Request $request, $id)
    {
        $data = array();
        $data['basic_info_id'] = $id;
        $data['basic_info'] = BasicInfo::findOrFail($id);
        $data['payload'] = optional($data['basic_info']->additionaldata()->where('type', 'fof')->first())->content;
        return view('admin.additionaldocument.create.fof', compact('data'));
    }


    public function storeFof(Request $request, $id)
    {
        $client = BasicInfo::findOrFail($id);
        $rules = [
            'client_name' => "required",
            'address' => "required",
            'mobile' => "required",
            'email' => "required",
            'action' => 'required',
            'parental_address' => 'nullable',
            'date' => 'nullable|string'
        ];

        $rules['authorised_person_name'] = 'nullable';
        $rules['authorised_person_contact'] = 'nullable';
        $rules['authorised_person_email'] = 'nullable';
        $rules['authorised_person_relationship'] = 'nullable';
        $rules['authorised_person_address'] = 'nullable';

        $rules['authorisation_word'] = 'nullable';


        $data = $this->validate($request, $rules);

        AdditionalDocumentData::updateOrInsert(['basic_info_id' => $id, 'type' => 'fof'], ['content' => json_encode($request->all())]);

        $data['client'] = $client;
        $data['basic_info_id'] = $id;
        $data['company_info'] = CompanyInfo::first();

        if ($request->action == "pdf_fof") {
            $filename = $data['basic_info_id'] . '-' . $data['client_name'] . " - FOF.pdf";
            $pdf = PDF::loadView('admin.additionaldocument.pdfs.fof', compact('data'));
            return $pdf->download($filename);
        }

        Mail::send(new AdditionalDocumentMail($data));

        return back()->with('success', "Successfully sent the email");
    }


    public function createrel(Request $request, $id)
    {
        $data = array();
        $data['basic_info_id'] = $id;
        $data['basic_info'] = BasicInfo::findOrFail($id);
        $data['payload'] = optional($data['basic_info']->additionaldata()->where('type', 'rel')->first())->content;
        return view('admin.additionaldocument.create.rel', compact('data'));
    }


    public function storerel(Request $request, $id)
    {
        $client = BasicInfo::findOrFail($id);
        $rules = [
            'client_name' => "required",
            'address' => "nullable",
            'mobile' => "nullable",
            'email' => "nullable",
            'action' => 'required',
            'application_type' => 'required',
            'parental_address' => 'nullable',
            'date' => 'nullable'
        ];

        $rules['passport_number'] = 'required';
        $rules['immigration_application_id'] = 'required';


        $data = $this->validate($request, $rules);

        AdditionalDocumentData::updateOrInsert(['basic_info_id' => $id, 'type' => 'rel'], ['content' => json_encode($request->all())]);

        $data['client'] = $client;
        $data['basic_info_id'] = $id;
        $data['company_info'] = CompanyInfo::first();

        if ($request->action == "pdf_rel") {
            $filename = $data['basic_info_id'] . '-' . $data['client_name'] . " - Representation letter.pdf";
            $data['application'] = ImmigrationApplication::findOrFail($data['immigration_application_id']);
            $pdf = PDF::loadView('admin.additionaldocument.pdfs.rel', compact('data'));
            return $pdf->download($filename);
        }

        Mail::send(new AdditionalDocumentMail($data));

        return back()->with('success', "Successfully sent the email");
    }



    public function createspd(Request $request, $id)
    {
        $data = array();
        $data['basic_info_id'] = $id;
        $data['basic_info'] = BasicInfo::findOrFail($id);
        $data['payload'] = optional($data['basic_info']->additionaldata()->where('type', 'spd')->first())->content;
        return view('admin.additionaldocument.create.spd', compact('data'));
    }


    public function storespd(Request $request, $id)
    {
        $client = BasicInfo::findOrFail($id);
        $rules = [
            'action' => 'required',

            'date' => 'nullable',
            'declaration' => 'nullable'

        ];
        $rules['authorised_person_name'] = 'nullable';
        $rules['authorised_person_contact'] = 'nullable';
        $rules['authorised_person_dob'] = 'nullable';
        // $rules['authorised_person_relationship'] = 'nullable';
        $rules['authorised_person_address'] = 'nullable';
        $rules['authorised_person_email'] = 'nullable';

        // $rules['passport_number'] = 'required';
        // $rules['immigration_application_id'] = 'required';


        $data = $this->validate($request, $rules);

        AdditionalDocumentData::updateOrInsert(['basic_info_id' => $id, 'type' => 'spd'], ['content' => json_encode($request->all())]);

        $data['client'] = $client;
        $data['basic_info_id'] = $id;
        $data['company_info'] = CompanyInfo::first();

        if ($request->action == "pdf_spd") {
            $filename = $data['basic_info_id'] . '- ' . $data['authorised_person_name'] . " - Sponsor Declaration.pdf";
            $pdf = PDF::loadView('admin.additionaldocument.pdfs.spd', compact('data'));
            // dd($pdf);
            return $pdf->download($filename);
        }

        Mail::send(new AdditionalDocumentMail($data));

        return back()->with('success', "Successfully sent the email");
    }


    public function createapd(Request $request, $id)
    {
        $data = array();
        $data['basic_info_id'] = $id;
        $data['basic_info'] = BasicInfo::findOrFail($id);
        $data['payload'] = optional($data['basic_info']->additionaldata()->where('type', 'apd')->first())->content;
        return view('admin.additionaldocument.create.apd', compact('data'));
    }


    public function storeapd(Request $request, $id)
    {
        $client = BasicInfo::findOrFail($id);
        $rules = [
            'action' => 'required',

            'date' => 'nullable',
            'declaration' => 'nullable'
        ];
        $rules['client_name'] = 'nullable';
        $rules['client_contact'] = 'nullable';
        $rules['client_dob'] = 'nullable';
        // $rules['client_relationship'] = 'nullable';
        $rules['client_address'] = 'nullable';
        $rules['client_email'] = 'nullable';

        // $rules['passport_number'] = 'required';
        // $rules['immigration_application_id'] = 'required';


        $data = $this->validate($request, $rules);

        AdditionalDocumentData::updateOrInsert(['basic_info_id' => $id, 'type' => 'apd'], ['content' => json_encode($request->all())]);
        $data['client'] = $client;
        $data['basic_info_id'] = $id;
        $data['company_info'] = CompanyInfo::first();

        if ($request->action == "pdf_apd") {
            $filename = $data['basic_info_id'] . '- ' . $data['client_name'] . " - Applicant Declaration.pdf";
            $pdf = PDF::loadView('admin.additionaldocument.pdfs.apd', compact('data'));
            return $pdf->download($filename);
        }

        Mail::send(new AdditionalDocumentMail($data));

        return back()->with('success', "Successfully sent the email");
    }


    // Employee part

    public function createcoe(Request $request, $id)
    {
        $data = array();
        $data['employee_id'] = $id;
        $data['employee'] = Employee::findOrFail($id);
        $data['employees'] = Employee::whereStatus('active')->get();
        $data['advisors'] = Advisor::whereStatus("active")->get();
        $data['payload'] = optional($data['employee']->additionaldata()->where('type', 'coe')->first())->content;
        return view('admin.additionaldocument.create.coe', compact('data'));
    }


    public function storecoe(Request $request, $id)
    {
        $client = Employee::findOrFail($id);
        $rules = [
            'action' => 'required',
            'address' => 'required',
            'employee_name' => 'required',
            'employee_id' => 'required',
            'employment_info_id' => "required",
            'date' => 'nullable',
            'job_description' => 'required',
            'agreement_date' => 'nullable',
            'director_id' => 'required',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpeg,bmp,png,pdf'
        ];
        // $rules['passport_number'] = 'required';
        // $rules['immigration_application_id'] = 'required';


        $data = $this->validate($request, $rules);

        AdditionalDocumentData::updateOrInsert(['employee_id' => $id, 'type' => 'coe'], ['content' => json_encode($request->all())]);
        $data['employee'] = $client;
        $data['employee_id'] = $id;
        $data['director'] = Employee::findOrFail($data['director_id']);
        $data['company_info'] = CompanyInfo::first();
        $data['employment_info'] = EmploymentInfo::findOrFail($data['employment_info_id']);
        if ($request->action == "pdf_coe") {
            $filename = $data['employee_id'] . '- ' . $data['employee_name'] . " - Contract of employment.pdf";
            $pdf = PDF::loadView('admin.additionaldocument.pdfs.coe', compact('data'));
            return $pdf->download($filename);
        }

        if ($request->action == "preview_coe") {
            $filename = $data['employee_id'] . '- ' . $data['employee_name'] . " - Contract of employment.pdf";
            $pdf = PDF::loadView('admin.additionaldocument.pdfs.coe', compact('data'));
            return $pdf->stream($filename);
        }

        if ($request->action == "pdf_epp") {
            $filename = $data['employee_id'] . '- ' . $data['employee_name'] . " - Employment Privacy Policy.pdf";
            $pdf = PDF::loadView('admin.additionaldocument.pdfs.epp', compact('data'));
            return $pdf->download($filename);
        }


        Mail::send(new AdditionalDocumentMail($data));

        return back()->with('success', "Successfully sent the email");
    }


    public function createec(Request $request, $id)
    {
        $data = array();
        $data['employee_id'] = $id;
        $data['employee'] = Employee::findOrFail($id);
        $data['employees'] = Employee::whereStatus('active')->get();
        $data['payload'] = optional($data['employee']->additionaldata()->where('type', 'ec')->first())->content;
        return view('admin.additionaldocument.create.ec', compact('data'));
    }


    public function storeec(Request $request, $id)
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
            'content'=>'nullable'
        ];
        // return view($request->content)->render();
        // $rules['passport_number'] = 'required';
        // $rules['immigration_application_id'] = 'required';


        $data = $this->validate($request, $rules);

        AdditionalDocumentData::updateOrInsert(['employee_id' => $id, 'type' => 'ec'], ['content' => json_encode($request->all())]);
        $data['employee'] = $client;
        $data['employee_id'] = $id;
        $data['letter_signer'] = Employee::findOrFail($data['letter_signer_id']);
        $data['company_info'] = CompanyInfo::first();
        $data['employment_info'] = EmploymentInfo::findOrFail($data['employment_info_id']);

        if ($request->action == "pdf_ec") {
            $filename = $data['employee_id'] . '- ' . $data['employee_name'] . " - Employment Confirmation.pdf";
            $pdf = PDF::loadView('admin.additionaldocument.pdfs.ec', compact('data'));
            return $pdf->download($filename);
        }

        if ($request->action == "preview_ec") {
            $filename = $data['employee_id'] . '- ' . $data['employee_name'] . " - Employment Confirmation.pdf";
            $pdf = PDF::loadView('admin.additionaldocument.pdfs.ec', compact('data'));
            return $pdf->stream($filename);
        }


        Mail::send(new AdditionalDocumentMail($data));

        return back()->with('success', "Successfully sent the email");
    }


    public function createnok(Request $request, $id)
    {
        $data = array();
        $data['employee_id'] = $id;
        $data['employee'] = Employee::findOrFail($id);
        $data['payload'] = optional($data['employee']->additionaldata()->where('type', 'nok')->first())->content;
        return view('admin.additionaldocument.create.nok', compact('data'));
    }


    public function storenok(Request $request, $id)
    {
        $client = Employee::findOrFail($id);
        $rules = [
            'employee_name' => "nullable",
            'address' => "required",
            'mobile' => "required",
            'contact' => 'nullable',
            'email' => "required",
            'action' => 'required',
            'date' => 'nullable|string'
        ];

        $rules['next_of_kin_name'] = 'nullable';
        $rules['next_of_kin_contact'] = 'nullable';
        $rules['next_of_kin_email'] = 'nullable';
        $rules['next_of_kin_relationship'] = 'nullable';
        $rules['next_of_kin_address'] = 'nullable';

        // $rules['passport_number'] = 'required';
        // $rules['immigration_application_id'] = 'required';


        $data = $this->validate($request, $rules);

        AdditionalDocumentData::updateOrInsert(['employee_id' => $id, 'type' => 'nok'], ['content' => json_encode($request->all())]);
        $data['employee'] = $client;
        $data['employee_id'] = $id;
        $data['employee_name'] = $data['employee']->full_name;

        $data['company_info'] = CompanyInfo::first();

        if ($request->action == "pdf_nok") {
            $filename = $data['employee_id'] . '- ' . $data['employee_name'] . " - Next of Kin Form.pdf";
            $pdf = PDF::loadView('admin.additionaldocument.pdfs.nok', compact('data'));
            return $pdf->download($filename);
        }

        if ($request->action == "preview_nok") {
            $filename = $data['employee_id'] . '- ' . $data['employee_name'] . " - Next of Kin Form.pdf";
            $pdf = PDF::loadView('admin.additionaldocument.pdfs.nok', compact('data'));
            return $pdf->stream($filename);
        }


        Mail::send(new AdditionalDocumentMail($data));

        return back()->with('success', "Successfully sent the email");
    }





    public function createeci(Request $request, $id)
    {
        $data = array();
        $data['employee_id'] = $id;
        $data['employee'] = Employee::findOrFail($id);
        $data['payload'] = optional($data['employee']->additionaldata()->where('type', 'eci')->first())->content;
        return view('admin.additionaldocument.create.eci', compact('data'));
    }


    public function storeeci(Request $request, $id)
    {
        $client = Employee::findOrFail($id);
        $rules = [
            'employee_name' => "nullable",
            'address' => "required",
            'mobile' => "required",
            'contact' => 'nullable',
            'email' => "required",
            'action' => 'required',
            'date' => 'nullable|string'
        ];

        $rules['next_of_kin_name'] = 'nullable';
        $rules['next_of_kin_contact'] = 'nullable';
        $rules['next_of_kin_email'] = 'nullable';
        $rules['next_of_kin_relationship'] = 'nullable';
        $rules['next_of_kin_address'] = 'nullable';

        // $rules['passport_number'] = 'required';
        // $rules['immigration_application_id'] = 'required';


        $data = $this->validate($request, $rules);

        AdditionalDocumentData::updateOrInsert(['employee_id' => $id, 'type' => 'eci'], ['content' => json_encode($request->all())]);
        $data['employee'] = $client;
        $data['employee_id'] = $id;
        $data['employee_name'] = $data['employee']->full_name;

        $data['company_info'] = CompanyInfo::first();

        if ($request->action == "pdf_eci") {
            $filename = $data['employee_id'] . '- ' . $data['employee_name'] . " - Employee Contact Form.pdf";
            $pdf = PDF::loadView('admin.additionaldocument.pdfs.eci', compact('data'));
            return $pdf->download($filename);
        }

        if ($request->action == "preview_eci") {
            $filename = $data['employee_id'] . '- ' . $data['employee_name'] . " - Employee Contact Form.pdf";
            $pdf = PDF::loadView('admin.additionaldocument.pdfs.eci', compact('data'));
            return $pdf->stream($filename);
        }


        Mail::send(new AdditionalDocumentMail($data));

        return back()->with('success', "Successfully sent the email");
    }


    public function createeicl(Request $request, $id)
    {
        $data = array();
        $data['employee_id'] = $id;
        $data['employee'] = Employee::findOrFail($id);
        $data['employees'] = Employee::whereStatus('active')->get();
        $data['payload'] = optional($data['employee']->additionaldata()->where('type', 'eicl')->first())->content;
        return view('admin.additionaldocument.create.eicl', compact('data'));
    }


    public function storeeicl(Request $request, $id)
    {
        $client = Employee::findOrFail($id);
        $rules = [
            'employee_name' => "nullable",
            'address' => "required",
            'postal_code' => "required",
            'letter_signer_id' => 'nullable',
            'visa_id' => "required",
            'action' => 'required',
            'date' => 'nullable|string'
        ];

        // $rules['passport_number'] = 'required';
        // $rules['immigration_application_id'] = 'required';


        $data = $this->validate($request, $rules);

        AdditionalDocumentData::updateOrInsert(['employee_id' => $id, 'type' => 'eicl'], ['content' => json_encode($request->all())]);
        $data['employee'] = $client;
        $data['employee_id'] = $id;
        $data['employee_name'] = $data['employee']->full_name;

        $data['company_info'] = CompanyInfo::first();
        $data['visa'] = Visa::findOrFail($data['visa_id']);
        $data['letter_signer'] = Employee::findOrFail($data['letter_signer_id']);
        if ($request->action == "pdf_eicl") {
            $filename = $data['employee_id'] . '- ' . $data['employee_name'] . " - Employee Contact Form.pdf";
            $pdf = PDF::loadView('admin.additionaldocument.pdfs.eicl', compact('data'));
            return $pdf->download($filename);
        }

        if ($request->action == "preview_eicl") {
            $filename = $data['employee_id'] . '- ' . $data['employee_name'] . " - Employee Contact Form.pdf";
            $pdf = PDF::loadView('admin.additionaldocument.pdfs.eicl', compact('data'));
            return $pdf->stream($filename);
        }


        Mail::send(new AdditionalDocumentMail($data));

        return back()->with('success', "Successfully sent the email");
    }

    //aacl

    public function createaacl(Request $request, $id)
    {
        $data = array();
        $data['employee_id'] = $id;
        $data['employee'] = Employee::findOrFail($id);
        $data['employees'] = Employee::whereStatus('active')->get();
        $data['payload'] = optional($data['employee']->additionaldata()->where('type', 'aacl')->first())->content;
        return view('admin.additionaldocument.create.aacl', compact('data'));
    }


    public function storeaacl(Request $request, $id)
    {
        $client = Employee::findOrFail($id);
        $rules = [
            'employee_name' => "nullable",
            'address' => "required",
            'postal_code' => "required",
            'letter_signer_id' => 'nullable',
            'visa_id' => "required",
            'action' => 'required',
            'date' => 'nullable|string'
        ];

        // $rules['passport_number'] = 'required';
        // $rules['immigration_application_id'] = 'required';


        $data = $this->validate($request, $rules);

        AdditionalDocumentData::updateOrInsert(['employee_id' => $id, 'type' => 'aacl'], ['content' => json_encode($request->all())]);
        $data['employee'] = $client;
        $data['employee_id'] = $id;
        $data['employee_name'] = $data['employee']->full_name;

        $data['company_info'] = CompanyInfo::first();
        $data['visa'] = Visa::findOrFail($data['visa_id']);
        $data['letter_signer'] = Employee::findOrFail($data['letter_signer_id']);
        if ($request->action == "pdf_aacl") {
            $filename = $data['employee_id'] . '- ' . $data['employee_name'] . " - Employee Contact Form.pdf";
            $pdf = PDF::loadView('admin.additionaldocument.pdfs.aacl', compact('data'));
            return $pdf->download($filename);
        }

        if ($request->action == "preview_aacl") {
            $filename = $data['employee_id'] . '- ' . $data['employee_name'] . " - Employee Contact Form.pdf";
            $pdf = PDF::loadView('admin.additionaldocument.pdfs.aacl', compact('data'));
            return $pdf->stream($filename);
        }


        Mail::send(new AdditionalDocumentMail($data));

        return back()->with('success', "Successfully sent the email");
    }
}
