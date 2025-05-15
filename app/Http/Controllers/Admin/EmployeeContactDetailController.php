<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employee;
use App\Models\EmployeeContactDetail;
use Illuminate\Http\Request;
use Auth;

class EmployeeContactDetailController extends BaseController
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
        $data = $this->validate($request, [
            'employee_id' => 'required', 'mobile_number' => 'required', 'contact_number' => 'nullable', 'country_contact'=>'nullable',
            'country_mobile' => 'required', 'primary_email'=>'required'
        ]);
        $data['created_by'] =$data['modified_by'] = auth()->user()->id;
        

        EmployeeContactDetail::create($data);

        return back()->with("success","Successfully added contact details");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $data['row'] = EmployeeContactDetail::findOrFail($id);
       $data['country_code'] = $this->getCounrtyCode();
       return view('admin.employee.edit_contact',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $data = $this->validate($request, [
            'employee_id' => 'required', 'mobile_number' => 'required', 'contact_number' => 'nullable', 'country_contact'=>'nullable',
            'country_mobile' => 'nullable', 'primary_email'=>'required'
        ]);
        $data['modified_by'] = auth()->user()->id;
        

        $emp = EmployeeContactDetail::findOrFail($id);
        $emp->update($data);

        return redirect()->route('employee.show',$emp->employee_id)->with("success","Successfully updated contact details");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }


 
}
