<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AdmissionApplicationDataTable;
use Auth;
use Session;
use App\Models\BasicInfo;
use App\Models\ImmigrationApplication;
use App\Models\ImmigrationApplicationProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use App\Mail\AdmissionApplicationProcessMail;
use App\Models\AdmissionApplication;
use App\Models\AdmissionApplicationProcess;
use App\Models\AdmissionApplicationStatus;
use App\Models\CompanyInfo;
use App\Models\IsoCountry;
use App\Models\Partner;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class AdmissionApplicationController extends BaseController
{
    private $title;
    private $country_code;
    private $enquiry_type;
    private $users;
    private $destinationPath;


    public function __construct()
    {
        $this->middleware('auth');
        $this->title = $this->getTitle();
        $this->country_code = $this->getCounrtyCode();
        $this->destinationPath = 'uploads/files';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AdmissionApplicationDataTable $immig,Request $request)
    {
        // Auth::user()->authorizeRoles('admin');
        $data = [];
        $data['panel_name'] = 'Admission Applications';
        $data['application_statuses'] = AdmissionApplicationStatus::all();
        // $data['enquiry_type'] = EnquiryType::all();              
        // return view('admin.application.list',compact('data'));

        return $immig->with(['application_status_id'=>$request->application_status_id])->render('admin.application.admission.index',compact('data'));
    }
    public function create($basic_info_id)
    {
        $basic_info = BasicInfo::find($basic_info_id);
        if (!$basic_info_id || !$basic_info) {
            return "We cannot proccess immigration application process";
        }

        $data = [];
        $data['panel_name'] = 'Add Admission Application';
        $data['basic_info'] = $basic_info;
        $data['partners'] = array();
        $data['application'] =  new AdmissionApplication;
        $data['countries'] = $this->country_code;
        return view('admin.application.admission.add', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            "basic_info_id"      => "required",
            "iso_countrylist_id" => "required",
            "partner_id" => "required",
            "course_name" => "required",
            "course_start" => "required",
            "application_method" => "required",
            "remarks" => "max:300",
            "document" => "required|file|mimes:jpeg,bmp,png,pdf",
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $userId = Auth::user()->id;
            $file = $request->file('document');

            $basic_info = BasicInfo::find($request->basic_info_id);
            if (!$request->basic_info_id || !$basic_info) {
                return "We cannot proccess immigration application process";
            }

            $name = time() . "-" . $request->file('document')->getClientOriginalName();

            $path = $request->file('document')->storeAs(
                'admissions',
                $name,
                "uploads"
            );
            $data = $validator->valid();
            $data['created_by'] = $data['updated_by'] = $userId;
            $data['application_status_id'] = 1;
            $data['student_name'] = $basic_info->full_name;

            $admissionApplication = AdmissionApplication::create($data);

            if ($admissionApplication->id) {
                //todo
                $AdmissionApplicationProcess = new AdmissionApplicationProcess();
                $AdmissionApplicationProcess->application_id = $admissionApplication->id;
                $AdmissionApplicationProcess->application_status_id = 1;
                $AdmissionApplicationProcess->document = $path;
                $AdmissionApplicationProcess->note = $request->note;
                $AdmissionApplicationProcess->created_by = $userId;
                $AdmissionApplicationProcess->modified_by = $userId;

                $AdmissionApplicationProcess->save();

                Session::flash('success', 'Admission Application has been created.');
                return redirect()->route("client.show", ['id'=>$basic_info->id,'click'=>'applications']);
            }
        } catch (Exception $e) {
            Session::flash('failed', 'Admission Application could not be created. Due to ' . $e->getMessage() . ' error.');
            return redirect()->back();
        }
    }

    public function edit($applicationId)
    {
        $application = AdmissionApplication::with('basicInfo')->find($applicationId);
        if (!$applicationId || !$application) {
            return "We cannot proccess immigration application process";
        }

        $data = [];

        $data['panel_name'] = 'Edit Immigration Application #' . $application->basicInfo->full_name;
        $data['application'] = $application;
        $data['basic_info'] = $application->basicInfo;
        $data['countries'] = $this->country_code;
        $data['partners'] = Partner::where('iso_countrylist_id', $application->iso_countrylist_id)->get();
        return view('admin.application.admission.edit', compact('data'));
    }

    public function update(Request $request, $applicationId)
    {
        $validator = \Validator::make($request->all(), [
            "basic_info_id"      => "required",
            "iso_countrylist_id" => "required",
            "partner_id" => "required",
            "course_name" => "required",
            "course_start" => "required",
            "application_method" => "required",
            "remarks" => "max:300",
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $userId = Auth::user()->id;

            $application = AdmissionApplication::find($applicationId);
            if (!$applicationId || !$application) {
                return "We cannot proccess immigration application process";
            }

            $basic_info = BasicInfo::find($request->basic_info_id);
            if (!$request->basic_info_id || !$basic_info) {
                return "We cannot proccess immigration application process";
            }

            $extra = $request->basic_info_id;

            $data = $validator->valid();
            $data['updated_by'] = $userId;

            $application->update($data);
            Session::flash('success', 'Immigration Application has been updated.');
            return redirect()->back();
        } catch (Exception $e) {


            Session::flash('failed', 'Enquiry has could not be created. Due to ' . $e->getMessage() . ' error.');
            return redirect()->back();
        }
    }

    public function applicationLogs($applicationId)
    {
        $application = AdmissionApplication::find($applicationId);
        if (!$applicationId || !$application) {
            return "We cannot proccess immigration application process";
        }

        $data = [];
        $data['application'] = $application;
        $data['basic_info_id'] = $application->basicInfo->id;

        $data['panel_name'] = 'Log of admission application #' . $application->basicInfo->full_name;
        $data['applicationLogs'] = $application->applicationProcesses()->orderby('application_status_id', 'desc')->get();
        $data['applicationLogsStatuses'] = \App\Models\AdmissionApplicationStatus::get();
        // dd($data['applicationLogs']);
        $data['country_code'] = $this->country_code;
        return view('admin.application.admission.log.list', compact('data'));
    }


    public function showApplicationProcess($id)
    {
        $applicationProcess = AdmissionApplicationProcess::find($id);
        if (!$applicationProcess) {
            return "We cannot proccess immigration application process";
        }
        $data['application_id'] = $applicationProcess->application_id;
        $data['applicationProcess'] = $applicationProcess;

        return view('admin.application.admission.log.view', compact('data'));
    }



    public function storeApplicationLogs(Request $request, $applicationId)
    {
        $data = $this->validate($request, [
            'application_status_id' => 'required|integer',
            'note' => 'nullable|string',
            'document' => "file|mimes:png,bmp,jpg,doc,pdf,docx,jpeg|nullable"
        ]);

        $data['created_by'] = $data['modified_by'] = auth()->user()->id;

        $application = AdmissionApplication::find($applicationId);
        if (!$applicationId || !$application) {
            return "We cannot proccess immigration application process";
        }

        if ($request->hasFile('document')) {
            $name = time() . "-" . $request->file('document')->getClientOriginalName();

            $path = $request->file('document')->storeAs(
                'admission_logs',
                $name,
                "uploads"
            );
            $data['document'] = $path;
        } else {
            $data['document'] = '';
        }

        $data['application_id'] = $applicationId;

        $i  = AdmissionApplicationProcess::create($data);

        $application->application_status_id = $i->application_status_id;
        $application->save();

        // if($i->application_status_id == config('constant.file_closed_id')){
        //     $i->application->client->status = "Inactive";
        //     $i->application->client->save();
        // }

        Session::flash('success', 'Immigration Application Process has been added.');
        return redirect()->back();
    }


    public function updateApplicationProcess(Request $request, $id)
    {
        $data = $this->validate($request, [
            "document" => "file|mimes:jpeg,bmp,png,pdf|nullable",
            'application_status_id' => 'required|integer',
            'application_process_id' => 'required|integer',
            'note' => 'nullable|string|max:300',
        ]);

        try {
            $userId = Auth::user()->id;

            $applicationProcess = AdmissionApplicationProcess::find($data['application_process_id']);
            if (!$applicationProcess) {
                return "We cannot proccess admission application process";
            }


            if ($request->hasFile('document')) {
                $name = time() . "-" . $request->file('document')->getClientOriginalName();

                $path = $request->file('document')->storeAs(
                    'admission_logs',
                    $name,
                    "uploads"
                );

                Storage::disk("uploads")->delete($applicationProcess->document);

                $applicationProcess->document = $path;
            }
            $applicationProcess->note = $data['note'];
            $applicationProcess->application_status_id = $data['application_status_id'];
            $applicationProcess->modified_by = $userId;




            if ($applicationProcess->save()) {

                // if ($applicationProcess->application_status_id == config('constant.file_closed_id')) {
                //     $applicationProcess->application->client->status = "Inactive";
                // } else {
                //     $applicationProcess->application->client->status = "Active";
                // }
                // $applicationProcess->application->client->save();
                $applicationProcess->application->application_status_id = $applicationProcess->application_status_id;
                $applicationProcess->application->save();

                Session::flash('success', 'Admission Application Process has been updated.');
                return redirect()->back();
            }
        } catch (Exception $e) {

            Session::flash('failed', 'Admission application process has not been updated. Due to ' . $e->getMessage() . ' error.');
            return redirect()->back();
        }
    }

    public function deleteApplicationProcess(Request $request)
    {
        $data  = $request->all();
        $applicationProcess = AdmissionApplicationProcess::findOrFail($data['application_process_id']);
        $applicationProcess->delete();
        Session::flash('success', 'Immigration Application Process has been successfully deleted.');
        return redirect()->back();
    }


    public function email(Request $request)
    {
        $data = $request->all();
        $data['attachments'] = $request->attachments;
        $data['application_process'] = AdmissionApplicationProcess::with('application.client')->findOrFail($data['application_process_id']);
        $data['companyinfo'] = CompanyInfo::first();
        $mail = new AdmissionApplicationProcessMail($data);
        // $pdf = PDF::loadView('admin.application.admission.log.pdf.application_submitted', compact('data'));
        // return $pdf->stream();
        Mail::to('admin@wlisuk.com')->send($mail);
        return back()->with("success", 'Successsfully done');
    }

    public function destroy(Request $request){
        $id = $request->application_id;
        $im  = AdmissionApplication::findOrFail($id);
        if($im->applicationProcesses->count() == 0){
            $im->delete();
            return back()->with("success","Successfully deleted the application");
        }

        return back()->with("failed","Please delete the application process first");

    }

    //housekeeping

   
}
