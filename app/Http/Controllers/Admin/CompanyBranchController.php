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

class CompanyBranchController extends BaseController
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
    	
		$data = [];
        $data['panel_name'] = 'List of Branches';
        $data['branches'] = \App\Models\CompanyBranch::all();
        
        return view("admin.company_branch.index",compact('data'));
        
    }
    
     public function show($id)
    {
    	
		$data = [];
        $data['panel_name'] = 'List of Branches';
        $data['row'] = \App\Models\CompanyBranch::findOrFail($id);
        
        return view("admin.company_branch.show",compact('data'));
        
    }

    public function create()
    {
    	$data = [];
        $data['panel_name'] = 'Create Company Branch';
        return view('admin.company_branch.create',compact('data'));
    }

    public function store(Request $request)
    {
        	$data = $this->validate($request,[
    		'name'=>'required|string',
    		'email'=>'required|string',
    		'address'=>'required|string',
    		'telephone'=>'required|string',
    		'registration_no'=>'nullable|string',
    		'logo'=>'image|nullable',
    		'stamp'=>'image|nullable',
    		'website'=>'nullable|string',
    		]);
    		
    	if($request->hasFile('stamp')){
    		//delete existing
    			$file=$request->file('stamp');
    		  $extra = $request->id;
            $path = $this->destinationPath . '/' . $extra;   

            $file_uploaded_path = $this->saveUpdateFile($file, $filename = null , $path, $extra);
            $data['stamp']=$file_uploaded_path;
    	}
    	
    	
    	if($request->hasFile('logo')){
    		//delete existing
    		$file=$request->file('logo');
    		  $extra = $request->id;
            $path = $this->destinationPath . '/' . $extra;   

            $file_uploaded_path = $this->saveUpdateFile($file, $filename = null , $path, $extra);
            $data['logo']=$file_uploaded_path;
    	}
    	\App\Models\CompanyBranch::create($data);
        Session::flash('success', 'Successfully created new company branch.');
        return redirect()->route("companybranch.index");
    }

    public function edit($id)
    {
        $application = \App\Models\CompanyBranch::findOrFail($id);
      
        // dd($application);
        
        $data = [];
        $data['panel_name'] = 'Edit Branch Info';
        $data['row'] = $application;
        return view('admin.company_branch.edit',compact('data'));
    }

    public function update(Request $request, $id)
    {
    	$companyinfo=\App\Models\CompanyBranch::findOrFail($id);
    	$data = $this->validate($request,[
    		'name'=>'required|string',
    		'email'=>'required|string',
    		'address'=>'required|string',
    		'telephone'=>'required|string',
    		'registration_no'=>'nullable|string',
    		'logo'=>'image|nullable',
    		'stamp'=>'image|nullable',
    		'website'=>'nullable|string',
    		]);
    		
    	if($request->hasFile('stamp')){
    		//delete existing
    			$file=$request->file('stamp');
    		  $extra = $request->id;
            $path = $this->destinationPath . '/' . $extra;   

            $file_uploaded_path = $this->saveUpdateFile($file, $filename = null , $path, $extra);
            $data['stamp']=$file_uploaded_path;
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
        Session::flash('success', 'Successfully updated company branch info.');
        return redirect()->route('companybranch.index');
    }


	public function destroy(Request $request){
	
		$data  = $request->all();
		$id=$data['id'];
		$branch = \App\Models\CompanyBranch::findOrFail($id);
		
		$branch->delete();
		
		Session::flash('success', 'Successfully deleted company branch.');
        return redirect()->back();
	}
   
}
