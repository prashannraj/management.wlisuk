<?php

namespace App\Http\Controllers\Admin;

use App\ClientCare;
use App\EnquiryCare;
use App\LetterOfAuthority;
use App\LetterToFirms;
use App\RequestToMedical;
use App\RequestToFinance;
use App\CclApplication;
use App\RequestToTrbunal;
use App\SubjectAccess;
use App\FileOpeningForm;
use App\ClientOfAuthority;
use App\LteCcl;
use App\NewCcl;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Enquiry;
use App\Models\User;
use App\Models\EnquiryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\EnquiryStoreRequest;
use App\Http\Requests\EnquiryUpdateRequest;
use App\Mail\ClientcareMail;
use App\Mail\EnquirycareMail;
use App\Mail\LoaMail;
use App\Mail\LtfMail;
use App\Mail\RtmMail;
use App\Mail\RttMail;
Use App\Mail\SaMail;
use App\Mail\FoMail;
use App\Mail\CoaMail;
use App\Models\Advisor;
use App\Models\Bank;
use App\Models\ClientAddressDetail;
use App\Models\CompanyDocument;
use App\Models\CompanyInfo;
use App\Models\IsoCountry;
use App\Models\EnquiryActivity;
use App\Models\EnquiryFollowUp;
use App\Models\IsoCurrency;
use App\Models\Servicefee;
use App\Models\Template;
use App\Models\RawInquiry;
use App\Repositories\Enquiry\EnquiryInterface as EnquiryInterface;
use Carbon\Carbon;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Exception;
use Termwind\Components\Raw;

class EnquiryController extends BaseController
{
    private $enquiry;
    private $title;
    private $country_code;
    private $enquiry_type;
    private $users;

    public function __construct()
    {
        $this->middleware('auth');
        $this->title = $this->getTitle();
        $this->country_code = $this->getCounrtyCode();
        $this->enquiry_type = EnquiryType::select('id', 'title')->get();
        $this->users = User::select('id', 'username')->orderBy('username', 'asc')->get();
    }

    /**
     * Display a listing of the resource using Bootstrap table with pagination
     */
    public function index(Request $request)
    {
        $data = [];
        $data['panel_name'] = 'List of Enquiries';
        $data['enquiries'] = Enquiry::with(['type', 'assigned_user'])
                                ->orderBy('id', 'desc')
                                ->paginate(10); // 10 per page
        $data['enquiry_type'] = EnquiryType::all();
        return view('admin.inquiry.list', compact('data'));
    }


    

    public function unlink($id)
    {
        $enq = Enquiry::findOrFail($id);
        $enq->client_id = null;
        $enq->save();
        return back()->with('success', 'Successfully unlinked the enquiry');
    }

    public function create()
    {
        $data = [
            'panel_name' => 'Add New Enquiry',
            'title' => $this->title,
            'country_code' => $this->country_code,
            'enquiry_type' => $this->enquiry_type,
            'users' => $this->users
        ];
        return view('admin.inquiry.create', compact('data'));
    }

     public function editBasicInfo()
    {
        $data = [];
        $data['panel_name'] = 'Add New Enquiry';
        $data['title'] = $this->title;
        $data['country_code'] = $this->country_code;
        $data['enquiry_type'] = $this->enquiry_type;
        $data['users'] = $this->users;
        return view('admin.inquiry.create', compact('data'));
    }

