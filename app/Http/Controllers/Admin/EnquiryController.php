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
use App\LteAdult;
use App\LteFmChild;
use App\NewCcl;
use App\IntermedCcl;
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
use App\Mail\RtfMail;
use App\Mail\RttMail;
use App\Mail\SaMail;
use App\Mail\CoaMail;
use App\Mail\FoMail;
use App\Mail\IntermedMail;
use App\Mail\LtecclMail;
use App\Mail\CclapplicationMail;
use App\Mail\LtefmchildMail;
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
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Termwind\Components\Raw;
use Illuminate\Support\Facades\Response;

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
        'added_names_input' => 'nullable|string',
        'date' => "required",
        'agreed_fee_currency_id' => "required",
        'servicefee_id' => "required",
        'agreed_fee' => "required|numeric",
        'bank_id' => 'required',
        'additional_notes' => 'nullable',
        'attachments'=>'nullable|array',
        'attachments.*'=>'file|max:5120',
        'documents'=>'nullable|array',
        'documents.*'=>'integer'
    ]);

    // Convert date to yyyy-mm-dd format before saving to the database
    $data['date'] = Carbon::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d');
    $data['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $data['date_of_birth'])->format('Y-m-d');

    // dd($data);
    //return $request->discussion_details;
    $sendemail = false;

    if ($request->action == "Email") $sendemail = true;
    $preview = $request->action == "Preview";
    $download = $request->action == "Download";
    $addedNames = json_decode($request->input('added_names_input'), true);
    $clientCareData = [
        'advisor_id' => $request->advisor_id,
        'full_address' => $request->full_address,
        'discussion_details' => $request->discussion_details,
        'added_names' => $addedNames,  // Save the added names as an array
        'additional_notes' => $request->additional_notes,
        'date' => $request->date,
        'agreed_fee_currency_id' => $request->agreed_fee_currency_id,
        'servicefee_id' => $request->servicefee_id,
        'agreed_fee' => $request->agreed_fee,
        'bank_id' => $request->bank_id,
        // If you need to save attachments or documents, handle them here
    ];

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

    $clientCareData['added_names_input'] = json_encode($addedNames);

    //$data['enquiry']->save();
    //save clientcare
    $clientCareData['attachments'] = null;
    ClientCare::updateOrCreate(['enquiry_id' => $id], $clientCareData);

    // return $clientCareData['discussion_details'];

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
                $data['clientcare']->added_names_input = json_encode([]);
                $data['clientcare']->full_name_with_title = $data['enquiry']->full_name_with_title;
            }
            // Decode the added_names_input if it exists and pass it to the view
            $addedNamesInput = json_decode($data['clientcare']->added_names_input, true);
            if (!$addedNamesInput) {
            $addedNamesInput = [];  // Fallback to empty array if it's not valid JSON
            }
            $data['addedNamesInput'] = $addedNamesInput;
             // Add the variable to the $data array to pass to the view
            $data['addedNamesInput'] = $addedNamesInput;
            $data['country_code'] = $this->country_code;
            $data['currencies'] = IsoCurrency::all();
            $data['banks'] = Bank::whereStatus("active")->get();
            $data['documents']= CompanyDocument::all();
            $data['advisors'] = Advisor::whereStatus("active")->get();
            $data['advisor'] = Advisor::find($data['clientcare']['advisor_id']);
            $data['bank'] = Bank::find($data['clientcare']['bank_id']);
            $data['agreed_fee_currency'] = IsoCurrency::find($data['clientcare']['agreed_fee_currency_id']);
            $data['servicefee'] = Servicefee::find($data['clientcare']['servicefee_id']);
            $data['company_info'] = CompanyInfo::first();
            $data['discussion_content'] = $data['clientcare']['discussion_content'];
            $data['countries'] = IsoCountry::orderBy("order", "desc")->get();
            //$data['countries'] = IsoCountry::all();
            $data['additional_notes'] = $data['clientcare']['additional_notes'];
            return view('admin.inquiry.client_care', compact('data'));
        }

    public function loadClientCareData($id)
        {
            // Fetch the enquiry and its associated client care data
            $enquiry = Enquiry::with('clientcare')->findOrFail($id);

            // Prepare the response data
            $data = [
                'full_name_with_title' => $enquiry->full_name_with_title,
                'added_names' => json_decode($enquiry->clientcare->added_names ?? '[]', true), // Decode if necessary
                'full_address' => optional($enquiry->address)->full_address,
                'date' => optional($enquiry->clientcare)->date,
                'agreed_fee_currency_id' => optional($enquiry->clientcare)->agreed_fee_currency_id,
                'servicefee_id' => optional($enquiry->clientcare)->servicefee_id,
                'agreed_fee' => optional($enquiry->clientcare)->agreed_fee,
                'bank_id' => optional($enquiry->clientcare)->bank_id,
                'additional_notes' => optional($enquiry->clientcare)->additional_notes,
            ];

            return response()->json(['success' => true, 'data' => $data]);
        }

    public function letterOfAuthority(Request $request, $id)
        {
            // Validate request
            $data = $this->validate($request, [
                'advisor_id' => "required",
                'client_name' => "required",
                'full_address' => "required",
                'parent_address' => 'nullable',
                'content' => "required",
                'date' => "required",
                'date_of_birth' => 'nullable',
                'nationality' => 'nullable',
                'iso_country_id' => 'required',
                'email' => 'required',
                'attachments' => 'nullable|array',
                'attachments.*' => 'file|max:5120',
                'documents' => 'nullable|array',
                'documents.*' => 'integer',
            ]);
            // Convert date to yyyy-mm-dd format before saving to the database
             $data['date'] = Carbon::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d');
             $data['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $data['date_of_birth'])->format('Y-m-d');


            $loa_data = array_merge($data, [
                'enquiry_id' => $id,
                'advisor_id' => $data['advisor_id'],
                'client_name' => $data['client_name'],
                'full_address' => $data['full_address'],
                'parent_address' => $data['parent_address'],
                'content' => $data['content'],
                'date' => $data['date'],
                'date_of_birth' => $data['date_of_birth'],
                'iso_country_id' => $data['iso_country_id'],
                'email' => $data['email'],
            ]);

            $sendemail = false;

            if ($request->action == "Email") $sendemail = true;

             // Handle attachments
            if ($request->hasFile('attachments')) {
                $data['attachments'] = $request->file('attachments'); // Keep the UploadedFile instances
            } else {
                $data['attachments'] = [];  // Ensure it is an empty array if no files are uploaded
            }



            $data['company_info'] = CompanyInfo::first();
            $data['country_code'] = IsoCountry::all();
            $data['countries'] = IsoCountry::all();
            $data['enquiry'] = Enquiry::findOrFail($id);
            $data['advisor'] = Advisor::find($data['advisor_id']);

            if (!$data['advisor']) {
                return back()->with("failed", "Advisor not found.");
            }

            $data['enquiry_id'] = $id;
            $data['filename'] = "ENQ{$data['enquiry']->id} - {$data['enquiry']->full_name} - Letter_Of_Authority_Non_Client";

            // Handle actions
            if ($request->action == "Load") {
                return response()->json([
                    'status' => 'success',
                    'data' => $loa_data,
                ]);
            }

            if ($request->action == "Preview") {
                $pdf = PDF::loadView('admin.inquiry.pdf.letter_of_authority', compact('data'));
                return $pdf->stream();
            }

            if ($request->action == "Download") {
                $pdf = PDF::loadView("admin.inquiry.pdf.letter_of_authority", compact('data'));
                return $pdf->download($data['filename'] . ".pdf");
            }

            if ($request->action == "Save") {
                LetterOfAuthority::updateOrCreate(['enquiry_id' => $id], $loa_data);
                return back()->with("success", "Successfully saved Letter of Authority");
            }

            if ($sendemail) {
                $data['letterofauthority'] = LetterOfAuthority::where('enquiry_id', $id)->first();
                Mail::send(new LoaMail($data));

                return back()->with("success", "Successfully sent Letter of Authority");
            }


    return back()->with("failed", "Invalid action specified.");
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
        $data['advisor'] = Advisor::find($data['letterofauthority']['advisor_id']);
        //$data['enquiry_id'] = $data['clientcare']['enquiry_id'];
        $data['company_info'] = CompanyInfo::first();
        $data['countries'] = IsoCountry::orderBy("order", "desc")->get();
       // $data['countries'] = IsoCountry::all();
        $data['selected_country'] = IsoCountry::find($data['letterofauthority']->iso_country_id)->title ?? '';

        //$data['authority_content'] = $data['clientcare']['authority_content'];

        return view('admin.inquiry.letter_of_authority', compact('data'));
    }

    public function letterToFirm(Request $request, $id)
    {
        $enquiry = Enquiry::findOrFail($id);
        // Validate request
        $data = $this->validate($request, [
            'advisor_id' => "required",
            'full_address' => "required",
            'firmsname' => "required|string|max:255",
            'firmsaddress' => "required|string",
            'firmsemail' => "nullable|email",
            'content' => "required",
            'date' => "required",
            'date_of_birth' => "required",
            'sponsor_name' => "required|string",
            'sponsor_relationship' => "required|string",
            'your' => "required|string|max:255",
            'your_date_of_birth' => "required",
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:5120',
            'documents' => 'nullable|array',
            'documents.*' => 'integer'
        ]);

            // Convert date to yyyy-mm-dd format before saving to the database
            $data['date'] = Carbon::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d');
            $data['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $data['date_of_birth'])->format('Y-m-d');
            $data['your_date_of_birth'] = Carbon::createFromFormat('d/m/Y', $data['your_date_of_birth'])->format('Y-m-d');

        $letterData = [
            'enquiry_id' => $id,
            'advisor_id' => $data['advisor_id'],
            'full_address' => $data['full_address'],
            'firmsname' => $data['firmsname'],
            'firmsaddress' => $data['firmsaddress'],
            'firmsemail' => $data['firmsemail'],
            'sponsor_name' => $data['sponsor_name'],
            'sponsor_relationship' => $data['sponsor_relationship'],
            'content' => $data['content'],
            'date' => $data['date'],
            'date_of_birth' => $data['date_of_birth'],
            'your' => $data['your'],
            'your_date_of_birth' => $data['your_date_of_birth'],
        ];

         // Handle attachments
            if ($request->hasFile('attachments')) {
                $data['attachments'] = $request->file('attachments'); // Keep the UploadedFile instances
            } else {
                $data['attachments'] = [];  // Ensure it is an empty array if no files are uploaded
            }


        $data['company_info'] = CompanyInfo::first();
        $data['enquiry'] = Enquiry::findOrFail($id);
        $data['advisor'] = Advisor::find($data['advisor_id']);

        if (!$data['advisor']) {
            return back()->with("failed", "Advisor not found.");
        }

        $rawInquiry = RawInquiry::where('enquiry_id', $id)->first();

        if (!$rawInquiry) {
            $data['sponsor_name'] = null;
            $data['sponsor_relationship'] = null;
        } else {
            $data['sponsor_name'] = $rawInquiry->sponsor_name;
            $data['sponsor_relationship'] = $rawInquiry->sponsor_relationship;
        }

        $data['enquiry_id'] = $id;
        // Retrieve letter to firms data
        $data['lettertofirms'] = LetterToFirms::where('enquiry_id', $id)->first();

        // Set filename based on whether lettertofirms exists
        if ($data['lettertofirms']) {
        $data['filename'] = "ENQ{$data['enquiry']->id} - {$data['lettertofirms']->your} - File request- {$data['lettertofirms']->firmsname} ";
        } else {
        // Handle the case where lettertofirms does not exist
        $data['filename'] = "ENQ{$data['enquiry']->id} - No Letter - File request";
        }

        $data['content'] = $request->input('content');

        // Save letter to firms data
        if ($request->action === "Email") {
            $data['lettertofirms'] = LetterToFirms::where('enquiry_id', $id)->first();
            Mail::send(new LtfMail($data));

            return back()->with("success", "Successfully sent email to the firm.");
        }

        if ($request->action === "Save") {
            LetterToFirms::updateOrCreate(['enquiry_id' => $id], $letterData);
            return back()->with("success", "Successfully saved Letter to Firm");
        }

        if ($request->action === "Download") {
            $pdf = PDF::loadView("admin.inquiry.pdf.letter_to_firm", compact('data'));
            return $pdf->download($data['filename'] . ".pdf");
        }

        if ($request->action === "Preview") {
            $pdf = PDF::loadView("admin.inquiry.pdf.letter_to_firm", compact('data'));
            return $pdf->stream();
        }

        return back()->with("error", "Invalid action specified.");
    }



    public function showLetterToFirm($id)
    {
        $data = [];

        // Fetch enquiry with related data
        $data['enquiry'] = Enquiry::with('clientcare')->findOrFail($id);
        $data['lettertofirms'] = LetterToFirms::where('enquiry_id', $id)->first();
        if (!$data['lettertofirms']) {
            $data['lettertofirms'] = new LetterToFirms;
            $data['lettertofirms']->full_address = optional($data['enquiry']->address)->full_address;
        }

        // Fetch enquiry care
        $data['enquirycare'] = EnquiryCare::where('enquiry_id', $id)->first() ?? new EnquiryCare;

        // Fetch raw inquiry
        $data['rawInquiry'] = RawInquiry::where('enquiry_id', $id)->first();
        if ($data['rawInquiry']) {
            $data['sponsor_name'] = $data['rawInquiry']->sponsor_name;
            $data['sponsor_relationship'] = $data['rawInquiry']->sponsor_relationship;
        } else {
            $data['sponsor_name'] = null;
            $data['sponsor_relationship'] = null;
        }

        // Fetch other related data
        $data['documents'] = CompanyDocument::all();
        $data['advisors'] = Advisor::whereStatus("active")->get();
        $data['advisor'] = Advisor::find(optional($data['lettertofirms'])->advisor_id);
        $data['company_info'] = CompanyInfo::first();

        // Return the view with data
        return view('admin.inquiry.letter_to_firm', compact('data'));
    }


    public function requestToMedical(Request $request, $id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $data = $this->validate($request, [
            'advisor_id' => "required",
            'iso_country_id' => 'required',
            'current_address' => "nullable",
            'practice_name' => "required",
            'practice_address' => 'nullable',
            'paitent_name' => "required",
            'sex' => "required",
            'paitent_address' => 'nullable',
            'content' => "required",
            'date' => "required|date_format:d/m/Y",
            'date_of_birth' => "required|date_format:d/m/Y",
            'contact_by' =>"required",
            'language' =>"required",
            'attachments'=>'nullable|array',
            'attachments.*'=>'file|max:5120',
            'documents'=>'nullable|array',
            'documents.*'=>'integer'
        ]);
        // dd($data);
        // Convert date to yyyy-mm-dd format before saving to the database
        $data['date'] = Carbon::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d');
        $data['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $data['date_of_birth'])->format('Y-m-d');


        $medicalData = [
            'enquiry_id' => $id,
            'advisor_id' => $data['advisor_id'],
            'iso_country_id' => $data['iso_country_id'],
            'practice_name' => $data['practice_name'],
            'current_address' => $data['current_address'],
            'practice_address' => $data['practice_address'],
            'paitent_name' => $data['paitent_name'],
            'paitent_address' => $data['paitent_address'],
            'sex' => $data['sex'],
            'content' => $data['content'],
            'date' => $data['date'],
            'date_of_birth' => $data['date_of_birth'],
            'language' => $data['language'],
            'contact_by' => $data['contact_by'],
        ];

      // Handle attachments
            if ($request->hasFile('attachments')) {
                $data['attachments'] = $request->file('attachments'); // Keep the UploadedFile instances
            } else {
                $data['attachments'] = [];  // Ensure it is an empty array if no files are uploaded
            }


        $data['company_info'] = CompanyInfo::first();
        $data['enquiry'] = Enquiry::findOrFail($id);
        $data['advisor'] = Advisor::find($data['advisor_id']);

        if (!$data['advisor']) {
        return back()->with("failed", "Advisor not found.");
        }

        $data['enquiry_id'] = $id;
        // Retrieve the RequestToMedical record
        $data['requesttomedical'] = RequestToMedical::where('enquiry_id', $id)->first();

        // Check if the RequestToMedical record exists
        if ($data['requesttomedical']) {
        // Build filename using the data from the RequestToMedical record
        $data['filename'] = "ENQ{$data['enquiry']->id} - {$data['requesttomedical']->paitent_name} - Medical SAR Request - {$data['requesttomedical']->practice_name}";
        } else {
        // Fallback if the record doesn't exist (use default or error filename)
        $data['filename'] = "ENQ{$data['enquiry']->id} - Medical SAR Request - No Patient/Practice Name";
        }
        $data['content'] = $request->input('content');

        // Save letter to firms data
        if ($request->action === "Email") {
            $data['requesttomedical'] = RequestToMedical::where('enquiry_id', $id)->first();
            Mail::send(new RtmMail($data));

            return back()->with("success", "Successfully sent email to Medical SAR.");
        }

        if ($request->action === "Save") {
            RequestToMedical::updateOrCreate(['enquiry_id' => $id], $medicalData);
            return back()->with("success", "Successfully saved Medical SAR");
        }

        if ($request->action === "Download") {
            $pdf = PDF::loadView("admin.inquiry.pdf.request_to_medical", compact('data'));
            return $pdf->download($data['filename'] . ".pdf");
        }

        if ($request->action === "Preview") {
            $pdf = PDF::loadView("admin.inquiry.pdf.request_to_medical", compact('data'));
            return $pdf->stream();
        }

        return back()->with("error", "Invalid action specified.");
    }

    public function showRequestToMedical($id)
    {
        $data = [];
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

        $data['country_code'] = $this->country_code;
        $data['countries'] = IsoCountry::orderBy("order", "desc")->get();
        //$data['countries'] = IsoCountry::all();
        $data['selected_country'] = IsoCountry::find($data['requesttomedical']->iso_country_id)->title ?? '';
        $data['documents']= CompanyDocument::all();
        $data['advisors'] = Advisor::whereStatus("active")->get();
        $data['advisor'] = Advisor::find($data['requesttomedical']['advisor_id']);
        $data['company_info'] = CompanyInfo::first();
        //$data['content'] = $data['lettertofirm']['content'];
        //return $data['discussion_content'];

        return view('admin.inquiry.request_to_medical', compact('data'));
    }

    public function requestToFinance(Request $request, $id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $data = $this->validate($request, [
            'advisor_id'=> "required",
            'iso_country_id' => "required",
            'agency' => "required",
            'client_name' => "required",
            'content' => "required",
            'date' => "required",
            'date_of_birth' => "required",
            'street_address' => "required",
            'post_code' => "required",
            'account' => "required",
            'previous_address' => "nullable",
            'sex' => "required",
            'contact_by' => "required",
            'language' =>"required",
            'attachments'=>'nullable|array',
            'attachments.*'=>'file|max:5120',
            'documents'=>'nullable|array',
            'documents.*'=>'integer'
        ]);
        // dd($data);
        // Convert date to yyyy-mm-dd format before saving to the database
        $data['date'] = Carbon::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d');
        $data['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $data['date_of_birth'])->format('Y-m-d');

        $financeData = [
            'enquiry_id' => $id,
            'advisor_id' => $data['advisor_id'],
            'iso_country_id' => $data['iso_country_id'],
            'agency' => $data['agency'],
            'client_name' => $data['client_name'],
            'content' => $data['content'],
            'street_address' => $data['street_address'],
            'post_code' => $data['post_code'],
            'account' => $data['account'],
            'sex' => $data['sex'],
            'previous_address' => $data['previous_address'],
            'date' => $data['date'],
            'date_of_birth' => $data['date_of_birth'],
            'contact_by' => $data['contact_by'],
            'language' => $data['language'],
        ];

        // Handle attachments
            if ($request->hasFile('attachments')) {
                $data['attachments'] = $request->file('attachments'); // Keep the UploadedFile instances
            } else {
                $data['attachments'] = [];  // Ensure it is an empty array if no files are uploaded
            }


        $data['company_info'] = CompanyInfo::first();
        $data['enquiry'] = Enquiry::findOrFail($id);
        $data['advisor'] = Advisor::find($data['advisor_id']);

        if (!$data['advisor']) {
        return back()->with("failed", "Advisor not found.");
        }

        $data['enquiry_id'] = $id;
        $data['filename'] = "ENQ{$data['enquiry']->id} - {$data['enquiry']->full_name} - Request_Access_to_Financial_Record";
        $data['content'] = $request->input('content');

        // Save letter to firms data
        if ($request->action === "Email") {
            $data['requesttofinance'] = RequestToFinance::where('enquiry_id', $id)->first();
            // Send email
            Mail::send(new RtfMail($data));
            return back()->with("success", "Successfully sent email for request access to financial record");
        }

        if ($request->action === "Save") {
            RequestToFinance::updateOrCreate(['enquiry_id' => $id], $financeData);
            return back()->with("success", "Successfully saved Request access to Finance");
        }

        if ($request->action === "Download") {
            $pdf = PDF::loadView("admin.inquiry.pdf.request_to_finance", compact('data'));
            return $pdf->download($data['filename'] . ".pdf");
        }

        if ($request->action === "Preview") {
            $pdf = PDF::loadView("admin.inquiry.pdf.request_to_finance", compact('data'));
            return $pdf->stream();
        }

        return back()->with("error", "Invalid action specified.");
    }

    public function showRequestToFinance($id)
    {
        $data = [];
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


        $data['country_code'] = $this->country_code;
        $data['countries'] = IsoCountry::orderBy("order", "desc")->get();
        //$data['countries'] = IsoCountry::all();
        $data['selected_country'] = IsoCountry::find($data['requesttofinance']->iso_country_id)->title ?? '';
        $data['documents']= CompanyDocument::all();
        $data['advisors'] = Advisor::whereStatus("active")->get();
        $data['advisor'] = Advisor::find($data['requesttofinance']['advisor_id']);
        $data['company_info'] = CompanyInfo::first();


        return view('admin.inquiry.request_to_finance', compact('data'));
    }

    public function loadClientCare($id)
    {
        // Fetch the client care data by ID (or any other identifier)
        $clientCare = ClientCare::findOrFail($id);

        // Return the data as JSON
        return response()->json($clientCare);
    }

     public function cclApplication(Request $request, $id)
    {

        $data = $this->validate($request, [
            'advisor_id' => "required",
            'full_address' => "required",
            'discussion_details' => "nullable",
            'full_name_with_title' => "nullable",
            'added_names_input' => 'nullable|string',
            'date' => "required",
            'agreed_fee_currency_id' => "required",
            'servicefee_id' => "required",
            'agreed_fee' => "required|numeric",
            'bank_id' => 'required',
            'additional_notes' => 'nullable',
            'attachments'=>'nullable|array',
            'attachments.*'=>'file|max:5120',
            'documents'=>'nullable|array',
            'documents.*'=>'integer'
        ]);
        // dd($data);
        //return $request->discussion_details;
        $sendemail = false;

        if ($request->action == "Email") $sendemail = true;
        $preview = $request->action == "Preview";
        $download = $request->action == "Download";
        $addedNames = json_decode($request->input('added_names_input'), true);
        $cclApplicationData = [
            'advisor_id' => $request->advisor_id,
            'full_address' => $request->full_address,
            'discussion_details' => $request->discussion_details,
            'added_names' => $addedNames,  // Save the added names as an array
            'additional_notes' => $request->additional_notes,
            'date' => $request->date,
            'agreed_fee_currency_id' => $request->agreed_fee_currency_id,
            'servicefee_id' => $request->servicefee_id,
            'agreed_fee' => $request->agreed_fee,
            'bank_id' => $request->bank_id,
            // If you need to save attachments or documents, handle them here
        ];

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
        $data['filename'] = "ENQ{$data['enquiry']->id} - {$data['enquiry']->full_name} - Client_Care_Application";
        $data['discussion_content'] = $request->input('discussion_content'); // Add this line

        $cclApplicationData['added_names_input'] = json_encode($addedNames);

        //$data['enquiry']->save();
        //save clientcare
        $cclApplicationData['attachments'] = null;
        CclApplication::updateOrCreate(['enquiry_id' => $id], $cclApplicationData);

        // return $clientCareData['discussion_details'];

        if ($preview) {
            $pdf = PDF::loadView("admin.inquiry.pdf.ccl", compact('data', 'addedNames'));
            return $pdf->stream();
        }

        if ($download) {
            $pdf = PDF::loadView("admin.inquiry.pdf.ccl", compact('data', 'addedNames'));
            return $pdf->download($data['filename'] . ".pdf");
        }
        if ($sendemail) {
            Mail::to('admin@wlisuk.com')
                ->send(new ClientcareMail($data));

            return back()->with("success", "Successfully sent client care");
        }

        return back()->with("success", "Successfully saved client care");
    }


    public function showCclApplication($id)
    {
            $data = array();
            $data['enquiry'] = Enquiry::with('cclapplication')->findOrFail($id);
            $data['cclapplication'] = CclApplication::where('enquiry_id', $id)->first();
            if ($data['cclapplication'] == null) {
                $data['cclapplication'] = new CclApplication;
                $data['cclapplication']->full_address = optional($data['enquiry']->address)->full_address;
                $data['cclapplication']->added_names_input = json_encode([]);
                $data['cclapplication']->full_name_with_title = $data['enquiry']->full_name_with_title;
            }
            // Decode the added_names_input if it exists and pass it to the view
            $addedNamesInput = json_decode($data['cclapplication']->added_names_input, true);
            if (!$addedNamesInput) {
            $addedNamesInput = [];  // Fallback to empty array if it's not valid JSON
            }
            $data['addedNamesInput'] = $addedNamesInput;
             // Add the variable to the $data array to pass to the view
            $data['addedNamesInput'] = $addedNamesInput;
            $data['country_code'] = $this->country_code;
            $data['currencies'] = IsoCurrency::all();
            $data['banks'] = Bank::whereStatus("active")->get();
            $data['documents']= CompanyDocument::all();
            $data['advisors'] = Advisor::whereStatus("active")->get();
            $data['advisor'] = Advisor::find($data['cclapplication']['advisor_id']);
            $data['bank'] = Bank::find($data['cclapplication']['bank_id']);
            $data['agreed_fee_currency'] = IsoCurrency::find($data['cclapplication']['agreed_fee_currency_id']);
            $data['servicefee'] = Servicefee::find($data['cclapplication']['servicefee_id']);
            $data['company_info'] = CompanyInfo::first();
            $data['discussion_content'] = $data['cclapplication']['discussion_content'];
            $data['countries'] = IsoCountry::orderBy("order", "desc")->get();
            //$data['countries'] = IsoCountry::all();
            $data['additional_notes'] = $data['cclapplication']['additional_notes'];
            return view('admin.inquiry.ccl_application', compact('data'));
        }

    public function requestToTrbunal(Request $request, $id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $data = $this->validate($request, [
            'advisor_id'=> "required",
            'reference_number' => "nullable",
            'appellant_name' => "required",
            'content' => "required",
            'date' => "required",
            'date_of_birth' => "required",
            'current_address' => "required",
            //'appeal_number' => "nullable",
            'sponsor_address' => "required",
            'contact_details' => "required",
            'contacted_by' => "required",
            'sex' => "required",
            'attachments'=>'nullable|array',
            'attachments.*'=>'file|max:5120',
            'documents'=>'nullable|array',
            'documents.*'=>'integer'
        ]);
        // dd($data);
        // Convert date to yyyy-mm-dd format before saving to the database
            $data['date'] = Carbon::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d');
            $data['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $data['date_of_birth'])->format('Y-m-d');

        $trbunalData = [
            'enquiry_id' => $id,
            'advisor_id' => $data['advisor_id'],
            'reference_number' => $data['reference_number'],
            'appellant_name' => $data['appellant_name'],
            'content' => $data['content'],
            'current_address' => $data['current_address'],
            //'appeal_number' => $data['appeal_number'],
            'sponsor_address' => $data['sponsor_address'],
            'sex' => $data['sex'],
            'contact_details' => $data['contact_details'],
            'date' => $data['date'],
            'date_of_birth' => $data['date_of_birth'],
            'contacted_by' => $data['contacted_by'],

        ];

         // Handle attachments
            if ($request->hasFile('attachments')) {
                $data['attachments'] = $request->file('attachments'); // Keep the UploadedFile instances
            } else {
                $data['attachments'] = [];  // Ensure it is an empty array if no files are uploaded
            }


        $data['company_info'] = CompanyInfo::first();
        $data['enquiry'] = Enquiry::findOrFail($id);
        $data['advisor'] = Advisor::find($data['advisor_id']);

        if (!$data['advisor']) {
        return back()->with("failed", "Advisor not found.");
        }

        $data['enquiry_id'] = $id;
        $data['filename'] = "ENQ{$data['enquiry']->id} - {$data['enquiry']->full_name} - Request_Access_to_Tribunal_Determintion";
        $data['content'] = $request->input('content');

        // Save letter to firms data
        if ($request->action === "Email") {
            $data['requesttotrbunal'] = RequestToTrbunal::where('enquiry_id', $id)->first();
            // Send email

            Mail::send(new RttMail($data));
            return back()->with("success", "Successfully sent email for request access to tribunal record");
        }

        if ($request->action === "Save") {
            RequestToTrbunal::updateOrCreate(['enquiry_id' => $id], $trbunalData);
            return back()->with("success", "Successfully saved Request access to Tribunal Determination");
        }

        if ($request->action === "Download") {
            $pdf = PDF::loadView("admin.inquiry.pdf.request_to_trbunal", compact('data'));
            return $pdf->download($data['filename'] . ".pdf");
        }

        if ($request->action === "Preview") {
            $pdf = PDF::loadView("admin.inquiry.pdf.request_to_trbunal", compact('data'));
            return $pdf->stream();
        }

        return back()->with("error", "Invalid action specified.");
    }

    public function showRequestToTrbunal($id)
    {
        $data = [];
        $data['enquiry'] = Enquiry::with('clientcare')->findOrFail($id);
        $data['requesttotrbunal'] = RequestToTrbunal::where('enquiry_id', $id)->first();
        if ($data['requesttotrbunal'] == null) {
            $data['requesttotrbunal'] = new RequestToTrbunal;
            $data['requesttotrbunal']->full_address = optional($data['enquiry']->address)->full_address;
        }

        $data['enquirycare'] = EnquiryCare::where('enquiry_id', $id)->first();
        if ($data['enquirycare'] == null) {
            $data['enquirycare'] = new EnquiryCare;
        }

        $data['documents']= CompanyDocument::all();
        $data['advisors'] = Advisor::whereStatus("active")->get();
        $data['advisor'] = Advisor::find($data['requesttotrbunal']['advisor_id']);
        $data['company_info'] = CompanyInfo::first();


        return view('admin.inquiry.request_to_trbunal', compact('data'));
    }

        public function subjectAccess(Request $request, $id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $data = $this->validate($request, [
            'advisor_id'=> "required",
            'reference_number' => "nullable",
            'appellant_name' => "required",
            'content' => "required",
            'date' => "required",
            'date_of_birth' => "required",
            'current_address' => "required",
            'contact_details' => "required",
            'contacted_by' => "required",
            'sex' => "required",
            'attachments'=>'nullable|array',
            'attachments.*'=>'file|max:5120',
            'documents'=>'nullable|array',
            'documents.*'=>'integer'
        ]);
        // dd($data);
        // Convert date to yyyy-mm-dd format before saving to the database
            $data['date'] = Carbon::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d');
            $data['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $data['date_of_birth'])->format('Y-m-d');

        $subjectData = [
            'enquiry_id' => $id,
            'advisor_id' => $data['advisor_id'],
            'reference_number' => $data['reference_number'],
            'appellant_name' => $data['appellant_name'],
            'content' => $data['content'],
            'current_address' => $data['current_address'],
            'sex' => $data['sex'],
            'contact_details' => $data['contact_details'],
            'date' => $data['date'],
            'date_of_birth' => $data['date_of_birth'],
            'contacted_by' => $data['contacted_by'],

        ];

         // Handle attachments
            if ($request->hasFile('attachments')) {
                $data['attachments'] = $request->file('attachments'); // Keep the UploadedFile instances
            } else {
                $data['attachments'] = [];  // Ensure it is an empty array if no files are uploaded
            }


        $data['company_info'] = CompanyInfo::first();
        $data['enquiry'] = Enquiry::findOrFail($id);
        $data['advisor'] = Advisor::find($data['advisor_id']);

        if (!$data['advisor']) {
        return back()->with("failed", "Advisor not found.");
        }

        $data['enquiry_id'] = $id;
        $data['filename'] = "ENQ{$data['enquiry']->id} - {$data['enquiry']->full_name} - Subject-Access-Request";
        $data['content'] = $request->input('content');

        // Save letter to firms data
        if ($request->action === "Email") {
            $data['subjectaccess'] = SubjectAccess::where('enquiry_id', $id)->first();
            // Send email
            Mail::send(new SaMail($data));
            return back()->with("success", "Successfully sent email for subject access record");
        }

        if ($request->action === "Save") {
            SubjectAccess::updateOrCreate(['enquiry_id' => $id], $subjectData);
            return back()->with("success", "Successfully saved Subject access ");
        }

        if ($request->action === "Download") {
            $pdf = PDF::loadView("admin.inquiry.pdf.subject_access", compact('data'));
            return $pdf->download($data['filename'] . ".pdf");
        }

        if ($request->action === "Preview") {
            $pdf = PDF::loadView("admin.inquiry.pdf.subject_access", compact('data'));
            return $pdf->stream();
        }

        return back()->with("error", "Invalid action specified.");
    }

    public function showSubjectAccess($id)
    {
        $data = [];
        $data['enquiry'] = Enquiry::with('clientcare')->findOrFail($id);
        $data['subjectaccess'] = SubjectAccess::where('enquiry_id', $id)->first();
        if ($data['subjectaccess'] == null) {
            $data['subjectaccess'] = new SubjectAccess;
            $data['subjectaccess']->full_address = optional($data['enquiry']->address)->full_address;
        }

        $data['enquirycare'] = EnquiryCare::where('enquiry_id', $id)->first();
        if ($data['enquirycare'] == null) {
            $data['enquirycare'] = new EnquiryCare;
        }

        $data['documents']= CompanyDocument::all();
        $data['advisors'] = Advisor::whereStatus("active")->get();
        $data['advisor'] = Advisor::find($data['subjectaccess']['advisor_id']);
        $data['company_info'] = CompanyInfo::first();


        return view('admin.inquiry.subject_access', compact('data'));
    }

       public function clientOfAuthority(Request $request, $id)
    {
        // Validate request
        $data = $this->validate($request, [
            'advisor_id' => "required",
            'client_name' => "required",
            'full_address' => "required",
            'parent_address' => 'nullable',
            'content' => "required",
            'date' => "required",
            'date_of_birth' => 'nullable',
            'nationality' => 'nullable',
            'iso_country_id' => 'required',
            'email' => 'required|email',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:5120',
            'documents' => 'nullable|array',
            'documents.*' => 'integer',
        ]);
        // Convert date to yyyy-mm-dd format before saving to the database
         $data['date'] = Carbon::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d');
         $data['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $data['date_of_birth'])->format('Y-m-d');


        $loa_data = array_merge($data, [
            'enquiry_id' => $id,
            'advisor_id' => $data['advisor_id'],
            'client_name' => $data['client_name'],
            'full_address' => $data['full_address'],
            'parent_address' => $data['parent_address'],
            'content' => $data['content'],
            'date' => $data['date'],
            'date_of_birth' => $data['date_of_birth'],
            'iso_country_id' => $data['iso_country_id'],
            'email' => $data['email'],
        ]);

        $sendemail = false;

        if ($request->action == "Email") $sendemail = true;

         // Handle attachments
        if ($request->hasFile('attachments')) {
            $data['attachments'] = $request->file('attachments'); // Keep the UploadedFile instances
        } else {
            $data['attachments'] = [];  // Ensure it is an empty array if no files are uploaded
        }



        $data['company_info'] = CompanyInfo::first();
        $data['country_code'] = IsoCountry::all();
        $data['countries'] = IsoCountry::all();
        $data['enquiry'] = Enquiry::findOrFail($id);
        $data['advisor'] = Advisor::find($data['advisor_id']);

        if (!$data['advisor']) {
            return back()->with("failed", "Advisor not found.");
        }

        $data['enquiry_id'] = $id;
        $data['filename'] = "ENQ{$data['enquiry']->id} - {$data['enquiry']->full_name} - Letter_Of_Authority";

        // Handle actions
        if ($request->action == "Load") {
            return response()->json([
                'status' => 'success',
                'data' => $loa_data,
            ]);
        }

        if ($request->action == "Preview") {
            $pdf = PDF::loadView('admin.inquiry.pdf.client_of_authority', compact('data'));
            return $pdf->stream();
        }

        if ($request->action == "Download") {
            $pdf = PDF::loadView("admin.inquiry.pdf.client_of_authority", compact('data'));
            return $pdf->download($data['filename'] . ".pdf");
        }

        if ($request->action == "Save") {
            ClientOfAuthority::updateOrCreate(['enquiry_id' => $id], $loa_data);
            return back()->with("success", "Successfully saved Letter of Authority");
        }

        if ($sendemail) {
            $data['letterofauthority'] = ClientOfAuthority::where('enquiry_id', $id)->first();
            Mail::send(new CoaMail($data));

            return back()->with("success", "Successfully sent Letter of Authority");
        }


        return back()->with("failed", "Invalid action specified.");
    }

    public function showClientOfAuthority($id)
    {
        $data = array();
        $data['enquiry'] = Enquiry::with('clientcare')->findOrFail($id);
        $data['clientofauthority'] = ClientOfAuthority::where('enquiry_id', $id)->first();

        if ($data['clientofauthority'] == null) {
            $data['clientofauthority'] = new ClientOfAuthority;
            $data['clientofauthority']->full_address = optional($data['enquiry']->address)->full_address;
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
        $data['advisor'] = Advisor::find($data['clientofauthority']['advisor_id']);
        //$data['enquiry_id'] = $data['clientcare']['enquiry_id'];
        $data['company_info'] = CompanyInfo::first();
        $data['countries'] = IsoCountry::orderBy("order", "desc")->get();
        //$data['countries'] = IsoCountry::all();
        $data['selected_country'] = IsoCountry::find($data['clientofauthority']->iso_country_id)->title ?? '';

        //$data['authority_content'] = $data['clientcare']['authority_content'];

        return view('admin.inquiry.client_of_authority', compact('data'));
    }

        public function fileOpeningForm(Request $request, $id)
    {
        // Validate request
        $data = $this->validate($request, [
            'advisor_id' => "required",
            'client_name' => "required",
            'date_of_birth' => "nullable",
            'matter' => "required",
            'content' => "required",
            'date' => "required",
            'nationality' => 'nullable',
            'iso_country_id' => 'required',
            'email' => 'required',
            'current_address' => 'required',
            'mobile' => 'required',
            'authorised_name' => 'nullable',
            'authorised_relation' => 'nullable',
            'contact_no' => 'nullable',
            'authorised_email' => 'nullable',
            'authorised_address' => 'nullable',
            'word' => 'nullable',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:5120',
            'documents' => 'nullable|array',
            'documents.*' => 'integer',
        ]);
        // Convert date to yyyy-mm-dd format before saving to the database
         $data['date'] = Carbon::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d');
         $data['date_of_birth'] = Carbon::createFromFormat('d/m/Y', $data['date_of_birth'])->format('Y-m-d');


        $loa_data = array_merge($data, [
            'enquiry_id' => $id,
            'advisor_id' => $data['advisor_id'],
            'client_name' => $data['client_name'],
            'current_address' => $data['current_address'],
            'content' => $data['content'],
            'date' => $data['date'],
            'date_of_birth' => $data['date_of_birth'],
            'iso_country_id' => $data['iso_country_id'],
            'email' => $data['email'],
            'matter' => $data['matter'],
            'mobile' => $data['mobile'],
            'authorised_name' => $data['authorised_name'],
            'authorised_relation' => $data['authorised_relation'],
            'contact_no' => $data['contact_no'],
            'authorised_email' => $data['authorised_email'],
            'authorised_address' => $data['authorised_address'],
        ]);

        $sendemail = false;

        if ($request->action == "Email") $sendemail = true;

         // Handle attachments
        if ($request->hasFile('attachments')) {
            $data['attachments'] = $request->file('attachments'); // Keep the UploadedFile instances
        } else {
            $data['attachments'] = [];  // Ensure it is an empty array if no files are uploaded
        }
        $data['company_info'] = CompanyInfo::first();
        $data['country_code'] = IsoCountry::all();
        $data['countries'] = IsoCountry::all();
        $data['enquiry'] = Enquiry::findOrFail($id);
        $data['advisor'] = Advisor::find($data['advisor_id']);

        if (!$data['advisor']) {
            return back()->with("failed", "Advisor not found.");
        }

        $data['enquiry_id'] = $id;
        $data['filename'] = "ENQ{$data['enquiry']->id} - {$data['enquiry']->full_name} - File Opening Form";

        // Handle actions

        if ($request->action == "Preview") {
            $pdf = PDF::loadView('admin.inquiry.pdf.file_open', compact('data'));
            return $pdf->stream();
        }

        if ($request->action == "Download") {
            $pdf = PDF::loadView("admin.inquiry.pdf.file_open", compact('data'));
            return $pdf->download($data['filename'] . ".pdf");
        }

        if ($request->action == "Save") {
            FileOpeningForm::updateOrCreate(['enquiry_id' => $id], $loa_data);
            return back()->with("success", "Successfully saved File Opening Forms");
        }

        if ($sendemail) {
            $data['fileopeningform'] = FileOpeningForm::where('enquiry_id', $id)->first();
            Mail::send(new FoMail($data));

            return back()->with("success", "Successfully sent File Opening Forms");
        }


        return back()->with("failed", "Invalid action specified.");
    }

    public function showFileOpeningForm($id)
    {
        $data = array();
        $data['enquiry'] = Enquiry::with('clientcare')->findOrFail($id);
        $data['fileopeningform'] = FileOpeningForm::where('enquiry_id', $id)->first();

        if ($data['fileopeningform'] == null) {
            $data['fileopeningform'] = new FileOpeningForm;
            $data['fileopeningform']->full_address = optional($data['enquiry']->address)->full_address;
        }

        // Predefined list of words
            $words = ['Alpha', 'Beta', 'Gamma', 'Delta', 'Epsilon'];
            $randomWord = $words[array_rand($words)];

            // Set the payload with a random word
            $data['payload'] = [
                'word' => $randomWord,
            ];

        $data['enquirycare'] = EnquiryCare::where('enquiry_id', $id)->first();
        if ($data['enquirycare'] == null) {
            $data['enquirycare'] = new EnquiryCare;
        }
        $data['country_code'] = $this->country_code;
        $data['currencies'] = IsoCurrency::all();
        $data['banks'] = Bank::whereStatus("active")->get();
        $data['documents']= CompanyDocument::all();
        $data['advisors'] = Advisor::whereStatus("active")->get();
        $data['advisor'] = Advisor::find($data['fileopeningform']['advisor_id']);
        //$data['enquiry_id'] = $data['clientcare']['enquiry_id'];
        $data['company_info'] = CompanyInfo::first();
        $data['countries'] = IsoCountry::orderBy("order", "desc")->get();
        //$data['countries'] = IsoCountry::all();
        $data['selected_country'] = IsoCountry::find($data['fileopeningform']->iso_country_id)->title ?? '';

        //$data['authority_content'] = $data['clientcare']['authority_content'];

        return view('admin.inquiry.file_open', compact('data'));
    }

    public function lteCcl(Request $request, $id)
    {
        // Validate request
        $data = $this->validate($request, [
            'advisor_id' => "required",
            'visa_type' => "nullable",
            'tribunal_fee' => "nullable",
            'vat' => "nullable",
            'travel_fee' => "nullable",
            'reappear_fee' => "nullable",
            'full_address' => "required",
            'discussion_details' => "nullable",
            'full_name_with_title' => "nullable",
            'date' => "required",
            'discussion_date' => "required",
            'visa_application_submitted' => "required",
            'agreed_fee_currency_id' => "required",
            'servicefee_id' => "required",
            'agreed_fee' => "required|numeric",
            'bank_id' => 'required',
            'additional_notes' => 'nullable',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:5120',
            'documents' => 'nullable|array',
            'documents.*' => 'integer',
        ]);
        // Convert date to yyyy-mm-dd format before saving to the database
         $data['date'] = Carbon::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d');
         $data['discussion_date'] = Carbon::createFromFormat('d/m/Y', $data['discussion_date'])->format('Y-m-d');
         $data['visa_application_submitted'] = Carbon::createFromFormat('d/m/Y', $data['visa_application_submitted'])->format('Y-m-d');



        $lte_data = array_merge($data, [
            'enquiry_id' => $id,
            'advisor_id' => $data['advisor_id'],
            'visa_type' => $data['visa_type'],
            'tribunal_fee' => $data['tribunal_fee'],
            'vat' => $data['vat'],
            'travel_fee' => $data['travel_fee'],
            'reappear_fee' => $data['reappear_fee'],
            'full_address' => $data['full_address'],
            'discussion_details' => $data['discussion_details'],
            'full_name_with_title' => $data['full_name_with_title'] ?? '',
            'date' => $data['date'],
            'discussion_date' => $data['discussion_date'],
            'visa_application_submitted' => $data['visa_application_submitted'],
            'agreed_fee_currency_id' => $data['agreed_fee_currency_id'],
            'servicefee_id' => $data['servicefee_id'],
            'agreed_fee' => $data['agreed_fee'],
            'bank_id' => $data['bank_id'],
            'additional_notes' => $data['additional_notes'],
        ]);

        $sendemail = false;

        if ($request->action == "Email") $sendemail = true;

         // Handle attachments
        if ($request->hasFile('attachments')) {
            $data['attachments'] = $request->file('attachments'); // Keep the UploadedFile instances
        } else {
            $data['attachments'] = [];  // Ensure it is an empty array if no files are uploaded
        }
        $data['company_info'] = CompanyInfo::first();
        $data['country_code'] = IsoCountry::all();
        $data['countries'] = IsoCountry::all();
        $data['enquiry'] = Enquiry::findOrFail($id);
        $data['advisor'] = Advisor::find($data['advisor_id']);

        if (!$data['advisor']) {
            return back()->with("failed", "Advisor not found.");
        }

        $data['bank'] = Bank::findOrFail($data['bank_id']);
        $data['agreed_fee_currency'] = IsoCurrency::findOrFail($data['agreed_fee_currency_id']);
        $data['servicefee'] = Servicefee::findOrFail($data['servicefee_id']);
        //$data['visa'] = Visa::findOrFail($data['visa_id']);
        $data['enquiry_id'] = $id;
        $data['filename'] = "ENQ{$data['enquiry']->id} - Client Care Letter - {$data['enquiry']->full_name}";

        // Handle actions

        if ($request->action == "Preview") {
             $data['lteccl'] = LteCcl::where('enquiry_id', $id)->first();
            $pdf = PDF::loadView('admin.inquiry.pdf.lte_ccl', compact('data'));
            return $pdf->stream();
        }

        if ($request->action == "Download") {
            $data['lteccl'] = LteCcl::where('enquiry_id', $id)->first();
            $pdf = PDF::loadView("admin.inquiry.pdf.lte_ccl", compact('data'));
            return $pdf->download($data['filename'] . ".pdf");
        }

        if ($request->action == "Save") {
            LteCcl::updateOrCreate(['enquiry_id' => $id], $lte_data);
            return back()->with("success", "Successfully saved LTE Client Care Letter");
        }

        if ($sendemail) {
            $data['lteccl'] = LteCcl::where('enquiry_id', $id)->first();
            Mail::send(new LtecclMail($data));

            return back()->with("success", "Successfully sent LTE Client Care Letter");
        }


        return back()->with("failed", "Invalid action specified.");
    }

    public function showLteCcl($id)
    {
        $data = [];

        $data['enquiry'] = Enquiry::with('cclapplication')->findOrFail($id);
        $data['lteccl'] = LteCcl::where('enquiry_id', $id)->first();
        $data['rawInquiry'] = RawInquiry::find($data['enquiry']->raw_enquiry_id); // Fetch RawInquiry
        $data['applicationLocation'] = optional($data['rawInquiry'])->applicationLocation ?? '';

        if ($data['lteccl'] == null) {
            $data['lteccl'] = new LteCcl;
            $data['lteccl']->full_address = optional($data['enquiry']->address)->full_address;
            $data['lteccl']->full_name_with_title = $data['enquiry']->full_name_with_title ?? 'Default Name'; // Provide a default

        }
        // Add the variable to the $data array to pass to the view

        $data['country_code'] = $this->country_code;
        $data['currencies'] = IsoCurrency::all();
        $data['banks'] = Bank::whereStatus("active")->get();
        $data['documents']= CompanyDocument::all();
        $data['advisors'] = Advisor::whereStatus("active")->get();
        $data['advisor'] = Advisor::find($data['lteccl']['advisor_id']);
        $data['bank'] = Bank::find($data['lteccl']['bank_id']);
        $data['agreed_fee_currency'] = IsoCurrency::find($data['lteccl']['agreed_fee_currency_id']);
        $data['servicefee'] = Servicefee::find($data['lteccl']['servicefee_id']);
        $data['company_info'] = CompanyInfo::first();
        $data['discussion_content'] = $data['lteccl']['discussion_content'];
        $data['countries'] = IsoCountry::orderBy("order", "desc")->get();
        //$data['countries'] = IsoCountry::all();
        $data['additional_notes'] = $data['lteccl']['additional_notes'];

        $data['refusalLetterDate'] = optional($data['rawInquiry'])->refusalLetterDate ?? '';
        $data['refusalreceivedDate'] = optional($data['rawInquiry'])->refusalreceivedDate ?? '';

        $data['uan'] = optional($data['rawInquiry'])->uan ?? '';
        $data['ho_ref'] = optional($data['rawInquiry'])->ho_ref ?? '';
        $data['method_decision_received'] = optional($data['rawInquiry'])->method_decision_received ?? '';
        $data['sponsor_name'] = optional($data['rawInquiry'])->sponsor_name ?? '';
        $data['sponsor_relationship'] = optional($data['rawInquiry'])->sponsor_relationship ?? '';

        return view('admin.inquiry.lte_ccl', compact('data'));
    }

    public function newCcl(Request $request, $id)
    {
        // Validate request
        $data = $request->validate([
            'advisor_id' => "required|exists:advisors,id",
            'vat' => "nullable",
            'full_address' => "required",
            'discussion_details' => "nullable",
            'full_name_with_title' => "nullable",
            'date' => "required",
            'agreed_fee_currency_id' => 'required|exists:iso_currencylists,id',
            'servicefee_id' => "required|exists:servicefees,id",
            'agreed_fee' => "required|numeric",
            'bank_id' => 'required|exists:banks,id',
            'additional_notes' => 'nullable',
            'application_type' => 'nullable',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:5120',
            'documents' => 'nullable|array',
            'documents.*' => 'integer',
        ]);

        // Format date safely
        try {
            $data['date'] = Carbon::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d');
        } catch (\Exception $e) {
            return back()->withErrors(['date' => 'Invalid date format. Please use dd/mm/YYYY']);
        }

       // Save payload for DB
        $lte_data = array_merge($data, ['enquiry_id' => $id]);

        // Common data
        $data['company_info']   = CompanyInfo::first();
        $data['country_code']   = IsoCountry::all();
        $data['countries']      = IsoCountry::all();
        $data['enquiry']        = Enquiry::findOrFail($id);
        $data['advisor']        = Advisor::find($data['advisor_id']);
        $data['bank']           = Bank::findOrFail($data['bank_id']);
        $data['agreed_fee_currency'] = IsoCurrency::findOrFail($data['agreed_fee_currency_id']);
        $data['servicefee']     = Servicefee::findOrFail($data['servicefee_id']);
        $data['enquiry_id']     = $id;
        $data['filename']       = "ENQ{$data['enquiry']->id} - Client Care Application - {$data['enquiry']->full_name}";

        // Ensure newccl (fallback empty if none)
        $data['newccl'] = NewCcl::where('enquiry_id', $id)->first();
        if(!$data['newccl']){
            $data['newccl'] = new \stdClass();
        }

         // Action Handling
        switch ($request->action) {
            case "Preview":
                $pdf = Pdf::loadView('admin.inquiry.pdf.new_ccl', compact('data'));
                return $pdf->stream($data['filename'] . ".pdf");

            case "Download":
                $pdf = Pdf::loadView("admin.inquiry.pdf.new_ccl", compact('data'));
                return $pdf->download($data['filename'] . ".pdf");

            case "Save":
                NewCcl::updateOrCreate(['enquiry_id' => $id], $lte_data);
                return back()->with("success", "Successfully saved LTE Client Care Application");

            case "Email":
                $recipient = optional($data['advisor'])->email ?? config('mail.from.address');
                Mail::to($recipient)->send(new CclapplicationMail($data));

                return redirect()
                    ->route('enquiry.log', $id)// adjust route name as per your project
                    ->with("success", "Successfully sent Client Care Application");

            default:
                return back()->with("failed", "Invalid action specified.");
        }
    }

   public function showNewCcl($id)
    {
        $data = [];

        // Enquiry with relation
        $data['enquiry'] = Enquiry::with('cclapplication')->findOrFail($id);

        // Existing NewCcl record
        $data['newccl'] = NewCcl::where('enquiry_id', $id)->first();

        // Decode added names safely
        $addedNames = json_decode(optional($data['newccl'])->added_names_input ?? '[]', true);

        // Raw Inquiry
        $data['rawInquiry'] = RawInquiry::find($data['enquiry']->raw_enquiry_id);

        // If no newccl exists, make a fresh object with defaults
        if (!$data['newccl']) {
            $data['newccl'] = new NewCcl();
            $data['newccl']->full_address = optional($data['enquiry']->address)->full_address;
            $data['newccl']->full_name_with_title = $data['enquiry']->full_name_with_title ?? 'Default Name';
        }

        // Common data for form
        $data['country_code']     = $this->country_code;
        $data['currencies']       = IsoCurrency::all();
        $data['banks']            = Bank::whereStatus("active")->get();
        $data['documents']        = CompanyDocument::all();
        $data['advisors']         = Advisor::whereStatus("active")->get();

        // Lookup related models safely
        $data['advisor']          = Advisor::find($data['newccl']->advisor_id ?? null);
        $data['bank']             = Bank::find($data['newccl']->bank_id ?? null);
        $data['agreed_fee_currency'] = IsoCurrency::find($data['newccl']->agreed_fee_currency_id ?? null);
        $data['servicefee']       = Servicefee::find($data['newccl']->servicefee_id ?? null);
        $data['company_info']     = CompanyInfo::first();

        // Optional company info fields
        $data['regulated_by']     = CompanyInfo::find($data['newccl']->regulated_by ?? null);
        $data['regulation_no']    = CompanyInfo::find($data['newccl']->regulation_no ?? null);
        $data['stamp']            = CompanyInfo::find($data['newccl']->stamp ?? null);

        // Other optional fields
        $data['discussion_content'] = $data['newccl']->discussion_content ?? null;
        $data['additional_notes']   = $data['newccl']->additional_notes ?? null;

        // Country list
        $data['countries']        = IsoCountry::orderBy("order", "desc")->get();

        return view('admin.inquiry.new_ccl', compact('data', 'addedNames'));
    }


    // public function lteAdult(Request $request, $id)
    // {
    //     // Validate request
    //     $data = $this->validate($request, [
    //         'advisor_id' => "required",
    //         'visa_type' => "nullable",
    //         'tribunal_fee' => "nullable",
    //         'vat' => "nullable",
    //         'travel_fee' => "nullable",
    //         'reappear_fee' => "nullable",
    //         'full_address' => "required",
    //         'discussion_details' => "nullable",
    //         'full_name_with_title' => "nullable",
    //         'date' => "required",
    //         'discussion_date' => "required",
    //         'visa_application_submitted' => "required",
    //         'agreed_fee_currency_id' => "required",
    //         'servicefee_id' => "required",
    //         'agreed_fee' => "required|numeric",
    //         'bank_id' => 'required',
    //         'additional_notes' => 'nullable',
    //         'attachments' => 'nullable|array',
    //         'attachments.*' => 'file|max:5120',
    //         'documents' => 'nullable|array',
    //         'documents.*' => 'integer',
    //     ]);
    //     // Convert date to yyyy-mm-dd format before saving to the database
    //      $data['date'] = Carbon::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d');
    //      $data['discussion_date'] = Carbon::createFromFormat('d/m/Y', $data['discussion_date'])->format('Y-m-d');
    //      $data['visa_application_submitted'] = Carbon::createFromFormat('d/m/Y', $data['visa_application_submitted'])->format('Y-m-d');



    //     $lte_data = array_merge($data, [
    //         'enquiry_id' => $id,
    //         'advisor_id' => $data['advisor_id'],
    //         'visa_type' => $data['visa_type'],
    //         'tribunal_fee' => $data['tribunal_fee'],
    //         'vat' => $data['vat'],
    //         'travel_fee' => $data['travel_fee'],
    //         'reappear_fee' => $data['reappear_fee'],
    //         'full_address' => $data['full_address'],
    //         'discussion_details' => $data['discussion_details'],
    //         'full_name_with_title' => $data['full_name_with_title'] ?? '',
    //         'date' => $data['date'],
    //         'discussion_date' => $data['discussion_date'],
    //         'visa_application_submitted' => $data['visa_application_submitted'],
    //         'agreed_fee_currency_id' => $data['agreed_fee_currency_id'],
    //         'servicefee_id' => $data['servicefee_id'],
    //         'agreed_fee' => $data['agreed_fee'],
    //         'bank_id' => $data['bank_id'],
    //         'additional_notes' => $data['additional_notes'],
    //     ]);

    //     $sendemail = false;

    //     if ($request->action == "Email") $sendemail = true;

    //      // Handle attachments
    //     if ($request->hasFile('attachments')) {
    //         $data['attachments'] = $request->file('attachments'); // Keep the UploadedFile instances
    //     } else {
    //         $data['attachments'] = [];  // Ensure it is an empty array if no files are uploaded
    //     }
    //     $data['company_info'] = CompanyInfo::first();
    //     $data['country_code'] = IsoCountry::all();
    //     $data['countries'] = IsoCountry::all();
    //     $data['enquiry'] = Enquiry::findOrFail($id);
    //     $data['advisor'] = Advisor::find($data['advisor_id']);

    //     if (!$data['advisor']) {
    //         return back()->with("failed", "Advisor not found.");
    //     }

    //     $data['bank'] = Bank::findOrFail($data['bank_id']);
    //     $data['agreed_fee_currency'] = IsoCurrency::findOrFail($data['agreed_fee_currency_id']);
    //     $data['servicefee'] = Servicefee::findOrFail($data['servicefee_id']);
    //     //$data['visa'] = Visa::findOrFail($data['visa_id']);
    //     $data['enquiry_id'] = $id;
    //     $data['filename'] = "ENQ{$data['enquiry']->id} - Client Care Letter - {$data['enquiry']->full_name}";

    //     // Handle actions

    //     if ($request->action == "Preview") {
    //         $data['lteadult'] = LteAdult::where('enquiry_id', $id)->first();
    //         $pdf = PDF::loadView('admin.inquiry.pdf.lte_adult', compact('data'));
    //         return $pdf->stream();
    //     }

    //     if ($request->action == "Download") {
    //         $pdf = PDF::loadView("admin.inquiry.pdf.lte_adult", compact('data'));
    //         return $pdf->download($data['filename'] . ".pdf");
    //     }

    //     if ($request->action == "Save") {
    //         LteAdult::updateOrCreate(['enquiry_id' => $id], $lte_data);
    //         return back()->with("success", "Successfully saved LTE Client Care Letter");
    //     }

    //     if ($sendemail) {
    //         $data['lteadult'] = LteAdult::where('enquiry_id', $id)->first();
    //         Mail::send(new FoMail($data));

    //         return back()->with("success", "Successfully sent LTE Client Care Letter");
    //     }


    //     return back()->with("failed", "Invalid action specified.");
    // }

    // public function showLteAdult($id)
    // {
    //     $data = [];

    //     $data['enquiry'] = Enquiry::with('cclapplication')->findOrFail($id);
    //     $data['lteadult'] = LteAdult::where('enquiry_id', $id)->first();
    //     $data['rawInquiry'] = RawInquiry::find($data['enquiry']->raw_enquiry_id); // Fetch RawInquiry


    //     if ($data['lteadult'] == null) {
    //         $data['lteadult'] = new LteAdult;
    //         $data['lteadult']->full_address = optional($data['enquiry']->address)->full_address;
    //         $data['lteadult']->full_name_with_title = $data['enquiry']->full_name_with_title ?? 'Default Name'; // Provide a default

    //     }
    //     // Add the variable to the $data array to pass to the view

    //     $data['country_code'] = $this->country_code;
    //     $data['currencies'] = IsoCurrency::all();
    //     $data['banks'] = Bank::whereStatus("active")->get();
    //     $data['documents']= CompanyDocument::all();
    //     $data['advisors'] = Advisor::whereStatus("active")->get();
    //     $data['advisor'] = Advisor::find($data['lteadult']['advisor_id']);
    //     $data['bank'] = Bank::find($data['lteadult']['bank_id']);
    //     $data['agreed_fee_currency'] = IsoCurrency::find($data['lteadult']['agreed_fee_currency_id']);
    //     $data['servicefee'] = Servicefee::find($data['lteadult']['servicefee_id']);
    //     $data['company_info'] = CompanyInfo::first();
    //     $data['discussion_content'] = $data['lteadult']['discussion_content'];
    //     $data['countries'] = IsoCountry::orderBy("order", "desc")->get();
    //     //$data['countries'] = IsoCountry::all();
    //     $data['additional_notes'] = $data['lteadult']['additional_notes'];

    //     $data['refusalLetterDate'] = optional($data['rawInquiry'])->refusalLetterDate ?? '';
    //     $data['refusalreceivedDate'] = optional($data['rawInquiry'])->refusalreceivedDate ?? '';
    //     $data['applicationLocation'] = optional($data['rawInquiry'])->applicationLocation ?? '';
    //     $data['uan'] = optional($data['rawInquiry'])->uan ?? '';
    //     $data['ho_ref'] = optional($data['rawInquiry'])->ho_ref ?? '';
    //     $data['method_decision_received'] = optional($data['rawInquiry'])->method_decision_received ?? '';
    //     $data['sponsor_name'] = optional($data['rawInquiry'])->sponsor_name ?? '';
    //     $data['sponsor_relationship'] = optional($data['rawInquiry'])->sponsor_relationship ?? '';

    //     return view('admin.inquiry.lte_adult', compact('data'));
    // }

    // public function lteFmChild(Request $request, $id)
    // {
    //     // Validate request
    //     $data = $this->validate($request, [
    //         'advisor_id' => "required",
    //         'visa_type' => "nullable",
    //         'iso_country_id' => 'required',
    //         'intermediry_address' => 'required',
    //         'relationship_client' => 'required',
    //         'intermediry_name' => 'required',
    //         'intermed_notes' => 'nullable',
    //         'tribunal_fee' => "nullable",
    //         'vat' => "nullable",
    //         'travel_fee' => "nullable",
    //         'reappear_fee' => "nullable",
    //         'full_address' => "required",
    //         'discussion_details' => "nullable",
    //         'full_name_with_title' => "nullable",
    //         'date' => "required",
    //         'discussion_date' => "required",
    //         'visa_application_submitted' => "required",
    //         'agreed_fee_currency_id' => "required",
    //         'servicefee_id' => "required",
    //         'agreed_fee' => "required|numeric",
    //         'bank_id' => 'required',
    //         'additional_notes' => 'nullable',
    //         'attachments' => 'nullable|array',
    //         'attachments.*' => 'file|max:5120',
    //         'documents' => 'nullable|array',
    //         'documents.*' => 'integer',
    //     ]);
    //     // Convert date to yyyy-mm-dd format before saving to the database
    //      $data['date'] = Carbon::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d');
    //      $data['discussion_date'] = Carbon::createFromFormat('d/m/Y', $data['discussion_date'])->format('Y-m-d');
    //      $data['visa_application_submitted'] = Carbon::createFromFormat('d/m/Y', $data['visa_application_submitted'])->format('Y-m-d');



    //     $lte_data = array_merge($data, [
    //         'enquiry_id' => $id,
    //         'advisor_id' => $data['advisor_id'],
    //         'iso_country_id' => $data['iso_country_id'],
    //         'intermediry_address' => $data['intermediry_address'],
    //         'relationship_client' => $data['relationship_client'],
    //         'intermediry_name' => $data['intermediry_name'],
    //         'intermed_notes' => $data['intermed_notes'],
    //         'visa_type' => $data['visa_type'],
    //         'tribunal_fee' => $data['tribunal_fee'],
    //         'vat' => $data['vat'],
    //         'travel_fee' => $data['travel_fee'],
    //         'reappear_fee' => $data['reappear_fee'],
    //         'full_address' => $data['full_address'],
    //         'discussion_details' => $data['discussion_details'],
    //         'full_name_with_title' => $data['full_name_with_title'] ?? '',
    //         'date' => $data['date'],
    //         'discussion_date' => $data['discussion_date'],
    //         'visa_application_submitted' => $data['visa_application_submitted'],
    //         'agreed_fee_currency_id' => $data['agreed_fee_currency_id'],
    //         'servicefee_id' => $data['servicefee_id'],
    //         'agreed_fee' => $data['agreed_fee'],
    //         'bank_id' => $data['bank_id'],
    //         'additional_notes' => $data['additional_notes'],
    //     ]);

    //     $sendemail = false;

    //     if ($request->action == "Email") $sendemail = true;

    //      // Handle attachments
    //     if ($request->hasFile('attachments')) {
    //         $data['attachments'] = $request->file('attachments'); // Keep the UploadedFile instances
    //     } else {
    //         $data['attachments'] = [];  // Ensure it is an empty array if no files are uploaded
    //     }
    //     $data['company_info'] = CompanyInfo::first();
    //     $data['country_code'] = IsoCountry::all();
    //     $data['countries'] = IsoCountry::all();
    //     $data['enquiry'] = Enquiry::findOrFail($id);
    //     $data['advisor'] = Advisor::find($data['advisor_id']);

    //     if (!$data['advisor']) {
    //         return back()->with("failed", "Advisor not found.");
    //     }

    //     $data['bank'] = Bank::findOrFail($data['bank_id']);
    //     $data['agreed_fee_currency'] = IsoCurrency::findOrFail($data['agreed_fee_currency_id']);
    //     $data['servicefee'] = Servicefee::findOrFail($data['servicefee_id']);
    //     //$data['visa'] = Visa::findOrFail($data['visa_id']);
    //     $data['enquiry_id'] = $id;
    //     $data['filename'] = "ENQ{$data['enquiry']->id} - Client Care Letter - {$data['enquiry']->full_name}";

    //     // Handle actions

    //     if ($request->action == "Preview") {
    //         $data['ltefmchild'] = LteFmChild::where('enquiry_id', $id)->first();
    //         $pdf = PDF::loadView('admin.inquiry.pdf.lte_fm_child', compact('data'));
    //         return $pdf->stream();
    //     }

    //     if ($request->action == "Download") {
    //         $data['ltefmchild'] = LteFmChild::where('enquiry_id', $id)->first();
    //         $pdf = PDF::loadView("admin.inquiry.pdf.lte_fm_child", compact('data'));
    //         return $pdf->download($data['filename'] . ".pdf");
    //     }

    //     if ($request->action == "Save") {
    //         LteFmChild::updateOrCreate(['enquiry_id' => $id], $lte_data);
    //         return back()->with("success", "Successfully saved LTE FM Client Care Letter");
    //     }

    //     if ($sendemail) {
    //         $data['ltefmchild'] = LteFmChild::where('enquiry_id', $id)->first();
    //         Mail::send(new LtefmchildMail($data));

    //         return back()->with("success", "Successfully sent LTE FM Client Care Letter");
    //     }


    //     return back()->with("failed", "Invalid action specified.");
    // }

    // public function showLteFmChild($id)
    // {
    //     $data = [];

    //     $data['enquiry'] = Enquiry::with('cclapplication')->findOrFail($id);
    //     $data['ltefmchild'] = LteFmChild::where('enquiry_id', $id)->first();
    //     $data['rawInquiry'] = RawInquiry::find($data['enquiry']->raw_enquiry_id); // Fetch RawInquiry


    //     if ($data['ltefmchild'] == null) {
    //         $data['ltefmchild'] = new LteFmChild;
    //         $data['ltefmchild']->full_address = optional($data['enquiry']->address)->full_address;
    //         $data['ltefmchild']->full_name_with_title = $data['enquiry']->full_name_with_title ?? 'Default Name'; // Provide a default

    //     }
    //     // Add the variable to the $data array to pass to the view

    //     $data['country_code'] = $this->country_code;
    //     $data['currencies'] = IsoCurrency::all();
    //     $data['banks'] = Bank::whereStatus("active")->get();
    //     $data['documents']= CompanyDocument::all();
    //     $data['advisors'] = Advisor::whereStatus("active")->get();
    //     $data['advisor'] = Advisor::find($data['ltefmchild']['advisor_id']);
    //     $data['bank'] = Bank::find($data['ltefmchild']['bank_id']);
    //     $data['agreed_fee_currency'] = IsoCurrency::find($data['ltefmchild']['agreed_fee_currency_id']);
    //     $data['servicefee'] = Servicefee::find($data['ltefmchild']['servicefee_id']);
    //     $data['company_info'] = CompanyInfo::first();
    //     $data['discussion_content'] = $data['ltefmchild']['discussion_content'];
    //     $data['countries'] = IsoCountry::orderBy("order", "desc")->get();
    //     //$data['countries'] = IsoCountry::all();
    //     $data['additional_notes'] = $data['ltefmchild']['additional_notes'];

    //     $data['refusalLetterDate'] = optional($data['rawInquiry'])->refusalLetterDate ?? '';
    //     $data['refusalreceivedDate'] = optional($data['rawInquiry'])->refusalreceivedDate ?? '';
    //     $data['applicationLocation'] = optional($data['rawInquiry'])->applicationLocation ?? '';
    //     $data['uan'] = optional($data['rawInquiry'])->uan ?? '';
    //     $data['ho_ref'] = optional($data['rawInquiry'])->ho_ref ?? '';
    //     $data['method_decision_received'] = optional($data['rawInquiry'])->method_decision_received ?? '';
    //     $data['sponsor_name'] = optional($data['rawInquiry'])->sponsor_name ?? '';
    //     $data['sponsor_relationship'] = optional($data['rawInquiry'])->sponsor_relationship ?? '';

    //     return view('admin.inquiry.lte_fm_child', compact('data'));
    // }

    public function intermedCcl(Request $request, $id)
    {
        // Validate request
        $data = $this->validate($request, [
            'advisor_id' => "required",
            'vat' => "nullable",
            'full_address' => "required",
            'discussion_details' => "nullable",
            'full_name_with_title' => "nullable",
            'date' => "required",
            'agreed_fee_currency_id' => "required",
            'servicefee_id' => "required",
            'agreed_fee' => "required|numeric",
            'bank_id' => 'required',
            'iso_country_id' => 'required',
            'intermediry_address' => 'required',
            'relationship_client' => 'required',
            'intermediry_name' => 'required',
            'intermed_notes' => 'nullable',
            'additional_notes' => 'nullable',
            'application_type' => 'nullable',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:5120',
            'documents' => 'nullable|array',
            'documents.*' => 'integer',
        ]);
        // Convert date to yyyy-mm-dd format before saving to the database
         $data['date'] = Carbon::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d');

        $inter_data = array_merge($data, [
            'enquiry_id' => $id,
            'advisor_id' => $data['advisor_id'],
            'full_name_with_title' => $data['full_name_with_title'],
            'full_address' => $data['full_address'],
            'discussion_details' => $data['discussion_details'],
            'date' => $data['date'],
            'iso_country_id' => $data['iso_country_id'],
            'intermediry_address' => $data['intermediry_address'],
            'relationship_client' => $data['relationship_client'],
            'intermediry_name' => $data['intermediry_name'],
            'vat' => $data['vat'],
            'intermed_notes' => $data['intermed_notes'],
            'agreed_fee_currency_id' => $data['agreed_fee_currency_id'],
            'servicefee_id' => $data['servicefee_id'],
            'agreed_fee' => $data['agreed_fee'],
            'bank_id' =>$data['bank_id'],
            'intermed_notes' =>$data['intermed_notes'],
            'additional_notes' =>$data['additional_notes'],
            'application_type' =>$data['application_type'],


        ]);

        $sendemail = false;

        if ($request->action == "Email") $sendemail = true;

         // Handle attachments
        if ($request->hasFile('attachments')) {
            $data['attachments'] = $request->file('attachments'); // Keep the UploadedFile instances
        } else {
            $data['attachments'] = [];  // Ensure it is an empty array if no files are uploaded
        }
        $data['company_info'] = CompanyInfo::first();
        $data['country_code'] = IsoCountry::all();
        $data['countries'] = IsoCountry::all();
        $data['enquiry'] = Enquiry::findOrFail($id);
        $data['advisor'] = Advisor::find($data['advisor_id']);

        if (!$data['advisor']) {
            return back()->with("failed", "Advisor not found.");
        }

        $data['bank'] = Bank::findOrFail($data['bank_id']);
        $data['agreed_fee_currency'] = IsoCurrency::findOrFail($data['agreed_fee_currency_id']);
        $data['servicefee'] = Servicefee::findOrFail($data['servicefee_id']);
        $data['enquiry_id'] = $id;
        $data['filename'] = "ENQ{$data['enquiry']->id} - {$data['enquiry']->full_name} - Client Care Application with Intermediary";

        // Handle actions

        if ($request->action == "Preview") {
            $data['intermedccl'] = IntermedCcl::where('enquiry_id', $id)->first();
            $pdf = PDF::loadView('admin.inquiry.pdf.intermed_ccl', compact('data'));
            return $pdf->stream();
        }

        if ($request->action == "Download") {
            $data['intermedccl'] = IntermedCcl::where('enquiry_id', $id)->first();
            $pdf = PDF::loadView("admin.inquiry.pdf.intermed_ccl", compact('data'));
            return $pdf->download($data['filename'] . ".pdf");
        }

        if ($request->action == "Save") {
            IntermedCcl::updateOrCreate(['enquiry_id' => $id], $inter_data);
            return back()->with("success", "Successfully saved CCL Application with Intermediary");
        }

        if ($sendemail) {
            $data['intermedccl'] = IntermedCcl::where('enquiry_id', $id)->first();
            Mail::send(new IntermedMail($data));

            return back()->with("success", "Successfully sent CCL Application with Intermediary");
        }


        return back()->with("failed", "Invalid action specified.");
    }

    public function showIntermedCcl($id)
    {
        $data = array();
        $data['enquiry'] = Enquiry::with('clientcare')->findOrFail($id);
        $data['intermedccl'] = IntermedCcl::where('enquiry_id', $id)->first();

        if ($data['intermedccl'] == null) {
            $data['intermedccl'] = new IntermedCcl;
            $data['intermedccl']->full_address = optional($data['enquiry']->address)->full_address;
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
        $data['advisor'] = Advisor::find($data['intermedccl']['advisor_id']);
        $data['bank'] = Bank::find($data['intermedccl']['bank_id']);
        $data['agreed_fee_currency'] = IsoCurrency::find($data['intermedccl']['agreed_fee_currency_id']);
        $data['servicefee'] = Servicefee::find($data['intermedccl']['servicefee_id']);
        $data['company_info'] = CompanyInfo::first();
        $data['regulated_by'] = CompanyInfo::find($data['intermedccl']['regulated_by']);
        $data['regulated_by'] = CompanyInfo::find($data['intermedccl']['regulation_no']);
        $data['stamp'] = CompanyInfo::find($data['intermedccl']['stamp']);
        $data['discussion_content'] = $data['intermedccl']['discussion_content'];
        $data['countries'] = IsoCountry::orderBy("order", "desc")->get();
        $data['selected_country'] = IsoCountry::find($data['intermedccl']->iso_country_id)->title ?? '';

        //$data['authority_content'] = $data['clientcare']['authority_content'];

        return view('admin.inquiry.intermed_ccl', compact('data'));
    }




}
