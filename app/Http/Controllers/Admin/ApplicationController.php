<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ImmigrationApplicationDataTable;
use Auth;
use Session;
use App\Models\BasicInfo;
use App\Models\ImmigrationApplication;
use App\Models\ImmigrationApplicationProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use App\Mail\ApplicationProcessMail;
use App\Mail\ImmigrationApplicationProcessMail;
use App\Models\Advisor;
use App\Models\CompanyInfo;
use App\Models\ImmigrationApplicationStatus;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PDF;


class ApplicationController extends BaseController
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
    public function index(ImmigrationApplicationDataTable $immig, Request $request)
    {
        // Auth::user()->authorizeRoles('admin');
        $data = [];
        $data['panel_name'] = 'Immigration Applications';
        $data['application_statuses'] = ImmigrationApplicationStatus::all();
        // $data['enquiry_type'] = EnquiryType::all();              
        // return view('admin.application.list',compact('data'));

        return $immig->with(['application_status_id' => $request->application_status_id, 'startdate' => $request->startdate, 'enddate' => $request->enddate,'status'=>$request->status])->render('admin.application.immigration.index', compact('data'));
    }

    public function addImmigration($basic_info_id)
    {
        $basic_info = BasicInfo::find($basic_info_id);
        if (!$basic_info_id || !$basic_info) {
            return "We cannot proccess immigration application process";
        }

        $data = [];
        $data['panel_name'] = 'Add Immigration Application';
        $data['row'] = $basic_info;
        $data['country_code'] = $this->country_code;
        $data['advisors'] = Advisor::where('status', 'active')->get();
        return view('admin.application.immigration.add', compact('data'));
    }

    public function storeImmigration(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'student_name' => "required",
            "basic_info_id"      => "required|exists:basic_infos,id",
            "iso_countrylist_id" => "required",
            "application_method" => "required",
            "note"               => "max:300",
            "documents"          => "file|mimes:jpeg,bmp,png,pdf",
            'date_submitted' => 'required|date',
            'file_opening_date' => 'required',
            'application_detail' => 'required',
            'advisor_id' => 'required|integer',
            'ref' => 'required|max:25',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $userId = Auth::user()->id;
            $file = $request->file('documents');

            $basic_info = BasicInfo::find($request->basic_info_id);
            if (!$request->basic_info_id || !$basic_info) {
                return "We cannot proccess immigration application process";
            }

            $extra = $request->basic_info_id;
            $path = $this->destinationPath . '/' . $extra;

            $file_uploaded_path = $this->saveUpdateFile($file, $filename = null, $path, $extra);
            $immigrationApplication = new ImmigrationApplication();
            $immigrationApplication->iso_countrylist_id = $request->iso_countrylist_id;
            $immigrationApplication->basic_info_id = $request->basic_info_id;
            $immigrationApplication->application_status_id = 1;
            $immigrationApplication->student_name = $request->student_name;
            $immigrationApplication->application_type = "immigration";
            $immigrationApplication->date_submitted = $request->date_submitted;
            $immigrationApplication->file_opening_date = $request->file_opening_date;
            $immigrationApplication->application_detail = $request->application_detail;
            $immigrationApplication->ref = $request->ref;
            $immigrationApplication->advisor_id = $request->advisor_id;


            $immigrationApplication->application_method = $request->application_method;
            $immigrationApplication->note = $request->note;
            $immigrationApplication->created_by = $userId;
            $immigrationApplication->updated_by = $userId;
            if ($immigrationApplication->save()) {
                $ImmigrationApplicationProcess = new ImmigrationApplicationProcess();
                $ImmigrationApplicationProcess->application_id = $immigrationApplication->id;
                $ImmigrationApplicationProcess->application_status_id = 1;
                $ImmigrationApplicationProcess->document = $file_uploaded_path;
                $ImmigrationApplicationProcess->note = $request->note;
                $ImmigrationApplicationProcess->created_by = $userId;
                $ImmigrationApplicationProcess->modified_by = $userId;

                $ImmigrationApplicationProcess->save();
                Session::flash('success', 'Immigration Application has been created.');
                return redirect()->route("client.show", ['id'=>$request->basic_info_id,'click'=>'applications']);

                // return redirect()->back();
            }
        } catch (Exception $e) {
            Session::flash('failed', 'Enquiry has could not be created. Due to ' . $e->getMessage() . ' error.');
            return redirect()->back();
        }
    }

    public function editImmigration($applicationId)
    {
        $application = ImmigrationApplication::find($applicationId);
        if (!$applicationId || !$application) {
            return "We cannot proccess immigration application process";
        }

        $data = [];
        $data['panel_name'] = 'Edit Immigration Application #' . $application->basicInfo->full_name;
        $data['row'] = $application;
        $data['country_code'] = $this->country_code;
        $data['advisors'] = Advisor::where('status', 'active')->get();

        return view('admin.application.immigration.edit', compact('data'));
    }

    public function updateImmigration(Request $request, $applicationId)
    {
        $validator = \Validator::make($request->all(), [
            'student_name' => "required",
            "basic_info_id"      => "required|exists:basic_infos,id",
            "iso_countrylist_id" => "required",
            "application_method" => "required",
            "note"               => "max:300",
            "advisor_id"        => 'required|integer',
            'ref' => "required|max:25",
            "date_submitted" => "required|date",
            'file_opening_date' => 'required',
            'application_detail' => 'required',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $userId = Auth::user()->id;

            $application = ImmigrationApplication::find($applicationId);
            if (!$applicationId || !$application) {
                return "We cannot proccess immigration application process";
            }

            $basic_info = BasicInfo::find($request->basic_info_id);
            if (!$request->basic_info_id || !$basic_info) {
                return "We cannot proccess immigration application process";
            }

            $extra = $request->basic_info_id;

            $application->iso_countrylist_id    = $request->iso_countrylist_id;
            $application->basic_info_id         = $request->basic_info_id;
            $application->application_status_id = $application->application_status_id;
            $application->student_name          = $request->student_name;
            $application->application_type      = "immigration";
            $application->ref = $request->ref;
            $application->date_submitted = $request->date_submitted;
            $application->application_method    = $request->application_method;
            $application->file_opening_date = $request->file_opening_date;
            $application->application_detail = $request->application_detail;
            $application->note                  = $request->note;
            $application->created_by            = $application->created_by;
            $application->updated_by            = $userId;
            $application->advisor_id = $request->advisor_id;


            if ($application->save()) {
                Session::flash('success', 'Immigration Application has been updated.');
                if (!$request->redirect_to_client) {
                    return redirect()->route('application.immigration.index');
                }
                return redirect()->route("client.show", ['id'=>$request->basic_info_id,'click'=>'applications']);
            }
        } catch (Exception $e) {


            Session::flash('failed', 'Enquiry has could not be created. Due to ' . $e->getMessage() . ' error.');
            return redirect()->back();
        }
    }

    public function applicationImmigrationLogs($applicationId)
    {
        $application = ImmigrationApplication::find($applicationId);
        if (!$applicationId || !$application) {
            return "We cannot proccess immigration application process";
        }

        $data = [];
        $data['application'] = $application;
        $data['basic_info_id'] = $application->basicInfo->id;
        $data['panel_name'] = 'Log of Immigration Application #' . $application->basicInfo->full_name;
        $data['applicationLogs'] = $application->applicationProcesses()->orderby('application_status_id', 'desc')->get();
        $data['applicationLogsStatuses'] = \App\Models\ImmigrationApplicationStatus::get();
        // dd($data['applicationLogs']);
        $data['country_code'] = $this->country_code;
        return view('admin.application.immigration.log.list', compact('data'));
    }

    public function storeApplicationImmigrationLogs(Request $request, $applicationId)
    {
        $data = $this->validate($request, [
            'application_status_id' => 'required|integer',
            'note' => 'nullable|string',
            'document' => "file|mimes:png,bmp,jpg,doc,pdf,docx|nullable",
            'reason' => 'nullable|string',
            'date' => 'nullable|string'
        ]);


        $data['created_by'] = $data['modified_by'] = auth()->user()->id;

        $application = ImmigrationApplication::find($applicationId);
        if (!$applicationId || !$application) {
            return "We cannot proccess immigration application process";
        }

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $extra =  $application->basic_info_id;
            $path = $this->destinationPath . '/' . $extra;

            $file_uploaded_path = $this->saveUpdateFile($file, $filename = null, $path, $extra);
            $data['document'] = $file_uploaded_path;
        } else {
            $data['document'] = '';
        }

        $data['application_id'] = $applicationId;

        $i = ImmigrationApplicationProcess::create($data);

        $application->application_status_id = $i->application_status_id;
        $application->save();

        if ($i->application_status_id == config('constant.file_closed_id')) {
            $i->application->client->status = "Inactive";
            $i->application->client->delete_at = now()->addMonths(config('cms.delete_after'));
            $i->application->client->save();
        }

        Session::flash('success', 'Immigration Application Process has been added.');
        return redirect()->back();
    }


    public function updateApplicationImmigrationProcess(Request $request, $id)
    {

        $data = $this->validate($request, [
            "document" => "file|mimes:jpeg,bmp,png,pdf|nullable",
            'application_status_id' => 'required|integer',
            'application_process_id' => 'required|integer',
            'note' => 'nullable|string|max:300',
            'reason' => 'nullable|string',
            'date' => 'nullable|string'
        ]);

        try {
            $userId = Auth::user()->id;

            $applicationProcess = ImmigrationApplicationProcess::find($data['application_process_id']);
            if (!$applicationProcess) {
                return "We cannot proccess immigration application process";
            }

            // $basic_info = BasicInfo::find($request->basic_info_id);
            // if (!$request->basic_info_id || !$basic_info) {
            //     return "We cannot proccess immigration application process";
            // }

            // $extra = $request->basic_info_id;

            //$applicationProcess->document ='';
            if ($request->hasFile('document')) {
                $extra = $applicationProcess->application->basic_info_id;
                $path = $this->destinationPath . '/' . $extra;

                $file_uploaded_path = $this->saveUpdateFile($request->file('document'), $filename = null, $path, $extra);

                $applicationProcess->document = $file_uploaded_path;
            }
            $applicationProcess->note = $data['note'];
            $applicationProcess->application_status_id = $data['application_status_id'];
            $applicationProcess->modified_by = $userId;
            $applicationProcess->reason = $data['reason'];
            if ($data['date'] != null) {
                $applicationProcess->date = $data['date'];
            }




            if ($applicationProcess->save()) {

                if ($applicationProcess->application_status_id == config('constant.file_closed_id')) {
                    $applicationProcess->application->client->status = "Inactive";
                    $applicationProcess->application->client->delete_at = now()->addMonths(config('cms.delete_after'));

                } else {
                    $applicationProcess->application->client->status = "Active";
                    $applicationProcess->application->client->delete_at = null;
                }

                $applicationProcess->application->application_status_id = $applicationProcess->application_status_id;
                $applicationProcess->application->save();
                $applicationProcess->application->client->save();

                Session::flash('success', 'Immigration Application Process has been updated.');
                return redirect()->back();
            }
        } catch (Exception $e) {

            Session::flash('failed', 'Immigration application process has not been updated. Due to ' . $e->getMessage() . ' error.');
            return redirect()->back();
        }
    }


    public function viewApplicationImmigrationProcess($id)
    {
        $applicationProcess = ImmigrationApplicationProcess::find($id);
        if (!$applicationProcess) {
            return "We cannot proccess immigration application process";
        }
        $data['application_id'] = $applicationProcess->application_id;
        $data['applicationProcess'] = $applicationProcess;

        return view('admin.application.immigration.log.view', compact('data'));
    }

    public function deleteApplicationImmigrationProcess(Request $request)
    {
        $data  = $request->all();
        $applicationProcess = ImmigrationApplicationProcess::findOrFail($data['application_process_id']);
        $applicationProcess->delete();
        Session::flash('success', 'Immigration Application Process has been successfully deleted.');
        return redirect()->back();
    }


    public function getDownload($file)
    {
        // $file_location = public_path("/uploads/files/" . base64_decode($file));
        // // dd($file_location);
        // return response()->file($file_location);
        $fileName = base64_decode($file);

        if (!$fileName || !Storage::disk('uploads')->exists($fileName)) {
            abort(404);
        }
        return Storage::disk('uploads')->download($fileName);
      
        // return Storage::disk('uploads')->response($fileName,Storage::disk('uploads')->($fileName)->getClientOriginalName());
        // if (!$fileName || !Storage::disk('uploads')->exists($fileName)) {
        //     abort(404);
        // }
    
        // $file = Storage::disk('uploads')->get($fileName);
    
        // return response()->download($file, $fileName, [
        //     'Content-Type'  => Storage::disk('uploads')->mimeType($fileName),
        // ]);

        
    }
    
    public function getFile($file)
    {
        $fileName = base64_decode($file);
        if (!$fileName || !Storage::disk('uploads')->exists($fileName)) {
            abort(404);
        }
        ob_clean();
        return Storage::disk('uploads')->download($fileName);        
    }


    public function emailApplicationImmigrationProcess(Request $request)
    {
        $data = $request->all();
        $data['attachments'] = $request->attachments;

        $data['application_process'] = ImmigrationApplicationProcess::with('application.client')->findOrFail($data['application_process_id']);
        $data['companyinfo'] = CompanyInfo::first();
        $mail = new ImmigrationApplicationProcessMail($data);
        // $pdf = PDF::loadView('admin.application.immigration.log.pdf.file_closed', compact('data'));
        // return $pdf->stream();
        Mail::to('admin@wlisuk.com')->send($mail);
        return back()->with("success", 'Successsfully done');
    }


    public function destroy(Request $request){
        $id = $request->application_id;
        $im  = ImmigrationApplication::findOrFail($id);
        if($im->applicationProcesses->count() == 0){
            $im->delete();
            return back()->with("success","Successfully deleted the application");
        }

        return back()->with("failed","Please delete the application process first");

    }
}
