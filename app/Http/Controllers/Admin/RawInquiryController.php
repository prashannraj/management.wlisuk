<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\EnquiryProcessedMail;
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
use App\Http\Controllers\Admin\BankController;

class RawInquiryController extends BaseController
{   
    protected $title;
    protected $country_code;
    protected $enquiry_type;
    protected $users;
    /**
     * Constructor to initialize common data.
     */

     public function __construct()
    {
        $this->title = $this->getTitle();

        $this->country_code = $this->getCountryCode();
        $this->enquiry_type = EnquiryType::select('id', 'title')->get();
        $this->users = User::select('id', 'username')->orderBy('username', 'asc')->get();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = RawInquiry::query()->latest();

        // Date filter
        if ($request->startdate && $request->enddate) {
            $start = \Carbon\Carbon::parse($request->startdate)->startOfDay();
            $end = \Carbon\Carbon::parse($request->enddate)->endOfDay();
            $query->whereBetween('updated_at', [$start, $end]);
        }

        // Processed filter (based on relation enquiry)
        if ($request->status === 'processed') {
            $query->whereHas('enquiry');
        } elseif ($request->status === 'not_processed') {
            $query->whereDoesntHave('enquiry');
        }

        $inquiries = $query->paginate(10);

        return view('rawinquiry.index', compact('inquiries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $inq = RawInquiry::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('refusal_document')) {
            $file = $request->file('refusal_document');
            $data['refusal_document'] = $file->store('refusal_document', 'public');
        }

        $inq->update($data);

        return redirect()->route('rawenquiry.index')->with('success', 'Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $inq = RawInquiry::findOrFail($id);
        $inq->delete();
        return back()->with('success', 'Successfully deleted');
    }

    /**
     * Toggle active/inactive status.
     */
    public function toggle($id)
    {
        $inq = RawInquiry::findOrFail($id);
        $inq->active = !$inq->active;
        $inq->save();

        return back()->with('success', 'Status updated successfully');
    }

    /**
     * Add note / instruction to inquiry.
     */
    public function addNote(Request $request, $id)
    {
        $rawInquiry = RawInquiry::findOrFail($id);
        $rawInquiry->additional_details = $request->input('note'); // Save note
        if ($request->input('process')) {
            // Mark as processed
            $rawInquiry->status = 'processed';
        }
        $rawInquiry->save();

        return redirect()->route('rawenquiry.process', $id)->with('success', 'Instruction added successfully!');
    }

    /**
     * Show details of a specific inquiry.
     */
   public function show($id)
    {
        $row = RawInquiry::findOrFail($id);
        $data['row'] = $row;
        $data['countries'] = IsoCountry::orderBy("order", "desc")->get();
        return view('rawinquiry.show', compact('data'));
    }


    /**
     * Show edit form for a specific inquiry.
     */
    public function edit($id)
    {
        //
        $data['row'] = RawInquiry::findOrFail($id);
         $data['countries'] = $this->getCountryCode();
        return view('rawinquiry.edit',compact('data'));

    }

   

    /**
     * Show process form for a specific inquiry.
     */
    public function process($id)
    {
        $data['row'] = RawInquiry::findOrFail($id);
        $data['country_code'] = IsoCountry::all();
        $data['panel_name'] = 'Edit Enquiry';
        $data['countries'] = $this->getCountryCode();
        $data['enquiry_type'] = $this->enquiry_type;
        $data['users'] = $this->users;
        $data['title'] = $this->title;
        $data['notes'] = $data['row']->notes;
        $enq = Enquiry::where("raw_enquiry_id",$id)->first();
        if($enq){
            return redirect()->route('enquiry.log',$enq->id);
        }
        if (!$data['row']) {
            return 'No data found';
        }


        return view('rawinquiry.toenquiry',compact('data'));  


}
    /**
     * Store the inquiry as an official enquiry.
     */
    
    public function storeToEnquiry(Request $request, int $id)
    {
        // Validate request data
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

        // Clean mobile number
        $validated['mobile'] = preg_replace('/[^\x20-\x7E]/', '', $validated['mobile']);

        // Prepare additional data
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

        // Preview PDF if requested
        if ($request->action === 'preview') {
            $validated['processed'] = false;
            $pdf = PDF::loadView($formType, ['data' => $validated]);
            $filename = "ENQ-Preview-Enquiry-Confirmation-{$rawInquiry->full_name}.pdf";
            return $pdf->stream($filename);
        }

        // Store enquiry
        $enquiry = Enquiry::create($validated);

        if ($enquiry) {
            // Log activity
            EnquiryActivity::create([
                'enquiry_list_id' => $enquiry->id,
                'status' => 1,
                'note' => '',
                'created_by' => Auth::id(),
                'processing' => 0,
            ]);

            // Store client address if provided
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

            // Send processed mail if requested
            if ($request->send_processed_mail) {
                $validated['enquiry'] = $enquiry;
                Mail::send(new EnquiryProcessedMail($validated));
            }

            return redirect()->route('enquiry.list')->with('success', 'Enquiry has been created.');
        }

        return redirect()->back()->with('error', 'Failed to create enquiry.');
    }

}
