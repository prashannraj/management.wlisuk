<?php

namespace App\Http\Controllers\Admin;


use DB;
use Auth;
use App\Models\Enquiry;
use Session;
use App\Models\BasicInfo;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;

class CompanyDocumentController extends BaseController
{
    private $title;
    private $enquiry;
    private $country_code;
    private $destinationPath;
    // private $users;

    public function __construct(){
        $this->middleware('auth');
        $this->title = $this->getTitle();
        $this->destinationPath = 'uploads/company_documents/';
    }


	public function index(){
		$data = [];
		$data['panel_name']="List of company documents";
		$data['documents']=\App\Models\CompanyDocument::paginate(10);
		
		return view('admin.company_document.index',compact('data'));
	}
	
	
	public function show($id)
    {
    	
		$data = [];
        $data['panel_name'] = 'Document Details';
        $data['row'] = \App\Models\CompanyDocument::findOrFail($id);
        
        return view("admin.company_document.show",compact('data'));
        
    }	
	
    public function create(){
        $data = [];
        $url            = '';
        $data['panel_name']   = "Add Company Document" ;
        return view('admin.company_document.create',compact('data'));
    }

    public function edit($id){
        $data = [];
        $document = \App\Models\CompanyDocument::find($id);
        if(!$document){
            return 'Not Found';
        }
        $data['panel_name'] = "Edit Document";
              $url    = '';
        $data['link'] = $url;
        $data['row']  = $document;
        return view('admin.company_document.edit',compact('data'));
    }

    public function store(Request $request){

        // dd($request->all());        
        
        $data = $this->validate($request, [
            "name"         => "required",
            "note"       => "max:300",
            "document"        => "required|file|mimes:jpeg,bmp,png,pdf",
        ]);



        try{
            
            $file = $request->file('document');
            $fileType = '';
            if($file){
                switch($file->getClientOriginalExtension()){
                    case 'jpeg':
                        $fileType = 'image';
                        break;
                    case 'bmp':
                        $fileType = 'image';
                        break;
                    case 'jpg':
                        $fileType = 'image';
                        break;
                    case 'pdf':
                        $fileType = 'pdf';
                        break;
                    case 'png':
                        $fileType = 'image';
                        break;
                    case 'doc':
                        $fileType = 'document';
                    default:
                        $fileType = '';
                }
            }

            $extra = auth()->user()->id;;
            $path = $this->destinationPath . '/' . $extra;   

            $file_uploaded_path = $this->saveUpdateImage($file, $filename = null , $path, $extra);
            
            $document                    = new \App\Models\CompanyDocument();
            $document->name         = $request->name;
            $document->note       = $request->note;
            $document->document      = $file_uploaded_path;
            $document->ftype      = $fileType;
            $document->created_by        = Auth::user()->id;
            $document->created_at           = now();
            $document->updated_at         = now();
            $document->modified_by       = Auth::user()->id;
            if($document->save()){
                return redirect()->route("companydocument.index")->with('success','Added document successfully');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }   
    }

    public function update(Request $request, $id){

        $document = \App\Models\CompanyDocument::findOrFail($id);
   

        $data = $this->validate($request, [
            "name"         => "required",
            "note"       => "max:300",
            "document"        => "file|mimes:jpeg,bmp,png,pdf|nullable",
        ]);


        try{
         
            if ($request->hasFile('document')) {
        	$fileType = '';
            $file = $request->file('document');
            
            $extra = auth()->user()->id;
            $path = $this->destinationPath . '/' . $extra;   

            $file_uploaded_path = $this->saveUpdateImage($file, $filename = null , $path, $extra);

            	
                
                    switch($file->getClientOriginalExtension()){
                        case 'jpeg':
                            $fileType = 'image';
                            break;
                        case 'bmp':
                            $fileType = 'image';
                            break;
                        case 'jpg':
                            $fileType = 'image';
                            break;
                        case 'pdf':
                            $fileType = 'pdf';
                            break;
                        case 'png':
                            $fileType = 'image';
                            break;
                        case 'doc':
                            $fileType = 'document';
                        default:
                            $fileType = '';
                    }
                    if ($document->document) {
                        $old_img = $document->document;
                        if (file_exists($old_img)) {
                            unlink($old_img);
                        }
                    }
               
            }else {
                    $file_uploaded_path = $document->document;
                    $fileType=$document->ftype;
            }

            $document->name         = $request->name;
            $document->note       = $request->note;
            $document->document      = $file_uploaded_path;
            $document->ftype      = $fileType;
            $document->created_by        = ($document->created_by) ?? Auth::user()->id;
            $document->updated_at          = now();
            $document->modified_by       = Auth::user()->id;
            if($document->save()){
                return redirect()->route('companydocument.index')->with('success','updated successfully');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }  
    }
    
    
    public function destroy(Request $request){
    	$data  = $request->all();
		$id=$data['id'];
		$branch = \App\Models\CompanyDocument::findOrFail($id);
		
		$branch->delete();
		
		Session::flash('success', 'Successfully deleted the document.');
        return redirect()->back();
    }
    
    
    
    public function getDownload($file){
    	$file_location = public_path("/uploads/company_documents/".base64_decode($file));
    	// dd($file_location);
    	return response()->file($file_location);
    }
}
