<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RawInquiryDataTable;
use App\Mail\EnquiryProcessedMail;
use App\Mail\EnquiryVerifyMail;
use App\Models\ClientAddressDetail;
use App\Models\CompanyInfo;
use App\Models\Enquiry;
use App\Models\EnquiryActivity;
use App\Models\EnquiryType;
use App\Models\IsoCountry;
use App\Models\RawInquiry;
use App\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PDF;
use Spatie\Newsletter\NewsletterFacade;
use Str;

class RawInquiryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $title;
    private $country_code;
    private $enquiry_type;
    private $users;

    public function __construct()
    {
        $this->title = $this->getTitle();

        $this->country_code = $this->getCountryCode();
        $this->enquiry_type = EnquiryType::select('id', 'title')->get();
        $this->users = User::select('id', 'username')->orderBy('username', 'asc')->get();
    }


    public function index(Request $request,RawInquiryDataTable $dataTable)
    {

        return $dataTable->with(['startdate'=>$request->startdate,'enddate'=>$request->enddate,'status'=>$request->status])->render('rawinquiry.index');


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $this->validate($request,[
            'title','f_name','m_name','l_name',
            'country_iso_mobile','country_iso_tel'
            ,'tel','mobile','email','additional_details'
        ]);

        $inq = RawInquiry::create($data);

        if($request->redirect_to){
            return redirect($request->redirect_to);
        }
    }

    public function verify($uuid){
        $inq = RawInquiry::whereUniqueCode($uuid)->firstOrFail();
        $inq->validated_at = now();
        $inq->save();
        $data['companyinfo'] = \App\Models\CompanyInfo::first();
        NewsletterFacade::subscribeOrUpdate($inq->email, ['FNAME'=>$inq->f_name." ".$inq->m_name, 'LNAME'=>$inq->l_name,'ADDRESS'=>$inq->full_address,'PHONE'=>$inq->contact_number]);
        return view('enquiryform.verified',compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RawInquiry  $rawInquiry
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        //
        // dd(RawInquiry::all());
        $enq = RawInquiry::findOrFail($id);
        // dd($enq);
        $data['row']= $enq;
        $data['enquiry'] = $enq;
        return view("rawinquiry.show",compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RawInquiry  $rawInquiry
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data['row'] = RawInquiry::findOrFail($id);
        $data['countries'] = $this->getCountryCode();
        return view('rawinquiry.edit',compact('data'));

    }

    public function addNote(Request $request, $id)
    {
    $rawInquiry = RawInquiry::find($id);
    $rawInquiry->notes = $request->input('note');
    if ($request->input('process')) {
        // Process the raw inquiry here
        // For example:
        $rawInquiry->status = 'processed';
    }
    $rawInquiry->save();
    return redirect()->route('rawenquiry.process', $id)->with('success', 'Instruction added successfully!');
    }




    public function process($id){
        $data         = [];
        $rawInquiry = RawInquiry::findOrFail($id); // this is for note retrive
        $data['country_code'] = IsoCountry::all();
        $data['panel_name'] = 'Edit Enquiry';
        $data['row']        = RawInquiry::findOrFail($id);
        $data['notes'] = $data['row']->notes;
        $enq = Enquiry::where("raw_enquiry_id",$id)->first();
        if($enq){
            return redirect()->route('enquiry.log',$enq->id);
        }
        if (!$data['row']) {
            return 'No data found';
        }
        $data['title']        = $this->title;
        $data['country_code'] = $this->country_code;
        $data['enquiry_type'] = $this->enquiry_type;
        $data['users']        = $this->users;
        $data['countries'] = IsoCountry::all(); // this field added for toenquiry form country name dispaly
       // $data['enq_number'] = $data['row']->enq_number; // retrieve enq_number from RawInquiry model
        return view('rawinquiry.toenquiry', compact('data'));
    }


    public function storeToEnquiry(Request $request,$id){

            $data = $this->validate($request,[
                'title'=>'required',
                'first_name'=>'required',
                'surname'=>'required',
                'middle_name'=>'nullable',
                'mobile'=>'required',
                'email'=>'required',
                'enquiry_type_id'=>'required',
                'referral'=>'nullable',
                'instruction'=>'nullable',
                'note'=>'nullable',
                'enquiry_assigned_to'=>'required',
                'country_mobile'=>'required',
                'country_tel'=>'nullable','status'=>'required',
                'surname'=>'required',
                'status'=>'required',
                'address'=>'required',
                'notes'=>'required',
                'postal_code'=>'nullable',
                'country_id'=>'required',
                'iso_country_id'=>'nullable'
            ]);

            $data['mobile'] = preg_replace('/[^\x20-\x7E]/', '', $data['mobile']);
            $data['country_code'] = IsoCountry::all();
            $data['raw_enquiry_id']= $id;
            $data['modified_by'] = Auth::user()->id;
            $data['department_id'] = 1;
            // $data['nationality'] = optional(IsoCountry::find($data['iso_country_id']))->title;
            //$data['basic_info_id'] = $id;
            $data['row'] = RawInquiry::find($id);
            $data['companyinfo'] = CompanyInfo::first();
            $data['company_info'] =$data['companyinfo'];
            $data['countries'] = IsoCountry::all();
            $enquiry = Enquiry::find($id);
            $data['enquiry'] = $enquiry;
            $data['processed'] = true;
            // dd($request);
            $formType = isset($data['row']->form_type)? "enquiryform.pdfs.".$data['row']->form_type: "enquiryform.pdfs.processed";

            if($request->action == "preview"){

                $data['processed'] = false;

                $pdf = PDF::loadView($formType, compact('data'));
                $filename = "ENQ-Preview"."Enquiry confirmation-{$data['row']->full_name}.pdf";
                $path = storage_path('uploads/files/enquiryprocessed');
                //$filename = "Enquiry confirmation-{$data['row']->full_name}.pdf";

                return $pdf->stream($filename);
            }

            $result = Enquiry::create($data);



            if ($result) {
                $activity = new EnquiryActivity();
                $activity->enquiry_list_id = $result->id;
                $activity->status = 1;
                $activity->note = '';
                $activity->created_by = Auth::user()->id;
                $activity->processing = 0;
                $activity->save();
                if($data['country_id']!=null && $data['address']!=null){
                    ClientAddressDetail::create([
                        'overseas_address'=>$data['address'],
                        'enquiry_id'=>$result->id,
                        'overseas_postcode'=>$data['postal_code'],
                        'iso_countrylist_id'=>$data['country_id'],
                        'created_by'=>auth()->user()->id,
                        'modified_by'=>auth()->user()->id
                    ]);
                }
                if($request->send_processed_mail){
                   $data['enquiry'] = $result;
                    Mail::send(new EnquiryProcessedMail($data));
                }
                return redirect()->route('enquiry.list')->with('success', 'Enquiry has been created.');
            } else {
                return redirect()->back()->with('success', 'Enquiry has been created.');
            }

    }

   /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RawInquiry  $rawInquiry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $inq = RawInquiry::findOrFail($id);
        // $inq->update($request->all());
        $data = $request->all();
        $data['country_iso_mobile'] = $data['country_code'];
        $data['mobile'] = $data['contact_number'];
        //$data['additional_details'] = $data['enquiry'];
        if($request->resend_email){
            $data['validated_at'] = null;
            do {
                $data['unique_code'] = Str::random(8);
            } while (RawInquiry::whereUniqueCode($data['unique_code'])->count() != 0);
            $inq->unique_code = $data['unique_code'];
            $inq->save();
            $r['row'] = $inq;
            $r['companyinfo'] = CompanyInfo::firstOrFail();
            Mail::send(new EnquiryVerifyMail($r));
        }

        if($inq->form_type == 'immigration'):
            if($request->hasFile('refusal_document')){
                $file = $request->file('refusal_document');
                $filename = time().'-'.$file->getClientOriginalName();
                $data['refusal_document']=  Storage::disk('uploads')->putFileAs('refusal_document',$file,$filename);
            }

            if($request->hasFile('refusal_email')){

                $file = $request->file('refusal_email');
                $filename = time().'-'.$file->getClientOriginalName();

                $data['refusal_email']=  Storage::disk('uploads')->putFileAs('refusal_email',$file,$filename);

            }
            if($request->hasFile('appellant_passport')){
                $file = $request->file('appellant_passport');
                $filename = time().'-'.$file->getClientOriginalName();
                $data['appellant_passport']=  Storage::disk('uploads')->putFileAs('appellant_passport',$file,$filename);
            }
            if($request->hasFile('proff_address')){
                $file = $request->file('proff_address');
                $filename = time().'-'.$file->getClientOriginalName();
                $data['proff_address']=  Storage::disk('uploads')->putFileAs('proff_address',$file,$filename);
            }

            if($request->hasFile('additional_document')){
                $oldAdditionalData = isset($inq->additional_document)? json_decode($inq->additional_document):[];
                // $additional_files = [];
                foreach($request->file('additional_document') as $files){
                    $file = $files;
                    $filename = time().'-'.$file->getClientOriginalName();

                    $eachFile =  Storage::disk('uploads')->putFileAs('additional_document',$file,$filename);
                    array_push($oldAdditionalData, $eachFile);
                }
                $data['additional_document'] = json_encode($oldAdditionalData);
            }
        endif;

        $inq->update($data);
        $inq->refusalLetterDate = $request->input('refusalLetterDate');
        $inq->refusalReceived = $request->input('refusalReceived');
        $inq->birthDate = $request->input('birthDate');
        $inq->save();

        return redirect()->route('rawenquiry.index')->
        with('success',"Successfully updated the data");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RawInquiry  $rawInquiry
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $inq = RawInquiry::findOrFail($id);
        $inq->delete();
        return back()->with("success","Successfully deleted");
    }

    public function toggle($id)
    {
        //
        $inq = RawInquiry::findOrFail($id);
        $inq->active =! $inq->active;
        $inq->save();
        return back()->with("success","Successfully toggled");
    }
}
