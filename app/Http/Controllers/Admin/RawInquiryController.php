<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\EnquiryProcessedMail;
use App\Mail\EnquiryVerifyMail;
use App\Models\RawInquiry;
use App\Models\IsoCountry;
use App\Models\Enquiry;
use App\Models\EnquiryType;
use App\Models\User;
use App\Models\EnquiryActivity;
use App\Models\ClientAddressDetail;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class RawInquiryController extends BaseController
{   
    protected $title;
    protected $country_code;
    protected $enquiry_type;
    protected $users;

    public function __construct()
    {
        $this->title = $this->getTitle();
        $this->country_code = $this->getCountryCode();
        $this->enquiry_type = EnquiryType::select('id', 'title')->get();
        $this->users = User::select('id', 'username')->orderBy('username', 'asc')->get();
    }

    public function index(Request $request)
    {
        $query = RawInquiry::query()->latest();

        if ($request->startdate && $request->enddate) {
            $start = \Carbon\Carbon::parse($request->startdate)->startOfDay();
            $end = \Carbon\Carbon::parse($request->enddate)->endOfDay();
            $query->whereBetween('updated_at', [$start, $end]);
        }

        if ($request->status === 'processed') {
            $query->whereHas('enquiry');
        } elseif ($request->status === 'not_processed') {
            $query->whereDoesntHave('enquiry');
        }

        $inquiries = $query->paginate(10);

        return view('rawinquiry.index', compact('inquiries'));
    }

    public function show($id)
    {
        // Raw Inquiry fetch
        $row = RawInquiry::findOrFail($id);

        // Countries list
        $countries = IsoCountry::orderBy("order", "desc")->get();

        // Prepare data array as Blade expects
        $data = [
            'row'       => $row,
            'countries' => $countries,
            'enquiry'   => $row, // Optional, Blade मा $data['enquiry'] प्रयोग भएमा
        ];

        // Return view with $data
        return view("rawinquiry.show", compact('data'));
    }


    public function edit($id)
    {
        // Raw Inquiry fetch
        $row = RawInquiry::findOrFail($id);

        // Countries list
        $countries = IsoCountry::orderBy("order", "desc")->get();
        // Set default form_type if null
        $row->form_type = $row->form_type ?? 'general';

        // Prepare data array as Blade expects
        $data = [
            'row'       => $row,
            'countries' => $countries,
            'enquiry'   => $row, // Optional, Blade मा $data['enquiry'] प्रयोग भएमा
        ];

        return view('rawinquiry.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $inq = RawInquiry::findOrFail($id);

        // General fields
        $data = $request->except(['resend_email', '_token', '_method']);

        // Dates
        $inq->birthDate = $request->input('birthDate');
        $inq->refusalLetterDate = $request->input('refusalLetterDate');
        $inq->refusalReceived = $request->input('refusalreceivedDate');

        // Immigration file handling
        if ($inq->form_type == 'immigration') {
            $fileFields = ['refusal_document','appellant_passport','proff_address','additional_document'];
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    if ($field === 'additional_document') {
                        $oldFiles = $inq->$field ? json_decode($inq->$field, true) : [];
                        foreach ($request->file($field) as $file) {
                            $filename = time().'-'.$file->getClientOriginalName();
                            $stored = Storage::disk('uploads')->putFileAs($field, $file, $filename);
                            $oldFiles[] = $stored;
                        }
                        $data[$field] = json_encode($oldFiles);
                    } else {
                        $file = $request->file($field);
                        $filename = time().'-'.$file->getClientOriginalName();
                        $data[$field] = Storage::disk('uploads')->putFileAs($field, $file, $filename);
                    }
                }
            }
        }

        $inq->update($data);

        // Resend email verification
        if ($request->resend_email) {
            $inq->validated_at = null;
            do {
                $inq->unique_code = Str::random(8);
            } while (RawInquiry::whereUniqueCode($inq->unique_code)->exists());
            $inq->save();

            Mail::send(new EnquiryVerifyMail([
                'row' => $inq,
                'companyinfo' => CompanyInfo::first()
            ]));
        }

        return redirect()->route('rawenquiry.index')->with('success','Successfully updated the inquiry');
    }

    public function destroy($id)
    {
        $inq = RawInquiry::findOrFail($id);
        $inq->delete();
        return back()->with('success', 'Successfully deleted');
    }

    public function toggle($id)
    {
        $inq = RawInquiry::findOrFail($id);
        $inq->active = !$inq->active;
        $inq->save();

        return back()->with('success', 'Status updated successfully');
    }

    public function addNote(Request $request, $id)
    {
        $rawInquiry = RawInquiry::findOrFail($id);
        $rawInquiry->additional_details = $request->input('note');
        if ($request->input('process')) {
            $rawInquiry->status = 'processed';
        }
        $rawInquiry->save();

        return redirect()->route('rawenquiry.process', $id)->with('success', 'Instruction added successfully!');
    }

    public function process($id)
    {
        $row = RawInquiry::findOrFail($id);
        $data = [
            'row' => $row,
            'countries' => $this->getCountryCode(),
            'enquiry_type' => $this->enquiry_type,
            'users' => $this->users,
            'title' => $this->title
        ];

        $enq = Enquiry::where("raw_enquiry_id",$id)->first();
        if($enq){
            return redirect()->route('enquiry.log',$enq->id);
        }

        return view('rawinquiry.toenquiry', compact('data'));
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'title','f_name','m_name','l_name',
            'country_iso_mobile','country_iso_tel',
            'tel','mobile','email','additional_details'
        ]);

        $inq = RawInquiry::create($data);

        if($request->redirect_to){
            return redirect($request->redirect_to);
        }
    }

    public function storeToEnquiry(Request $request, int $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'enquiry_type_id' => 'required|integer',
            'referral' => 'nullable|string|max:255',
            'instruction' => 'nullable|string',
            'note' => 'nullable|string',
            'enquiry_assigned_to' => 'required|integer',
            'country_mobile' => 'required|string|max:10',
            'country_tel' => 'nullable|string|max:15',
            'status' => 'required|string|max:50',
            'address' => 'required|string',
            'notes' => 'required|string',
            'postal_code' => 'nullable|string|max:20',
            'country_id' => 'required|integer|exists:iso_countrylists,id',
            'iso_country_id' => 'nullable|integer|exists:iso_countrylists,id',
        ]);

        $validated['mobile'] = preg_replace('/[^\x20-\x7E]/', '', $validated['mobile']);
        $rawInquiry = RawInquiry::findOrFail($id);
        $validated['raw_enquiry_id'] = $id;
        $validated['modified_by'] = Auth::id();
        $validated['department_id'] = 1;

        $validated['row'] = $rawInquiry;
        $validated['companyinfo'] = CompanyInfo::first();
        $validated['company_info'] = $validated['companyinfo'];
        $validated['countries'] = IsoCountry::all();
        $validated['processed'] = true;

        $formType = $rawInquiry->form_type 
            ? "enquiryform.pdfs." . $rawInquiry->form_type 
            : "enquiryform.pdfs.processed";

        if ($request->action === 'preview') {
            $validated['processed'] = false;
            $pdf = PDF::loadView($formType, ['data' => $validated]);
            $filename = "ENQ-Preview-Enquiry-Confirmation-{$rawInquiry->full_name}.pdf";
            return $pdf->stream($filename);
        }

        $enquiry = Enquiry::create($validated);

        if ($enquiry) {
            EnquiryActivity::create([
                'enquiry_list_id' => $enquiry->id,
                'status' => 1,
                'note' => '',
                'created_by' => Auth::id(),
                'processing' => 0,
            ]);

            if (!empty($validated['country_id']) && !empty($validated['address'])) {
                ClientAddressDetail::create([
                    'overseas_address' => $validated['address'],
                    'enquiry_id' => $enquiry->id,
                    'overseas_postcode' => $validated['postal_code'] ?? null,
                    'iso_countrylist_id' => $validated['country_id'],
                    'created_by' => Auth::id(),
                    'modified_by' => Auth::id(),
                ]);
            }

            if ($request->send_processed_mail) {
                $validated['enquiry'] = $enquiry;
                Mail::send(new EnquiryProcessedMail($validated));
            }

            return redirect()->route('enquiry.list')->with('success', 'Enquiry has been created.');
        }

        return redirect()->back()->with('error', 'Failed to create enquiry.');
    }
}
