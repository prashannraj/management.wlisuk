<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employee;
use App\Models\EmployeeAddress;
use Illuminate\Http\Request;
use Auth;

class EmployeeAddressController extends BaseController
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
            'employee_id' => 'required', 'postal_code' => 'required', 'address' => 'required', 'iso_countrylist_id'=>'required',
        ]);
        $data['created_by'] =$data['modified_by'] = auth()->user()->id;
        

        EmployeeAddress::create($data);

        return back()->with("success","Successfully added address details");
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
       $data['row'] = EmployeeAddress::findOrFail($id);
       $data['country_code'] = $this->getCounrtyCode();
       return view('admin.employee.edit_address',compact('data'));
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
            'employee_id' => 'required', 'postal_code' => 'required', 'address' => 'required', 'iso_countrylist_id'=>'required',

        ]);
        $data['modified_by'] = auth()->user()->id;
        

        $emp = EmployeeAddress::findOrFail($id);
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
