<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use App\Models\Enquiry;
use Session;
use App\Models\BasicInfo;
use App\Models\StudentContactDetail;
use App\Models\ClientAddressDetail;
use App\Models\ClientEmergencyDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\StudentContactDetailRequest;
use App\Models\PassportDetail;
use App\Models\UkVisa;
use App\Models\Visa;
use App\Repositories\Enquiry\EnquiryInterface as EnquiryInterface;
use DataTables;

class ClientController extends BaseController
{
    private $title;
    private $enquiry;
    private $country_code;
    // private $users;

    public function __construct(EnquiryInterface $enquiry){
        $this->middleware('auth');
        $this->enquiry = $enquiry;
        $this->title = $this->getTitle();
        $this->country_code = $this->getCounrtyCode();
        // $this->users = User::select('id','username')->orderBy('username','asc')->get();
    }

    public function ajaxIndex(Request $request){
        $search = $request->q ?? "";
       
        $data = \App\Models\BasicInfo::select("*");
        $data->where('f_name','LIKE','%'.$search."%")->with("addresses");
        $data->limit(6);
        return response()->json($data->get());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	
    	if($request->ajax()){
    		return $this->datatable($request);
    	}
    	
    	
		$data = [];
        $data['panel_name'] = 'List of Clients';
        $data['enquiry_type'] = \App\Models\EnquiryType::all();              
        return view('admin.client.list',compact('data'));
    }
    
    
    private function datatable($request){
    		$data = \App\Models\BasicInfo::select("*");
    		if($request->status){
    			$data = $data->where("status",$request->status);
    		}
            // dd($data);
            return Datatables::of($data)
                    // ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $editUrl = route('edit.basic_info', ['id' => $row->id]);
                        $viewUrl = route('client.view', ['id' => $row->id]);
                        $profileUrl = route('client.show', ['id' => $row->id]);
                        // $deleteUrl = route('enquiry.delete', ['id' => $row->id]);
                        $btn =  '   <a href="'. $viewUrl .'" class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a> '.
                                '   <a href="'. $editUrl .'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i></a>'.
                                '   <a href="'. $profileUrl .'" class="edit btn btn-success btn-sm"><i class="fas fa-address-card"></i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function enquiryToClient($id)
    {
        $data = [];
        $data['country_code'] = $this->country_code;        

        $enquiry = Enquiry::findOrFail($id);
        if(!$enquiry){
            return 'enquiry not found';
        }

        $basicInfo = $enquiry->basicinfo;
        if($basicInfo==null){
            $basicInfo = $enquiry->client;
        }
        if($basicInfo){
            // $data['panel_name']     = 'Add Client Information';
            // $data['title']          = $this->title;
            // $data['contact_detail'] = $basicInfo->studentContactDetails;
            // $data['basic_info']     = $basicInfo;
            // return view('admin.basic_info.dashboard',compact('data'));
            return redirect()->route('client.show',$basicInfo->id);
        }
        $data['panel_name'] = 'Add Client Information (Enquiry of : '.$enquiry->full_name.")";
        $data['title']      = $this->title;
        $data['row']        = $enquiry;
        // dd("help");
        return view('admin.basic_info.create',compact('data'));
    }
    
    public function show($id){
    	
        $data = [];
        $data['country_code'] = $this->country_code;        

        $enquiry = \App\Models\BasicInfo::with('invoices','receipts','immigration_application_processes')->find($id);
        if(!$enquiry){
            return 'enquiry not found';
        }

        $basicInfo = $enquiry;

        // if($basicInfo){
            $data['panel_name']     = 'Add Client Information';
            $data['title']          = $this->title;
            $data['contact_detail'] = $basicInfo->studentContactDetails;
            $data['basic_info']     = $basicInfo;
            $data['immigration_documents']= ($basicInfo->immigration_application_processes()->where('document','!=','')->get());
            $data['active_visas'] = $basicInfo->currentvisa()->whereStatus("Active")->get();
            return view('admin.basic_info.dashboard',compact('data'));
        // }
        // $data['panel_name'] = 'Add Client Information';
        // $data['title']      = $this->title;
        // $data['row']        = $enquiry;
        // // dd("help");
        // return view('admin.basic_info.create',compact('data'));
    }


	public function view($id){
		return redirect()->route('client.show',$id);
	}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editBasicInfo($id)
    {
        $data = [];
        $data['country_code'] = $this->country_code;        

        // $enquiry = $this->enquiry->find($id);
        // if(!$enquiry){
        //     return 'enquiry not found';
        // }

        $basicInfo = BasicInfo::find($id);
        // dd($basicInfo);

        if(!$basicInfo){
            return 'Not found';
        }
        $data['panel_name']     = 'Edit Client Information';
        $data['title']          = $this->title;
        $data['contact_detail'] = $basicInfo->studentContactDetails;
        $data['basic_info']     = $basicInfo;
        $data['row']        = $basicInfo;
        return view('admin.basic_info.edit',compact('data'));

    }

    public function updateBasicInfo(Request $request, $id)
    {
        // dd($request->all());
        try {
            // dd($request->all());
            $basicInfo = BasicInfo::findOrFail($id);
            if(!$basicInfo){
                // return 'Already Exists';
            }
            DB:: beginTransaction();
            // $basicInfo                  = new BasicInfo();
            $basicInfo->title           = $request->title;
            $basicInfo->l_name          = ucfirst($request->surname);
            $basicInfo->f_name          = ucfirst($request->firstName);
            $basicInfo->m_name          = ucfirst($request->middleName);
            $basicInfo->dob             = ($request->dob);
            if($request->enquiry_id){
                $basicInfo->enquiry_list_id = $request->enquiry_id;
            }
            $basicInfo->gender          = $request->gender;
            $basicInfo->status          = $request->status;
            $basicInfo->created_by      = Auth::user()->id;
            $basicInfo->modified_by     = Auth::user()->id;
            $basicInfo->department_id   = 1;
            if($basicInfo->status == "Inactive"){
                $basicInfo->delete_at = now()->addMonths(config('cms.delete_after'));
            }else{
                $basicInfo->delete_at = null;
            }
            if($basicInfo->save()){
                $data['panel_name'] = 'Client Information';
                $data['title'] = $this->title;
                $data['contact_detail'] = $basicInfo->studentContactDetails;
                $data['basic_info'] = $basicInfo;
                DB::commit();
                
                Session::flash('success', 'Basic Info has been updated.');
                return redirect()->route('edit.basic_info', ['id' => $basicInfo->id]);
                // return redirect()->route('enquiry.list');   
            }else{
                Session::flash('failed', 'Basic Info could not be created.');
                return redirect()->back();  
            }
        } catch (\Throwable $th) {
            DB::rollBack();
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->route();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addBasicInfo(Request $request)
    {
    	$this->validate($request,[
    		'title'=>"required",
    		'surname'=>"required",
    		'firstName'=>"required",
    		'middleName'=>"nullable",
    		'dob'=>"required",
    		'gender'=>"required",
    		'status'=>"required",
    		'id'=>"required",
    	]);
        try {
            // dd($request->all());
            $basicInfo = BasicInfo::where('enquiry_list_id',$request->id)->first();
            if($request->id && $basicInfo){
                return 'Already Exists';
            }
            $enquiry = Enquiry::find($request->id);
            // dd($basicInfo);
            DB:: beginTransaction();
            $basicInfo                  = new BasicInfo();
            $basicInfo->title           = $request->title;
            $basicInfo->l_name          = ucfirst($request->surname);
            $basicInfo->f_name          = ucfirst($request->firstName);
            $basicInfo->m_name          = ucfirst($request->middleName);
            $basicInfo->dob             = $request->dob;
            $basicInfo->enquiry_list_id = $request->id;
            $basicInfo->gender          = $request->gender;
            $basicInfo->status          = $request->status;
            $basicInfo->created_by      = Auth::user()->id;
            $basicInfo->modified_by     = Auth::user()->id;
            $basicInfo->department_id   = 1;
            // dd($enquiry->address->toArray());
            if($basicInfo->save()){
                $studentContactDetail = StudentContactDetail::where('enquiry_list_id',$request->id)->first();
                if(!$studentContactDetail){
                    $studentContactDetail = new StudentContactDetail();
                }
                if($enquiry!=null){
                    $studentContactDetail->primary_mobile = $enquiry->mobile;
                    $studentContactDetail->country_mobile = $enquiry->country_mobile;
                    $studentContactDetail->contact_number_two = $enquiry->tel;
                    $studentContactDetail->country_contacttwo = $enquiry->country_tel;
                    $studentContactDetail->primary_email  = $enquiry->email;

                }
                $studentContactDetail->basic_info_id = $basicInfo->id;
                $studentContactDetail->created_by    = Auth::user()->id;
                $studentContactDetail->modified_by   = Auth::user()->id;
            
                $studentContactDetail->save();

                //client address
                if($enquiry->address){
                    $d= $enquiry->address->toArray();
                    $d['basic_info_id'] = $basicInfo->id;
                    $d['enquiry_id']= null;
                    ClientAddressDetail::create($d);
                }
                // if($basicInfo){
                $data['panel_name'] = 'Client Information';
                $data['title'] = $this->title;
                $data['contact_detail'] = $basicInfo->studentContactDetails;
                $data['basic_info'] = $basicInfo;
                DB::commit();
                Session::flash('success', 'Basic Info has been added.');
                return redirect()->route('client.show', ['id' => $basicInfo->id]);
                // return redirect()->route('enquiry.list');   
            }else{
                Session::flash('failed', 'Basic Info could not be created.');
                return redirect()->back();  
            }
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $basicinfo = BasicInfo::find($id);
        if($basicinfo){
            $basicinfo->delete();
        }

        return back()->with("success","Deleted client");
    }

    public function restore($id)
    {
        //
        $basicinfo = BasicInfo::withTrashed()->find($id);
        if($basicinfo){
            $basicinfo->restore();
        }

        return back()->with("success","Restored client");
    }


    public function deletePermanently($id)
    {
        //
        $basicinfo = BasicInfo::withTrashed()->find($id);
        if($basicinfo){
            

            
            $basicinfo->forceDelete();
        }

        return back()->with("success","Deleted client permanently");
    }
    
    public function addStudentContactDetail(Request $request,$id = null)
    {

        $validator = \Validator::make($request->all(), [
            "enquiry_list_id" => "sometimes|exists:enquiry_lists,id",
            "basic_info_id" => "required|exists:basic_infos,id",
            "country_mobile" => "required",
            "primary_mobile" => "required",
            "country_contacttwo" => "",
            "contact_number_two" => "",
            "primary_email" => "email"
        ]);
        $html = ''; 
        // dd($validator->errors()->toArray());
        foreach($validator->errors()->toArray() as $key => $value){
            foreach($value as $error){
                $html .= '<li>' . $error . '</li>';
            }
        }
        $output = '<ul class="alert alert-danger">' . $html . '</ul>';
        if ($validator->fails()) {
            return response()->json([
                'status'=> false,
                'message' => $output
            ],
            400
            );
        }

        try {
            if($id){
                $studentContactDetail = StudentContactDetail::find($id);
            }else{
                $studentContactDetail = new StudentContactDetail();
            }
            $studentContactDetail->basic_info_id = $request->basic_info_id;
            $studentContactDetail->country_mobile   = $request->country_mobile;
            $studentContactDetail->primary_mobile = $request->primary_mobile;
            $studentContactDetail->country_contacttwo  = $request->country_contacttwo;
            $studentContactDetail->contact_number_two = $request->contact_number_two;
            $studentContactDetail->primary_email = $request->primary_email;
            $studentContactDetail->enquiry_list_id  = $request->enquiry_list_id;  
            $studentContactDetail->created_by   = Auth::user()->id;  
            $studentContactDetail->created  = now();
            $studentContactDetail->modified = now();
            $studentContactDetail->modified_by  = Auth::user()->id;
            if($studentContactDetail->save()){
                // dd($studentContactDetail);
                $data = StudentContactDetail::where('basic_info_id',$studentContactDetail->basic_info_id)->get();
                $output = '';
                if(count($data) > 0){
                    foreach($data as $contactDetail)
                    {
                        $html = '';
                        $html .= '<td>' . $contactDetail->id . '</td>';
                        $html .= '<td>' . $contactDetail->contact_mobile . '</td>';
                        $html .= '<td>' . $contactDetail->primary_email . '</td>'; 
                        $html .= '<td>' . $contactDetail->contact_tel . '</td>';
                        $output .= '<tr>' . $html . '</tr>';
                    }
                }else{
                    $html = 'No data found';
                    $output = $html;
                }
                
                return response()->json([
                    'status'=> true,
                    'data' => $output,
                    'message' => 'Added Successfully.'
                ],
                200
                );
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Emergency Details
    public function addStudentEmergencyDetail(Request $request,$id = null)
    {
        // dd($request->all());
        $validator = \Validator::make($request->all(), [
            // "enquiry_list_id" => "sometimes|exists:enquiry_lists,id",
            "basic_info_id"  => "required|exists:basic_infos,id",
            "name"           => "required",
            "relationship"   => "required",
            "contact_number" => "required",
            "email"          => "email",
            "address"        => "",
        ]);

        $html = ''; 
        // dd($validator->errors()->toArray());
        foreach($validator->errors()->toArray() as $key => $value){
            foreach($value as $error){
                $html .= '<li>' . $error . '</li>';
            }
        }
        $output = '<ul class="alert alert-danger">' . $html . '</ul>';
        if ($validator->fails()) {
            return response()->json([
                'status'=> false,
                'message' => $output
            ],
            400
            );
        }

        try {
            if($id){
                $clientEmergencyDetail = ClientEmergencyDetail::find($id);
            }else{
                $clientEmergencyDetail = new ClientEmergencyDetail();
            }
            $clientEmergencyDetail->basic_info_id  = $request->basic_info_id;
            $clientEmergencyDetail->name = $request->name;
            $clientEmergencyDetail->contact_number = $request->contact_number;
            $clientEmergencyDetail->relationship = $request->relationship;
            $clientEmergencyDetail->address = $request->address;
            $clientEmergencyDetail->email  = $request->email;
            $clientEmergencyDetail->created_by     = Auth::user()->id;
            $clientEmergencyDetail->created        = now();
            $clientEmergencyDetail->modified       = now();
            $clientEmergencyDetail->modified_by    = Auth::user()->id;
            if($clientEmergencyDetail->save()){
                // dd($studentContactDetail);
                $data = ClientEmergencyDetail::where('basic_info_id',$clientEmergencyDetail->basic_info_id)->get();
                $output = '';
                if(count($data) > 0){
                    foreach($data as $emergencyDetail)
                    {
                        $html  = '';
                        $html .= '<td>' . $emergencyDetail->id . '</td>';
                        $html .= '<td>' . $emergencyDetail->name . '</td>';
                        $html .= '<td>' . $emergencyDetail->relationship . '</td>';
                        $html .= '<td>' . $emergencyDetail->contact_number . '</td>';
                        $output .= '<tr>' . $html . '</tr>';
                    }
                }else{
                    $html   = 'No data found';
                    $output = $html;
                }
                
                return response()->json([
                    'status'  => true,
                    'data'    => $output,
                    'message' => 'Added Successfully.'
                ],
                200
                );
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function addStudentAddressDetail(Request $request,$id = null)
    {
        // dd($request->all());
        $validator = \Validator::make($request->all(), [
            // "enquiry_list_id" => "sometimes|exists:enquiry_lists,id",
            'basic_info_id'      => 'required|exists:basic_infos,id',
            'iso_countrylist_id' => 'required|exists:iso_countrylists,id',
            'overseas_address'   => 'required',
            'overseas_postcode'  => '',
            'uk_address'         => '',
            'uk_postcode'        => '',
        ], [
            'iso_countrylist_id.required'    => 'The country is required and must be a valid country.',
            'overseas_address.required'    => 'The address is required.',
            'overseas_postcode.required'    => 'The post code is required.',
        ]);



        $html = ''; 
        // dd($validator->errors()->toArray());
        foreach($validator->errors()->toArray() as $key => $value){
            foreach($value as $error){
                $html .= '<li>' . $error . '</li>';
            }
        }
        $output = '<ul class="alert alert-danger">' . $html . '</ul>';
        if ($validator->fails()) {
            return response()->json([
                'status'=> false,
                'message' => $output
            ],
            400
            );
        }

        try {
            if($id){
                $clientAddressDetail = ClientAddressDetail::find($id);
            }else{
                $clientAddressDetail = new ClientAddressDetail();
            }
            $clientAddressDetail->basic_info_id  = $request->basic_info_id;
            $clientAddressDetail->overseas_address = $request->overseas_address;
            $clientAddressDetail->iso_countrylist_id = $request->iso_countrylist_id;
            $clientAddressDetail->overseas_postcode = $request->overseas_postcode;
            $clientAddressDetail->created_by     = Auth::user()->id;
            $clientAddressDetail->created        = now();
            $clientAddressDetail->modified       = now();
            $clientAddressDetail->modified_by    = Auth::user()->id;
            if($clientAddressDetail->save()){
                // dd($studentContactDetail);
                $data = ClientAddressDetail::where('basic_info_id',$clientAddressDetail->basic_info_id)->get();
                $output = '';
                if(count($data) > 0){
                    foreach($data as $addressDetail)
                    {
                        $html  = '';
                        $html .= '<td>' . $addressDetail->id . '</td>';
                        $html .= '<td>' . $addressDetail->country->title . '</td>';
                        $html .= '<td>' . $addressDetail->overseas_address . '</td>';
                        $html .= '<td>' . $addressDetail->overseas_post_code . '</td>';
                        $output .= '<tr>' . $html . '</tr>';
                    }
                }else{
                    $html   = 'No data found';
                    $output = $html;
                }
                
                return response()->json([
                    'status'  => true,
                    'data'    => $output,
                    'message' => 'Added Successfully.'
                ],
                200
                );
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function editClientAddress($id)
    {
        if (!$id) {

        }

        $data['panel_name'] = 'Edit Client Address';
        $data['title'] = $this->title;
        // $data['contact_detail'] = $basicInfo->studentContactDetails;
        // $data['basic_info'] = ;
        $url = '';
        $data['link'] = $url;
        $data['row'] = ClientAddressDetail::find($id);
        $data['country_code'] = $this->country_code;
        // dd($data['row']); 

        return view('admin.basic_info.contact.edit_address',compact('data'));
    }

    public function updateClientAddress(Request $request, $id)
    { 
        // dd($request->all());
        $validator = \Validator::make($request->all(), [
            "id" => "required|exists:student_addresses,id",
            'basic_info_id'      => 'required|exists:basic_infos,id',
            'iso_countrylist_id' => 'required|exists:iso_countrylists,id',
            'overseas_address'   => 'required',
            'overseas_postcode'  => 'required',
            'uk_address'         => '',
            'uk_postcode'        => '',
        ], [
            'iso_countrylist_id.required'    => 'The country is required and must be a valid country.',
            'overseas_address.required'    => 'The address is required.',
            'overseas_postcode.required'    => 'The post code is required.',
        ]);

        try {
            $clientAddressDetail = ClientAddressDetail::find($id);
            $clientAddressDetail->basic_info_id  = $clientAddressDetail->basic_info_id;
            $clientAddressDetail->overseas_address = $request->overseas_address;
            $clientAddressDetail->iso_countrylist_id = $request->iso_countrylist_id;
            $clientAddressDetail->overseas_postcode = $request->overseas_postcode;
            $clientAddressDetail->created_by     = $clientAddressDetail->created_by;
            $clientAddressDetail->created        = now();
            $clientAddressDetail->modified       = now();
            $clientAddressDetail->modified_by    = Auth::user()->id;
            if($clientAddressDetail->save()){
                return redirect()->route('client.show', ['id' =>  $request->basic_info_id]);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function editClientEmergency($id)
    {
        if (!$id) {

        }

        $data['panel_name'] = 'Edit Client Emergency';
        $data['title'] = $this->title;
        // $data['contact_detail'] = $basicInfo->studentContactDetails;
        // $data['basic_info'] = ;
        $url = '';
        $data['link'] = $url;
        $data['row'] = ClientEmergencyDetail::find($id);
        $data['country_code'] = $this->country_code;
        // dd($data['row']); 

        return view('admin.basic_info.contact.edit_emergency',compact('data'));
    }

    public function updateClientEmergency(Request $request, $id)
    { 
        $validator = \Validator::make($request->all(), [
            // "id" => "required|exists:student_addresses,id",
            // "enquiry_list_id" => "sometimes|exists:enquiry_lists,id",
            "basic_info_id"  => "required|exists:basic_infos,id",
            "name"           => "required",
            "relationship"   => "required",
            "contact_number" => "required",
            "email"          => "email",
            "address"        => "",
        ]);
        
        try {
            $clientEmergencyDetail = ClientEmergencyDetail::find($id);
            $clientEmergencyDetail->basic_info_id  = $request->basic_info_id;
            $clientEmergencyDetail->name = $request->name;
            $clientEmergencyDetail->contact_number = $request->contact_number;
            $clientEmergencyDetail->relationship = $request->relationship;
            $clientEmergencyDetail->address = $request->address;
            $clientEmergencyDetail->email  = $request->email;
            $clientEmergencyDetail->created_by     = $clientEmergencyDetail->created_by;
            $clientEmergencyDetail->created        = now();
            $clientEmergencyDetail->modified       = now();
            $clientEmergencyDetail->modified_by    = Auth::user()->id;
            if($clientEmergencyDetail->save()){
                return redirect()->route('client.show', ['id' =>  $request->basic_info_id]);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function editClientCurrentContact($id)
    {
        if (!$id) {

        }

        $data['panel_name'] = 'Edit Client Current Details';
        $data['title'] = $this->title;
        // $data['contact_detail'] = $basicInfo->studentContactDetails;
        // $data['basic_info'] = ;
        $url = '';
        $data['link'] = $url;
        $data['row'] = StudentContactDetail::find($id);
        $data['country_code'] = $this->country_code;
        // dd($data['row']); 

        return view('admin.basic_info.contact.edit_contact',compact('data'));
    }

    public function updateClientCurrentContact(Request $request, $id)
    { 
        $validator = \Validator::make($request->all(), [
            "enquiry_list_id" => "sometimes|exists:enquiry_lists,id",
            "basic_info_id" => "required|exists:basic_infos,id",
            "country_mobile" => "required|exists:basic_infos,id",
            "primary_mobile" => "required",
            "country_contacttwo" => "",
            "contact_number_two" => "",
            "primary_email" => "email"
        ]);
        
        try {
            $studentContactDetail = StudentContactDetail::find($id);
            if(!$studentContactDetail){
                return 'not found';
            }

            $studentContactDetail->basic_info_id = $request->basic_info_id;
            $studentContactDetail->country_mobile   = $request->country_mobile;
            $studentContactDetail->primary_mobile = $request->primary_mobile;
            $studentContactDetail->country_contacttwo  = $request->country_contacttwo;
            $studentContactDetail->contact_number_two = $request->contact_number_two;
            $studentContactDetail->primary_email = $request->primary_email;
            $studentContactDetail->enquiry_list_id  = $request->enquiry_list_id;  
            $studentContactDetail->created_by     = $studentContactDetail->created_by;
            $studentContactDetail->created  = now();
            $studentContactDetail->modified = now();
            $studentContactDetail->modified_by  = Auth::user()->id;
            if($studentContactDetail->save()){
                return redirect()->route('client.show', ['id' =>  $request->basic_info_id]);

            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function addPassportDetail($id){
        $data = [];
        $basicInfo = BasicInfo::find($id);
        if(!$basicInfo){
            return 'Not Found';
        }
        $data['panel_name'] = "Add Passport Detail For #". $basicInfo->full_name ;
        $url = '';
        $data['link'] = $url;
        $data['country_code'] = $this->country_code;
        $data['row'] = $basicInfo;
        return view('admin.basic_info.immigration.add_passport',compact('data'));
    }

    public function showPassportDetail($id){
        $data = [];
        $passport = PassportDetail::find($id);
        if(!$passport){
            return 'Not Found';
        }
        $data['panel_name'] = "Passport Detail For #". $passport->basicinfo->full_name ;
        $url = '';
        $data['link'] = $url;
        $data['country_code'] = $this->country_code;
        $data['row'] = $passport;
        return view('admin.basic_info.immigration.show_passport',compact('data'));
    }
    
    public function editPassportDetail($id){
        $data = [];
        $passport = PassportDetail::find($id);
        if(!$passport){
            return 'Not Found';
        }
        $data['panel_name'] = "Add Passport Detail For #". $passport->basicinfo->full_name ;
        $url = '';
        $data['link'] = $url;
        $data['country_code'] = $this->country_code;
        $data['row'] = $passport;
        return view('admin.basic_info.immigration.edit_passport',compact('data'));
    }



    public function storePassport(Request $request){
        
        $validator = \Validator::make($request->all(), [
            "basic_info_id" => "required|exists:basic_infos,id",
            "iso_countrylist_id" => "required|exists:iso_countrylists,id",
            "passport_number" => "required",
            "issue_date" => "required",
            "expiry_date" => "required"
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            $passport = new PassportDetail();
            $passport->basic_info_id = $request->basic_info_id;
            $passport->iso_countrylist_id = $request->iso_countrylist_id;
            $passport->passport_number = $request->passport_number;
            $passport->citizenship_number = $request->citizenship_number;
            $passport->birth_place = $request->birth_place;
            $passport->issuing_authority = $request->issuing_authority;
            $passport->issue_date = ($request->issue_date);//? $request->issue_date : '';
            $passport->expiry_date = ($request->expiry_date);//? $request->expiry_date : '';
            $passport->created_by     = Auth::user()->id;
            $passport->created        = now();
            $passport->modified       = now();
            $passport->modified_by    = Auth::user()->id;
            if($passport->save()){
                return redirect()->route('client.show',['id'=>$request->basic_info_id,'click'=>'immigration_info'])->with('success','Add success');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }   
    }

    public function updatePassport(Request $request, $id){

        $passport = PassportDetail::find($id);
        if(!$passport){
            return 'Not Found';
        }

        $validator = \Validator::make($request->all(), [
            "basic_info_id" => "required|exists:basic_infos,id",
            "iso_countrylist_id" => "required|exists:iso_countrylists,id",
            "passport_number" => "",
            "issue_date" => "",
            "expiry_date" => ""
        ]);

        try{

            $passport->basic_info_id = $request->basic_info_id;
            $passport->iso_countrylist_id = $request->iso_countrylist_id;
            $passport->passport_number = $request->passport_number;
            $passport->citizenship_number = $request->citizenship_number;
            $passport->birth_place = $request->birth_place;
            $passport->issuing_authority = $request->issuing_authority;
            $passport->issue_date = ($request->issue_date)? $request->issue_date : '';
            $passport->expiry_date = ($request->expiry_date)? $request->expiry_date : '';
            $passport->created_by     = $passport->created_by;
            $passport->created        = now();
            $passport->modified       = now();
            $passport->modified_by    = Auth::user()->id;
            if($passport->save()){
                return redirect()->route('client.show',['id'=>$request->basic_info_id,'click'=>'immigration_info'])->with('success','updated successfully');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }   
    }

    public function addVisaDetail($id){
        $data = [];
        $basicInfo = BasicInfo::find($id);
        if(!$basicInfo){
            return 'Not Found';
        }
              $url            = '';
        $data['panel_name']   = "Add Visa Detail For #". $basicInfo->full_name ;
        $data['link']         = $url;
        $data['country_code'] = $this->country_code;
        $data['row']          = $basicInfo;
        return view('admin.basic_info.immigration.visa.add_visa',compact('data'));
    }



    public function showVisaDetail($id)
    {
        $data = [];
        $visa = Visa::find($id);
        // dd($visa);
        if(!$visa){
            return 'Not Found';
        }
        $data['panel_name'] = "Visa Detail For #". $visa->basicinfo->full_name ;
              $url    = '';
        $data['link'] = $url;
        $data['row']  = $visa;
        return view('admin.basic_info.immigration.visa.show',compact('data'));
    }

    public function editVisaDetail($id){
        $data = [];
        $visa = Visa::find($id);
        if(!$visa){
            return 'Not Found';
        }
        $data['panel_name'] = "Add Visa Detail For #". $visa->basicinfo->full_name ;
              $url    = '';
        $data['link'] = $url;
        $data['row']  = $visa;
        return view('admin.basic_info.immigration.visa.edit',compact('data'));
    }

    public function storeVisa(Request $request){
        
        $validator = \Validator::make($request->all(), [
            "basic_info_id" => "required|exists:basic_infos,id",
            "visa_type"     => "required",
            "visa_number"   => "required",
            "issue_date"    => "required",
            "expiry_date"   => "required"
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            $visa                = new Visa();
            $visa->basic_info_id = $request->basic_info_id;
            $visa->visa_type     = $request->visa_type;
            $visa->visa_number   = $request->visa_number;
            $visa->issue_date    = ($request->issue_date)? $request->issue_date : '';
            $visa->expiry_date   = ($request->expiry_date)? $request->expiry_date : '';
            $visa->created_by    = Auth::user()->id;
            $visa->created       = now();
            $visa->modified      = now();
            $visa->modified_by   = Auth::user()->id;
            if($visa->save()){
                return redirect()->route('client.show',['id'=>$request->basic_info_id,'click'=>'immigration_info'])->with('success','Add success');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }   
    }

    public function updateVisa(Request $request, $id){

        $visa = Visa::find($id);
        
        if(!$visa){
            return 'Not Found';
        }

        $validator = \Validator::make($request->all(), [
            "basic_info_id" => "required|exists:basic_infos,id",
            "visa_type"     => "required",
            "visa_number"   => "required",
            "issue_date"    => "required",
            "expiry_date"   => "required"
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            $visa->basic_info_id = $request->basic_info_id;
            $visa->visa_type     = $request->visa_type;
            $visa->visa_number   = $request->visa_number;
            $visa->issue_date    = ($request->issue_date)? $request->issue_date : '';
            $visa->expiry_date   = ($request->expiry_date)? $request->expiry_date : '';
            $visa->created_by    = $visa->created_by;
            $visa->created       = now();
            $visa->modified      = now();
            $visa->modified_by   = Auth::user()->id;
            if($visa->save()){
                return redirect()->route('client.show',['id'=>$request->basic_info_id,'click'=>'immigration_info'])->with('success','updated successfully');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }   
    }

    public function addUkVisaDetail($id){
        $data = [];
        $basicInfo = BasicInfo::find($id);
        if(!$basicInfo){
            return 'Not Found';
        }
              $url            = '';
        $data['panel_name']   = "Add UK Visa Detail For #". $basicInfo->full_name ;
        $data['link']         = $url;
        $data['country_code'] = $this->country_code;
        $data['row']          = $basicInfo;
        return view('admin.basic_info.immigration.ukvisa.add',compact('data'));
    }

    public function editUkVisaDetail($id){
        $data = [];
        $visa = UkVisa::find($id);
        if(!$visa){
            return 'Not Found';
        }
        $data['panel_name'] = "Add UK Visa Detail For #". $visa->basicinfo->full_name ;
              $url    = '';
        $data['link'] = $url;
        $data['row']  = $visa;
        return view('admin.basic_info.immigration.ukvisa.edit',compact('data'));
    }

    public function storeUkVisa(Request $request){
        
        $validator = \Validator::make($request->all(), [
            "basic_info_id"     => "required|exists:basic_infos,id",
            "visa_type"         => "required",
            "visa_number"       => "required",
            "issue_date"        => "required",
            "course_start_date" => "required",
            "course_end_date"   => "required",
            "expiry_date"       => "required"
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            $ukVisa                    = new UkVisa();
            $ukVisa->basic_info_id     = $request->basic_info_id;
            $ukVisa->visa_type         = $request->visa_type;
            $ukVisa->visa_number       = $request->visa_number;
            $ukVisa->course_title      = $request->course_title;
            $ukVisa->level_of_study    = $request->level_of_study;
            $ukVisa->institution       = $request->institution;
            $ukVisa->Note              = $request->note;
            $ukVisa->issue_date        = ($request->issue_date)? $request->issue_date : date('Y-m-d');
            $ukVisa->expiry_date       = ($request->expiry_date)? $request->expiry_date : date('Y-m-d');
            $ukVisa->course_start_date = ($request->course_start_date)? $request->course_start_date : date('Y-m-d');
            $ukVisa->course_end_date   = ($request->course_end_date)? $request->course_end_date : date('Y-m-d');
            $ukVisa->created_by        = Auth::user()->id;
            $ukVisa->created           = now();
            $ukVisa->modified          = now();
            $ukVisa->modified_by       = Auth::user()->id;
            if($ukVisa->save()){
                return redirect()->route('client.show',['id'=>$request->basic_info_id,'click'=>'immigration_info'])->with('success','Add success');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }   
    }

    public function updateUkVisa(Request $request, $id){

        $ukVisa = UkVisa::find($id);
        
        if(!$ukVisa){
            return 'Not Found';
        }

        $validator = \Validator::make($request->all(), [
            "basic_info_id"     => "required|exists:basic_infos,id",
            "visa_type"         => "required",
            "visa_number"       => "required",
            "issue_date"        => "required",
            "course_start_date" => "required",
            "course_end_date"   => "required",
            "expiry_date"       => "required"
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            $ukVisa->basic_info_id     = $request->basic_info_id;
            $ukVisa->visa_type         = $request->visa_type;
            $ukVisa->visa_number       = $request->visa_number;
            $ukVisa->course_title      = $request->course_title;
            $ukVisa->level_of_study    = $request->level_of_study;
            $ukVisa->institution       = $request->institution;
            $ukVisa->Note              = $request->note;
            $ukVisa->issue_date        = ($request->issue_date)? $request->issue_date : date('Y-m-d');
            $ukVisa->expiry_date       = ($request->expiry_date)? $request->expiry_date : date('Y-m-d');
            $ukVisa->course_start_date = ($request->course_start_date)? $request->course_start_date : date('Y-m-d');
            $ukVisa->course_end_date   = ($request->course_end_date)? $request->course_end_date : date('Y-m-d');
            $ukVisa->created_by        = ($ukVisa->created_by) ?? Auth::user()->id;
            $ukVisa->created           = now();
            $ukVisa->modified          = now();
            $ukVisa->modified_by       = Auth::user()->id;            
            if($ukVisa->save()){
                return redirect()->route('client.show',['id'=>$request->basic_info_id,'click'=>'immigration_info'])->with('success','updated successfully');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }   
    }

    public function deleteCurrentContact(Request $request){
        $id = $request->contact_id;
        $data = StudentContactDetail::findOrFail($id);
        $data->delete();
        return back()->with('success','Successfully deleted current contact details');
    }

    public function deleteAddress(Request $request){
        $id = $request->address_id;
        $data = ClientAddressDetail::findOrFail($id);
        $data->delete();
        return back()->with('success','Successfully deleted current address details');
    }

    public function deleteEmergency(Request $request){
        $id = $request->emergency_id;
        $data = ClientEmergencyDetail::findOrFail($id);
        $data->delete();
        return back()->with('success','Successfully deleted current emergency details');
    }


    public function addEnquiry(Request $request,$id){
        $client = BasicInfo::findOrFail($id);
        $enquiry = Enquiry::where('client_id',null)->find($request->enquiry_id);
        if(!$enquiry) return back()->with('success',"Invalid enquiry selected");

       $enquiry->client_id = $client->id;
       $enquiry->save();
       return back()->with('success',"Successfully linked the enquiry");
    }
}