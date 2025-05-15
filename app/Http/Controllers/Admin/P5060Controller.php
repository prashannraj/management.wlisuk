<?php

namespace App\Http\Controllers\Admin;

use App\Mail\P5060Mail;
use App\Models\CompanyInfo;
use App\Models\Employee;
use App\Models\P5060;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Arr;
use Illuminate\Support\Facades\Storage;

class P5060Controller extends BaseController
{
    //
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
    public function create($id)
    {
        
        //
        $data['row']= new P5060;
        $data['row']->employee_id = $id;
        return view('admin.p4560.create',compact('data'));
    }

    public function email($id){
        $data['row']= P5060::findOrFail($id);
        $data['attachments']= [];
        $data['company_info']  = CompanyInfo::first();

        Mail::to('admin@wlisuk.com')->send(new P5060Mail($data));
        return redirect()->route('employee.show',['employee'=>$data['row']->employee_id,'click'=>'payroll'])->with("success","Successfully emailed P45/P60");
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
        $data = $this->validate($request,['year'=>'required','type'=>'required','document'=>'required|file|mimes:jpeg,bmp,png,pdf','note'=>'nullable','employee_id'=>'required']);
        $file = $request->file('document');
        $fileType = '';
        $employee = Employee::findOrFail($request->employee_id);

        $filename = $employee->full_name."(".$employee->id.")"." ".$request->type." ".$request->year."_".time().".".$file->extension();
        

        $data['document'] = $file->storeAs("employee_p4560s",$filename,'uploads');
        P5060::create($data);
        return redirect()->route('employee.show',['employee'=>$employee->id,'click'=>'payroll']);

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaySlip  $paySlip
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data['row']= P5060::findOrFail($id);
        return view('admin.p4560.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaySlip  $paySlip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $paySlip)
    {
        //
        $data = $this->validate($request,['year'=>'required','type'=>'required','document'=>'nullable|file|mimes:jpeg,bmp,png,pdf','note'=>'nullable','employee_id'=>'required']);

        $empl = P5060::findOrFail($paySlip);
        $employee = Employee::findOrFail($request->employee_id);


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
            $filename = $employee->full_name."(".$employee->id.")"." ".$request->type." ".$request->year."_".time().".".$file->extension();

            Storage::disk('uploads')->delete($empl->document);

            $data['document'] = $file->storeAs("employee_p4560s",$filename,'uploads');

        }else{
            $data = Arr::except($data,['document']);
        }


        $empl->update($data);

        return redirect()->route('employee.show',['employee'=>$employee->id,'click'=>'payroll'])->with("success","Successfully updated the payslip");
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaySlip  $paySlip
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
