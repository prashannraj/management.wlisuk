<?php

namespace App\Http\Controllers\Admin;

use App\Models\EmployeeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Arr;
class EmployeeDocumentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $data = $this->validate($request,
        ['employee_id'=>"required",
        'name'=>"required",
        'note'=>"nullable",
        'document'=>"required|file|mimes:jpeg,bmp,png,pdf",
        ]);

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
                break;
                default:
                    $fileType = '';
            }
        }

        $data['created_by']=$data['modified_by'] = auth()->user()->id;
        $data['document'] = $file->store("employee_documents",'uploads');

        EmployeeDocument::create($data);

        return redirect()->route('employee.show',$data['employee_id'])->with("success","Successfully uploaded the document");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EmployeeDocument  $EmployeeDocument
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeDocument $EmployeeDocument)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmployeeDocument  $EmployeeDocument
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data['row'] = EmployeeDocument::findOrFail($id);
        return view('admin.employee.document.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EmployeeDocument  $EmployeeDocument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $this->validate($request,
        ['employee_id'=>"required",
        'name'=>"required",
        'note'=>"nullable",
        'document'=>"nullable|file|mimes:jpeg,bmp,png,pdf",
        ]);

        $empl = EmployeeDocument::findOrFail($id);

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
                break;
                default:
                    $fileType = '';
            }
            Storage::disk('uploads')->delete($empl->document);

            $data['document'] = $file->store("employee_documents",'uploads');

        }else{
            $data = Arr::except($data,['document']);
        }

        $data['modified_by'] = auth()->user()->id;

        $empl->update($data);

        return redirect()->route('employee.show',$data['employee_id'])->with("success","Successfully updated the document");
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmployeeDocument  $EmployeeDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $file = EmployeeDocument::findOrFail($id);

        $file->delete();
        return back()->with("success","Successfully deleted document");
    }
}
