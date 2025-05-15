<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Session;
use App\Models\BasicInfo;
use App\Models\ImmigrationApplication;
use App\Models\ImmigrationApplicationProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use App\Mail\MassMail;
use App\Models\CompanyDocument;
use App\Models\EmailSender;
use App\Models\EnquiryFollowUp;
use App\Models\Template;
use App\Notifications\FollowUpAlert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class CompanyInfoController extends BaseController
{
    private $title;
    private $country_code;
    private $enquiry_type;
    private $users;
    private $destinationPath;

    
    public function __construct(){
        $this->middleware('auth');
        $this->title = $this->getTitle();
        $this->country_code = $this->getCounrtyCode();
        $this->destinationPath = 'uploads/images';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
   
    }

    public function create($basic_info_id)
    {
    
    }

    public function store(Request $request)
    {
        
    }

    public function edit()
    {
        $application = \App\Models\CompanyInfo::first();
        if ($application==null) {
          $application = \App\Models\CompanyInfo::create([]);
        }
        // dd($application);
        
        $data = [];
        $data['panel_name'] = 'Edit Company Info';
        $data['row'] = $application;
        $data['country_code'] = $this->country_code;
        return view('admin.company_info.edit',compact('data'));
    }

    public function update(Request $request, $id)
    {
    	$companyinfo=\App\Models\CompanyInfo::findOrFail($id);
    	$data = $this->validate($request,[
    		'name'=>'required|string',
    		'email'=>'required|string',
    		'address'=>'required|string',
    		'telephone'=>'required|string|max:20',
    		'registration_no'=>'required|string',
    		'logo'=>'image|nullable',
    		'stamp'=>'image|nullable',
    		'website'=>'required|string',
        	'registered_in'=>"required|string",
        	'regulated_by'=>'required',
        	'regulation_no'=>'required',
        	'vat'=>'required',
        	'regulator_logo'=>'image|nullable',
    		]);
    		
    	if($request->hasFile('stamp')){
    		//delete existing
    			$file=$request->file('stamp');
    		  $extra = $request->id;
            $path = $this->destinationPath . '/' . $extra;   

            $file_uploaded_path = $this->saveUpdateFile($file, $filename = null , $path, $extra);
            $data['stamp']=$file_uploaded_path;
    	}
    	
    	if($request->hasFile('regulator_logo')){
    		//delete existing
    			$file=$request->file('regulator_logo');
    		  $extra = $request->id;
            $path = $this->destinationPath . '/' . $extra;   

            $file_uploaded_path = $this->saveUpdateFile($file, $filename = null , $path, $extra);
            $data['regulator_logo']=$file_uploaded_path;
    	}
    	
    	
    	if($request->hasFile('logo')){
    		//delete existing
    		$file=$request->file('logo');
    		  $extra = $request->id;
            $path = $this->destinationPath . '/' . $extra;   

            $file_uploaded_path = $this->saveUpdateFile($file, $filename = null , $path, $extra);
            $data['logo']=$file_uploaded_path;
    	}
    	$companyinfo->update($data);
        Session::flash('success', 'Successfully updated company info.');
        return redirect()->back();
    }

    public function updateFootnote(Request $request, $id)
    {
    	$companyinfo=\App\Models\CompanyInfo::findOrFail($id);
    	$data = $this->validate($request,[
        'footnote'=>'required|string'
    		]);
    		
    
    	$companyinfo->update($data);
        Session::flash('success', 'Successfully updated email footnote.');
        return redirect()->back();
    }

    public function sendEmails(){
      $data = array();
      $data['templates'] = Template::all();
      $data['documents'] = CompanyDocument::all();
      $data['senders'] = EmailSender::all();
      return view('admin.sendemails',compact('data'));
    }


    public function postSendEmails(Request $request){
      $data = $this->validate($request,[
        'subject'=>'required',
        'content'=>'required',
        'sender_id'=>'required',
        'receiver'=>'required'
      ]);

      $data['documents'] = $request->documents ?? array();

      $all = $request->sendtoall;
      $receivers = collect(array());
      if($all != null ) $all = true;
      if($all){
        $receivers = BasicInfo::has('contact_details')->whereStatus("Active")->select('id')->get();
      }else{
        $query = BasicInfo::query();
        foreach(explode(",",$request->receivers) as $receiver){
          $query->orWhere("id",'=',$receiver);
        }
        $receivers = $query->select('id')->get();
      }
      $data['receivers'] = $receivers; 
      $data['attachment_paths'] = array();
      if($request->attachments){
        foreach($request->attachments as $attachment){
          $p  = Storage::disk("local")->putFileAs("attachments/".time(),$attachment,$attachment->getClientOriginalName());
          array_push($data['attachment_paths'],$p);
        }
      } 

   
        $mass = new MassMail($data);
        Mail::send($mass);
  
      return back()->withSuccess("Successfully sent email to selected client.");
    }
  
   
}