    public function store(EnquiryStoreRequest $request)
    {
        try {
            $enquiry = Enquiry::create([
                'title' => $request->title,
                'surname' => $request->surname,
                'firstName' => $request->firstName,
                'middleName' => $request->middleName,
                'mobile_code' => $request->mobile_code,
                'mobile' => $request->mobile,
                'tel_code' => $request->tel_code,
                'tel' => $request->tel,
                'email' => $request->email,
                'enquiry_type' => $request->enquiry_type,
                'referral' => $request->referral,
                'assignedto' => $request->assignedto,
                'note' => $request->note
            ]);

            ClientAddressDetail::updateOrCreate(
                ['enquiry_id' => $enquiry->id, 'basic_info_id' => null],
                [
                    'overseas_address' => $request->address,
                    'overseas_postcode' => $request->postal_code,
                    'iso_countrylist_id' => $request->country_id,
                    'created_by' => Auth::id(),
                    'modified_by' => Auth::id(),
                ]
            );

            Session::flash('success', 'Enquiry has been created.');
            return redirect()->route('enquiry.list');
        } catch (Exception $e) {
            Session::flash('failed', 'Enquiry could not be created: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $data['enquiry'] = Enquiry::with(['type', 'addresses'])->findOrFail($id);
        $data['countries'] = IsoCountry::orderBy("order", "desc")->get();
        $data['panel_name'] = 'Detail of ' . $data['enquiry']->full_name;
        return view('admin.inquiry.show', compact('data'));
    }


    public function edit($id)
    {
        $data['row'] = Enquiry::findOrFail($id);
        $data['panel_name'] = 'Edit Enquiry';
        $data['title'] = $this->title;
        $data['country_code'] = $this->country_code;
        $data['enquiry_type'] = $this->enquiry_type;
        $data['users'] = $this->users;

        return view('admin.inquiry.edit', compact('data'));
    }

    public function update(EnquiryUpdateRequest $request, $id)
    {
        try {
            $enquiry = Enquiry::findOrFail($id);
            $enquiry->update([
                'title' => $request->title,
                'surname' => $request->surname,
                'firstName' => $request->firstName,
                'middleName' => $request->middleName,
                'mobile_code' => $request->mobile_code,
                'mobile' => $request->mobile,
                'tel_code' => $request->tel_code,
                'tel' => $request->tel,
                'email' => $request->email,
                'enquiry_type' => $request->enquiry_type,
                'referral' => $request->referral,
                'assignedto' => $request->assignedto,
                'note' => $request->note,
                'status' => $request->status
            ]);

            ClientAddressDetail::updateOrCreate(['enquiry_id' => $id, 'basic_info_id' => null], [
                'overseas_address' => $request->address,
                'overseas_postcode' => $request->postal_code,
                'iso_countrylist_id' => $request->country_id,
                'created_by' => Auth::id(),
                'modified_by' => Auth::id(),
            ]);

            Session::flash('success', 'Enquiry has been updated.');
            return redirect()->route('enquiry.list');
        } catch (Exception $e) {
            Session::flash('failed', 'Enquiry could not be updated: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $enquiry->delete();
        return redirect()->route('enquiry.list')->with("success", "Successfully deleted enquiry");
    }

    public function status(Request $request)
    {
        $id = $request->id;
        $activities = null;
        if ($id) {
            $enquiry = $this->enquiry->find($id);

            if ($enquiry) {
                $results['enquiry_for'] = $enquiry->full_name;
                $results['enquiry_id'] = $enquiry->id;
                $activities = $enquiry->activities;
                $results['activities'] = (count($activities) > 0) ? $activities : null;
            }
        }
        return $results;
    }

    public function statusUpdate(Request $request)
    {
        $userId = Auth::user()->id;
        $enquiryActivity = EnquiryActivity::find($request->activityId);
         
        if (!$enquiryActivity) {
        }
        $status = false;
        $selectedStatus = 1;
        if ($request->statusSelection == "2") {
            $selectedStatus = 2;
        } elseif ($request->statusSelection == "3") {
            $selectedStatus = 3;
        } elseif ($request->statusSelection == "4") {
            $selectedStatus = 4;
        }
        if ($request->activityType == "0") {
            if ($request->statusSelection == "2") {
                if ($enquiryActivity->enquiryFollowup) {
                    $enquiryFollowUp              = $enquiryActivity->enquiryFollowup;
                    $enquiryFollowUp->datetime    = date('Y-m-d', strtotime($request->followUpDate));
                    $enquiryFollowUp->note        = $request->followUpNote;
                    $enquiryFollowUp->status      = $selectedStatus;
                    $enquiryFollowUp->modified_by = $userId;
                    $status                       = $enquiryFollowUp->save();
                } else {
                    $enquiryFollowUp                      = new EnquiryFollowUp();
                    $enquiryFollowUp->datetime            = date('Y-m-d', strtotime($request->followUpDate));
                    $enquiryFollowUp->enquiry_activity_id = $enquiryActivity->id;
                    $enquiryFollowUp->note                = $request->followUpNote;
                    $enquiryFollowUp->status              = $selectedStatus;
                    $enquiryFollowUp->created_by          = $userId;
                    $status                               = $enquiryFollowUp->save();
                }
            } elseif ($request->statusSelection == "3" || $request->statusSelection == "4") {
                $enquiryActivity->note        = $enquiryActivity->statusNote;
                $enquiryActivity->processing  = 1;
                $enquiryActivity->status      = $selectedStatus;
                $enquiryActivity->note        = $request->statusNote;
                $enquiryActivity->modified_by = $userId;
                $status                       = $enquiryActivity->save();
            }
        } elseif ($request->activityType == "1") {
            $newEnquiryActivity                  = new EnquiryActivity();
            $newEnquiryActivity->enquiry_list_id = $enquiryActivity->enquiry_list_id;
            $newEnquiryActivity->note            = $request->statusNote;
            $newEnquiryActivity->processing      = 1;
            $newEnquiryActivity->status          = $selectedStatus;
            $newEnquiryActivity->created_by      = $userId;
            $status                              = $newEnquiryActivity->save();
        }
        return response()->json(['status' => $status], 200);
    }


    public function showLog($id)
    {
        $data = array();
        $data['log'] = EnquiryActivity::with('enquiry')->findOrFail($id);

        // dd($data);
        return view('admin.inquiry.showlog', compact('data'));
    }


    public function indexLog($id)
    {
        $data = array();

        $enquiry = Enquiry::with('clientcare')->findOrFail($id);
        $row = RawInquiry::latest()->first();
        $data['enquiry'] = $enquiry;

        $data['enquirycare'] = EnquiryCare::where('enquiry_id', $id)->first();
        if ($data['enquirycare'] == null) {
            $data['enquirycare'] = new EnquiryCare;
            $data['enquirycare']->full_address = optional($data['enquiry']->address)->full_address;
        }

        $data['advisors'] = Advisor::whereStatus("active")->get();
        $data['country_code'] = $this->country_code;
        $data['currencies'] = IsoCurrency::all();
        $data['banks'] = Bank::whereStatus("active")->get();
        $data['activities'] = $data['enquiry']->activities()->orderby('status', 'desc')->get();

        

        return view('admin.inquiry.log', compact('data'));
    }


    // New one

    public function storeLog(Request $request, $id)
    {
        $enq = Enquiry::findOrFail($id);
        $data =  $this->validate($request, [
            'note' => 'nullable',
            'status' => 'integer|required',
            'followup_date' => 'nullable|string'
        ]);

       $data['enquiry_list_id'] = $id;
        $data['created_by'] = Auth::id();
        $data['modified_by'] = Auth::id();

        $en = EnquiryActivity::create($data);

        if ($en->status == 2) {
            //followup
            EnquiryFollowUp::create(['enquiry_activity_id' => $en->id, 'date' => $data['followup_date']]);
        }

        if ($en->status == config('constant.enquiry_closed_id')) {
            $enq->status = "Inactive";
            $enq->save();
        }

        return back()->with('success', 'Successfully created enquiry log');
    }


    public function destroyLog(Request $request, $id)
    {
        $data = $request->all();
        $activity = EnquiryActivity::where('enquiry_list_id', $id)->where('id', $request->log_id)->firstOrFail();

        if ($activity->enquiryFollowUp) {
            $activity->enquiryFollowUp->delete();
        }

        $activity->delete();

        return back()->with('success', "Successfully deleted the enquiry log");
    }


    public function updateLog(Request $request)
    {
        $activity = EnquiryActivity::findOrFail($request->activity_id);
        $old_status = $activity->status;
        $data =  $this->validate($request, [
            'note' => 'nullable',
            'status' => 'integer|required',
            'followup_date' => 'nullable|string'
        ]);
        if ($data['followup_date'] != null)
            $data['followup_date'] = (Carbon::createFromFormat(config('constant.date_format'), $data['followup_date'])->format('Y-m-d'));

        $data['created_by'] = Auth::id();
        $data['modified_by'] = Auth::id();

        $activity->update($data);
        $enq = $activity->enquiry;

        if ($activity->status == 2) {
            //followup
            EnquiryFollowUp::updateOrInsert(['enquiry_activity_id' => $activity->id], ['date' => $data['followup_date'], 'followup_status' => null]);
        }

        if ($enq) {
            if ($activity->status == config('constant.enquiry_closed_id')) {
                $enq->status = "Inactive";
                $enq->save();
            } else if ($old_status == config('constant.enquiry_closed_id')) {
                $enq->status = "Active";
                $enq->save();
            }
        }

        return back()->with('success', 'Successfully updated enquiry log');
    }


    public function clientCare(Request $request, $id)
{

    $data = $this->validate($request, [
        'advisor_id' => "required",
        'full_address' => "required",
        'discussion_details' => "nullable",
        'full_name_with_title' => "nullable",
        'added_names_input' => 'nullable|json',
        'date' => "required",
        'agreed_fee_currency_id' => "required",
        'servicefee_id' => "required",
        'agreed_fee' => "required|numeric",
        'bank_id' => 'required',
        'attachments'=>'nullable|array',
        'attachments.*'=>'file|max:5120',
        'documents'=>'nullable|array',
        'documents.*'=>'integer'
    ]);
    // dd($data);
    $sendemail = false;

    if ($request->action == "Email") $sendemail = true;
    $preview = $request->action == "Preview";
    $download = $request->action == "Download";
    $cli_data = $data;

    $data['company_info'] = CompanyInfo::first();
    $data['enquiry'] = Enquiry::findOrFail($id);
    $data['advisor'] = Advisor::find($data['advisor_id']);
    if (!$data['advisor']) {
        return back()->with("failed", "Advisor not found.");
    }
    $data['bank'] = Bank::findOrFail($data['bank_id']);
    $data['agreed_fee_currency'] = IsoCurrency::findOrFail($data['agreed_fee_currency_id']);
    $data['servicefee'] = Servicefee::findOrFail($data['servicefee_id']);
    $data['enquiry_id'] = $id;
    $data['filename'] = "ENQ{$data['enquiry']->id} - {$data['enquiry']->full_name} - Client_Care_Letter";
    $data['discussion_content'] = $request->input('discussion_content'); // Add this line
    $addedNames = json_decode($request->input('added_names_input'), true);
    $data['enquiry']->addedNamesInput = json_encode($addedNames);
    $data['enquiry']->save();
    //save clientcare
    $cli_data['attachments'] = null;
    ClientCare::updateOrCreate(['enquiry_id' => $id], $cli_data);

    if ($preview) {
        $pdf = PDF::loadView("admin.inquiry.pdf.client_care_another", compact('data', 'addedNames'));
        return $pdf->stream();
    }

    if ($download) {
        $pdf = PDF::loadView("admin.inquiry.pdf.client_care_another", compact('data', 'addedNames'));
        return $pdf->download($data['filename'] . ".pdf");
    }
    if ($sendemail) {
        Mail::to('admin@wlisuk.com')
            ->send(new ClientcareMail($data));

        return back()->with("success", "Successfully sent client care");
    }

    return back()->with("success", "Successfully saved client care");
}




    public function enquiryCare(Request $request, $id)
    {

        $data = $this->validate($request, [
            'advisor_id' => "required",
            'full_address' => "required",
            'coverletter_content' => "required",
            'date' => "required",

        ]);
        $sendemail = false;

        if ($request->action == "Email") $sendemail = true;
        $preview = $request->action == "Preview";
        $download = $request->action == "Download";
        $cli_data = $data;

        $data['company_info'] = CompanyInfo::first();
        $data['enquiry'] = Enquiry::findOrFail($id);
        $data['advisor'] = Advisor::findOrFail($data['advisor_id']);
        $data['enquiry_id'] = $id;
        $data['filename'] = "ENQ{$data['enquiry']->id} - {$data['enquiry']->full_name} - Enquiry_Care_Letter";
        $data['attachments'] = $request->attachments;
        $data['documents'] = $request->documents;
        //save clientcare
        EnquiryCare::updateOrInsert(['enquiry_id' => $id], $cli_data);

        if ($preview) {
            $pdf = PDF::loadView("admin.inquiry.pdf.enquiry_care", compact('data'));
            return $pdf->stream();
        }

        if ($download) {
            $pdf = PDF::loadView("admin.inquiry.pdf.enquiry_care", compact('data'));
            return $pdf->download($data['filename'] . ".pdf");
        }
        if ($sendemail) {
            Mail::send(new EnquirycareMail($data));

            return back()->with("success", "Successfully sent enquiry care");
        }

        return back()->with("success", "Successfully saved enquiry care");
    }

    public function showClientCare($id)
    {

        $data = array();
        $data['enquiry'] = Enquiry::with('clientcare')->findOrFail($id);
        $data['clientcare'] = ClientCare::where('enquiry_id', $id)->first();
        if ($data['clientcare'] == null) {
            $data['clientcare'] = new ClientCare;
            $data['clientcare']->full_address = optional($data['enquiry']->address)->full_address;
            $data['clientcare']->advisor_id = 4;


        }

        $data['enquirycare'] = EnquiryCare::where('enquiry_id', $id)->first();
        if ($data['enquirycare'] == null) {
            $data['enquirycare'] = new EnquiryCare;
        }

        $data['country_code'] = $this->country_code;

        $data['currencies'] = IsoCurrency::all();
        $data['banks'] = Bank::whereStatus("active")->get();
        $data['documents']= CompanyDocument::all();
        $data['advisors'] = Advisor::whereStatus("active")->get();
        $data['advisor'] = Advisor::find($data['clientcare']['advisor_id']);


        if ($data['clientcare']['bank_id']) {
            $data['bank'] = Bank::findOrFail($data['clientcare']['bank_id']);
        }
        else {
            $data['bank'] = 'bank not found';
        }
        $data['agreed_fee'] = $data['clientcare']['agreed_fee'];
        $data['enquiry_id'] = $data['clientcare']['enquiry_id'];

        if ($data['clientcare']['agreed_fee_currency_id']) {
            $data['agreed_fee_currency'] = IsoCurrency::findOrFail($data['clientcare']['agreed_fee_currency_id']);
        }
        else {
            $data['agreed_fee_currency'] = 'currency not found';
        }

        if ($data['clientcare']['servicefee_id']) {
            $data['servicefee'] = Servicefee::findOrFail($data['clientcare']['servicefee_id']);
        }
        else {
            $data['servicefee'] = 'service fee not found';
        }
        $data['company_info'] = CompanyInfo::first();
        $data['discussion_content'] = $data['clientcare']['discussion_content'];

        //return $data['discussion_content'];
        // Set the $data['templates'] variable to the collection of templates
        $data['templates'] = Template::all();

        return view('admin.inquiry.client_care', compact('data'));
    }

    public function letterOfAuthority(Request $request, $id)
    {

        $data = $this->validate($request, [
            'client_name' => "required",
            'full_address' => "required",
            'parent_address'=>'nullable',
            'content' => "required",
            'date' => "required",
            'date_of_birth' => 'nullable',
            'nationality' => 'required',
            'email' => 'required',
            'attachments'=>'nullable|array',
            'attachments.*'=>'file|max:5120',
            'documents'=>'nullable|array',
            'documents.*'=>'integer'
        ]);
        //dd($data);

        $sendemail = false;

        if ($request->action == "Email") $sendemail = true;
        $preview = $request->action == "Preview";
        $download = $request->action == "Download";
        $cli_data = $data;
        $data['country_code'] = IsoCountry::all();
        $data['company_info'] = CompanyInfo::first();
        $data['enquiry'] = Enquiry::findOrFail($id);
        $data['enquiry_id'] = $id;
        $data['filename'] = "ENQ{$data['enquiry']->id} - {$data['enquiry']->full_name} - Letter_of_Authority_Non_client";
        $data['content'] = $request->input('content'); // Add this line
        $data['countries'] = IsoCountry::all();
        //save clientcare
        $cli_data['attachments'] = null;
        LetterOfAuthority::updateOrCreate(['enquiry_id' => $id], $cli_data);

        if ($preview) {
            $pdf = PDF::loadView("admin.inquiry.pdf.letter_of_authority", compact('data'));
            return $pdf->stream();
        }

        if ($download) {
            $pdf = PDF::loadView("admin.inquiry.pdf.letter_of_authority", compact('data'));
            return $pdf->download($data['filename'] . ".pdf");
        }
        if ($sendemail) {
            Mail::to('admin@wlisuk.com')
                ->send(new ClientcareMail($data));

            return back()->with("success", "Successfully sent Letter of Authority");
        }

        return back()->with("success", "Successfully saved Letter of Authority");
    }


    public function showEnquiryCare($id)
    {
        $data = array();
        $data['enquiry'] = Enquiry::with('clientcare')->findOrFail($id);
        $data['templates'] = Template::all();
        $data['enquirycare'] = EnquiryCare::where('enquiry_id', $id)->first();
        if ($data['enquirycare'] == null) {
            $data['enquirycare'] = new EnquiryCare;
            $data['enquirycare']->full_address = optional($data['enquiry']->address)->full_address;
        }
        $data['documents']= CompanyDocument::all();

        $data['advisors'] = Advisor::whereStatus("active")->get();

        return view('admin.inquiry.enquiry_care', compact('data'));
    }


    public function showLetterOfAuthority($id)
    {
        $data = array();
        $data['enquiry'] = Enquiry::with('clientcare')->findOrFail($id);
        $data['letterofauthority'] = LetterOfAuthority::where('enquiry_id', $id)->first();

        if ($data['letterofauthority'] == null) {
            $data['letterofauthority'] = new LetterOfAuthority;
            $data['letterofauthority']->full_address = optional($data['enquiry']->address)->full_address;
        }

        $data['enquirycare'] = EnquiryCare::where('enquiry_id', $id)->first();
        if ($data['enquirycare'] == null) {
            $data['enquirycare'] = new EnquiryCare;
        }
        $data['country_code'] = $this->country_code;
        $data['currencies'] = IsoCurrency::all();
        $data['banks'] = Bank::whereStatus("active")->get();
        $data['documents']= CompanyDocument::all();
        $data['advisors'] = Advisor::whereStatus("active")->get();
        //$data['enquiry_id'] = $data['clientcare']['enquiry_id'];
        $data['company_info'] = CompanyInfo::first();
        $data['countries'] = IsoCountry::all();
        //$data['authority_content'] = $data['clientcare']['authority_content'];

        return view('admin.inquiry.letter_of_authority', compact('data'));
    }

    public function letterToFirm(Request $request, $id)
    {

        $data = $this->validate($request, [
            'advisor_id' => "required",
            'full_address' => "required",
            'content' => "required",
            'date' => "required",
            'attachments'=>'nullable|array',
            'attachments.*'=>'file|max:5120',
            'documents'=>'nullable|array',
            'documents.*'=>'integer'
        ]);
        // dd($data);

        $sendemail = false;

        if ($request->action == "Email") $sendemail = true;
        $preview = $request->action == "Preview";
        $download = $request->action == "Download";
        $cli_data = $data;

        $data['company_info'] = CompanyInfo::first();
        $data['enquiry'] = Enquiry::findOrFail($id);
        $data['advisor'] = Advisor::find($data['advisor_id']);
        if (!$data['advisor']) {
            return back()->with("failed", "Advisor not found.");
        }
        $data['enquiry_id'] = $id;
        $data['filename'] = "ENQ{$data['enquiry']->id} - {$data['enquiry']->full_name} - Letter_To_Firms_When_Requesting_Data";
        $data['content'] = $request->input('content'); // Add this line

        //save clientcare
        $cli_data['attachments'] = null;
        LetterToFirms::updateOrCreate(['enquiry_id' => $id], $cli_data);

        if ($preview) {
            $pdf = PDF::loadView("admin.inquiry.pdf.letter_to_firm", compact('data'));
            return $pdf->stream();
        }

        if ($download) {
            $pdf = PDF::loadView("admin.inquiry.pdf.letter_to_firm", compact('data'));
            return $pdf->download($data['filename'] . ".pdf");
        }
        if ($sendemail) {
            Mail::to('admin@wlisuk.com')
                ->send(new ClientcareMail($data));

            return back()->with("success", "Successfully sent client care");
        }

        return back()->with("success", "Successfully saved client care");
    }

    public function showLetterToFirm($id)
    {
        $data = array();
        $data['enquiry'] = Enquiry::with('clientcare')->findOrFail($id);
        $data['lettertofirms'] = LetterToFirms::where('enquiry_id', $id)->first();
        if ($data['lettertofirms'] == null) {
            $data['lettertofirms'] = new LetterToFirms;
            $data['lettertofirms']->full_address = optional($data['enquiry']->address)->full_address;
        }

        $data['enquirycare'] = EnquiryCare::where('enquiry_id', $id)->first();
        if ($data['enquirycare'] == null) {
            $data['enquirycare'] = new EnquiryCare;
        }
        $data['rawInquiry'] = RawInquiry::where('enquiry_id', $id)->first();

        $data['documents']= CompanyDocument::all();
        $data['advisors'] = Advisor::whereStatus("active")->get();
        $data['advisor'] = Advisor::find($data['lettertofirms']['advisor_id']);
        $data['company_info'] = CompanyInfo::first();
        //$data['content'] = $data['lettertofirm']['content'];
        //return $data['discussion_content'];

        return view('admin.inquiry.letter_to_firm', compact('data'));
    }

    public function requestToMedical(Request $request, $id)
    {

        $data = $this->validate($request, [
            'practice_name' => "required",
            'practice_address' => "required",
            'content' => "required",
            'date' => "required",
            'attachments'=>'nullable|array',
            'attachments.*'=>'file|max:5120',
            'documents'=>'nullable|array',
            'documents.*'=>'integer'
        ]);
        // dd($data);

        $sendemail = false;

        if ($request->action == "Email") $sendemail = true;
        $preview = $request->action == "Preview";
        $download = $request->action == "Download";
        $cli_data = $data;

        $data['company_info'] = CompanyInfo::first();
        $data['enquiry'] = Enquiry::findOrFail($id);
        $data['advisor'] = Advisor::find($data['advisor_id']);
        if (!$data['advisor']) {
            return back()->with("failed", "Advisor not found.");
        }
        $data['enquiry_id'] = $id;
        $data['filename'] = "ENQ{$data['enquiry']->id} - {$data['enquiry']->full_name} - Request_access_to_medical_record";
        $data['content'] = $request->input('content'); // Add this line

        //save clientcare
        $cli_data['attachments'] = null;
        RequestToMedical::updateOrCreate(['enquiry_id' => $id], $cli_data);

        if ($preview) {
            $pdf = PDF::loadView("admin.inquiry.pdf.Request_access_to_medical_record", compact('data'));
            return $pdf->stream();
        }

        if ($download) {
            $pdf = PDF::loadView("admin.inquiry.pdf.Request_access_to_medical_record", compact('data'));
            return $pdf->download($data['filename'] . ".pdf");
        }
        if ($sendemail) {
            Mail::to('admin@wlisuk.com')
                ->send(new ClientcareMail($data));

            return back()->with("success", "Successfully sent client care");
        }

        return back()->with("success", "Successfully saved client care");
    }

    public function showRequestToMedical($id)
    {
        $data = array();
        $data['enquiry'] = Enquiry::with('clientcare')->findOrFail($id);
        $data['requesttomedical'] = RequestToMedical::where('enquiry_id', $id)->first();
        if ($data['requesttomedical'] == null) {
            $data['requesttomedical'] = new RequestToMedical;
            $data['requesttomedical']->full_address = optional($data['enquiry']->address)->full_address;
        }

        $data['enquirycare'] = EnquiryCare::where('enquiry_id', $id)->first();
        if ($data['enquirycare'] == null) {
            $data['enquirycare'] = new EnquiryCare;
        }
        $data['rawInquiry'] = RawInquiry::where('enquiry_id', $id)->first();

        $data['documents']= CompanyDocument::all();
        $data['advisors'] = Advisor::whereStatus("active")->get();
        //$data['advisor'] = Advisor::find($data['requesttomedical']['advisor_id']);
        $data['company_info'] = CompanyInfo::first();
        //$data['content'] = $data['lettertofirm']['content'];
        //return $data['discussion_content'];

        return view('admin.inquiry.requesttomedical', compact('data'));
    }

    public function requestToFinance(Request $request, $id)
    {

        $data = $this->validate($request, [
            'agency' => "required",
            'fullNameDisplay' => "required",
            'content' => "required",
            'date' => "required",
            'attachments'=>'nullable|array',
            'attachments.*'=>'file|max:5120',
            'documents'=>'nullable|array',
            'documents.*'=>'integer'
        ]);
        // dd($data);

        $sendemail = false;

        if ($request->action == "Email") $sendemail = true;
        $preview = $request->action == "Preview";
        $download = $request->action == "Download";
        $cli_data = $data;

        $data['company_info'] = CompanyInfo::first();
        $data['enquiry'] = Enquiry::findOrFail($id);
        $data['advisor'] = Advisor::find($data['advisor_id']);
        if (!$data['advisor']) {
            return back()->with("failed", "Advisor not found.");
        }
        $data['enquiry_id'] = $id;
        $data['filename'] = "ENQ{$data['enquiry']->id} - {$data['enquiry']->full_name} - Request_access_to_finance_record";
        $data['content'] = $request->input('content'); // Add this line

        //save clientcare
        $cli_data['attachments'] = null;
        RequestToFinance::updateOrCreate(['enquiry_id' => $id], $cli_data);


        if ($preview) {
            $pdf = PDF::loadView("admin.inquiry.pdf.Request_access_to_finance_record", compact('data'));
            return $pdf->stream();
        }

        if ($download) {
            $pdf = PDF::loadView("admin.inquiry.pdf.Request_access_to_finance_record", compact('data'));
            return $pdf->download($data['filename'] . ".pdf");
        }
        if ($sendemail) {
            Mail::to('admin@wlisuk.com')
                ->send(new ClientcareMail($data));

            return back()->with("success", "Successfully sent client care");
        }

        return back()->with("success", "Successfully saved client care");
    }

    public function showRequestToFinance($id)
    {
        $data = array();
        $data['enquiry'] = Enquiry::with('clientcare')->findOrFail($id);
        $data['requesttofinance'] = RequestToFinance::where('enquiry_id', $id)->first();
        if ($data['requesttofinance'] == null) {
            $data['requesttofinance'] = new RequestToFinance;
            $data['requesttofinance']->full_address = optional($data['enquiry']->address)->full_address;
        }

        $data['enquirycare'] = EnquiryCare::where('enquiry_id', $id)->first();
        if ($data['enquirycare'] == null) {
            $data['enquirycare'] = new EnquiryCare;
        }
        $data['rawInquiry'] = RawInquiry::where('enquiry_id', $id)->first();

        $data['documents']= CompanyDocument::all();
        $data['advisors'] = Advisor::whereStatus("active")->get();
        //$data['advisor'] = Advisor::find($data['requesttomedical']['advisor_id']);
        $data['company_info'] = CompanyInfo::first();
        //$data['content'] = $data['lettertofirm']['content'];
        //return $data['discussion_content'];

        return view('admin.inquiry.requesttofinance', compact('data'));
    }


}
