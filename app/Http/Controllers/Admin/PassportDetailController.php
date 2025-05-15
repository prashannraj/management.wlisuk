<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employee;
use App\Models\EmployeeContactDetail;
use App\Models\PassportDetail;
use Illuminate\Http\Request;
use Auth;

class PassportDetailController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $this->validate($request, [
            'issue_date' => 'required', 'expiry_date' => 'required',
            'employee_id' => 'required', 'passport_number' => 'required', 'iso_countrylist_id' => 'required',
            'birth_place' => 'required', 'issuing_authority' => 'required', 'citizenship_number' => 'nullable'
        ]);
        $data['created_by'] = $data['modified_by'] = auth()->user()->id;
        $p = PassportDetail::create($data);
        if($p->type == "basicinfo"){
            return redirect()->route("client.show")->with('success',"Successfully stored passport details");
        }
        return redirect()->route('employee.show', $data['employee_id'])->with("success", "Successfully stored passport details");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data['row'] = PassportDetail::findOrFail($id);
        $data['country_code'] = $this->getCounrtyCode();
        return view('admin.passport_detail.show', compact('data'));
       
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        //
        if($id == "_")
            $id = $request->passport_id;
        // dd($id);
        $visa = PassportDetail::withTrashed()->findOrFail($id);
        // dd($visa);
        if(request()->action == 'delete-permanently'){
            $visa->forceDelete();
            return back()->with('success',"Successfully wiped the passport");
        }
        $visa->delete();
        return back()->with('success',"Successfully deleted the passport");
    }




    public function edit($id)
    {
        $data['row'] = PassportDetail::findOrFail($id);
        $data['country_code'] = $this->getCounrtyCode();
        return view('admin.passport_detail.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'issue_date' => 'required', 'expiry_date' => 'required',
            'employee_id' => 'required', 'passport_number' => 'required', 'iso_countrylist_id' => 'required',
            'birth_place' => 'required', 'issuing_authority' => 'required', 'citizenship_number' => 'nullable'
        ]);
        $data['created_by'] = $data['modified_by'] = auth()->user()->id;
        PassportDetail::findOrFail($id)->update($data);
        return redirect()->route('employee.show', $data['employee_id'])->with("success", "Successfully update passport details");
    }


    public function restore($id){
        // dd($id);
        $visa = PassportDetail::onlyTrashed()->findOrFail($id);
        $visa->restore();
        return back()->with('success',"Successfully restored the passport");
    }
}
