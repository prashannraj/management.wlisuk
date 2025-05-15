<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advisor;
use App\Models\AttendanceNote as AttendanceNote;
use App\Models\BasicInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttendanceNoteController extends BaseController
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
    public function create($id)
    {
        //
        $data['advisors'] = Advisor::whereStatus("active")->get();
        $data['basic_info'] = BasicInfo::findOrFail($id);
        $data['row'] = new AttendanceNote;
        return view('admin.attendancenotes.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        //
        $client =  BasicInfo::findOrFail($id);
        $rules = [
            'date' => 'required',
            'details' => 'required',
            'mode' => 'nullable',
            'advisor_id' => 'required',
            'hours' => 'nullable|integer',
            'minutes' => 'nullable|integer',
            'file'=>'nullable|file|mimes:pdf,doc,jpg,jpeg,png,docx,bmp',
            'type' => 'required'
        ];
        if($request->type=="attendance"){
            $rules['mode']="required";
            $rules['hours']="nullable|integer";
            $rules['minutes']="nullable|integer";
        }

        
        $data = $this->validate($request, $rules);

        if($request->hasFile('file')){
           
            $f = $request->file('file');
            $filename = "attendance_note_".$id.time().".".$f->getClientOriginalExtension();
            $loc =$f->storeAs("attendance_notes",$filename,'uploads');
            $data['file']= $loc;
        }else{
            $data['file'] = null;
        }
        
        $data['basic_info_id'] = $client->id;
        AttendanceNote::create($data);
        return redirect()->route('client.show', ['id'=>$client->id,'click'=>'communication'])->with("success", "Successfully saved new attendance note");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AttendanceNote  $attendanceNote
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        
        $data['row']=AttendanceNote::findOrFail($id);
        return view('admin.attendancenotes.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AttendanceNote  $attendanceNote
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        //
        $data['advisors'] = Advisor::whereStatus("active")->get();
        $data['row'] = AttendanceNote::findOrFail($id);
        return view('admin.attendancenotes.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AttendanceNote  $attendanceNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $rules = [
            'date' => 'required',
            'details' => 'required',
            'mode' => 'nullable',
            'advisor_id' => 'required',
            'hours' => 'nullable|integer',
            'minutes' => 'nullable|integer',

            'file'=>'nullable|file|mimes:pdf,doc,jpg,jpeg,png,docx,bmp',
            'type' => 'required'
        ];
        if($request->type=="attendance"){
            $rules['mode']="required";
            $rules['hours']="nullable|integer";
            $rules['minutes']="nullable|integer";

        }
        $attendance = AttendanceNote::findOrFail($id);

       
        $data = $this->validate($request, $rules);
        if($request->hasFile('file')){
            if($attendance->file){
                Storage::disk('uploads')->delete($attendance->file);
            }
            $f = $request->file('file');
            $filename = "attendance_note_".$id.time().".".$f->getClientOriginalExtension();
            $loc =$f->storeAs("attendance_notes",$filename,'uploads');
            $data['file']= $loc;
        }
        $attendance->update($data);
        return redirect()->route('client.show',['id'=> $attendance->basic_info_id,'click'=>'communication'])->with("success", "Successfully saved new attendance note");
  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AttendanceNote  $attendanceNote
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $attendance=AttendanceNote::findOrFail($id);
        $attendance->delete();
        return redirect()->route('client.show', $attendance->basic_info_id)->with("success", "Successfully deleted attendance note");

    }
}
