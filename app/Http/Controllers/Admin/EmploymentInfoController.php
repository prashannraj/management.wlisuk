<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employee;
use App\Models\EmploymentInfo;
use Illuminate\Http\Request;

class EmploymentInfoController extends BaseController
{
    //
    public function create($employee_id)
    {
        $data['employee'] = Employee::findOrFail($employee_id);
        $data['row'] = new EmploymentInfo;
        $data['row']->employee_id = $employee_id;

        return view('admin.employee.employmentinfo.create', compact('data'));
    }




    public function edit($id)
    {
        $data['row'] = EmploymentInfo::findOrFail($id);
        return view('admin.employee.employmentinfo.edit', compact('data'));
    }

    public function show($id)
    {
        $data['row'] = EmploymentInfo::findOrFail($id);
        $disabled = "disabled";
        return view('admin.employee.employmentinfo.show', compact('data','disabled'));
    }


    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'employee_id' => 'required', 'job_title' => 'required', 'start_date' => 'required', 'type' => 'required',
            'working_hours' => 'required', 'working_days' => 'required', 'working_time' => 'required', 'salary' => 'required',
            "salary_arrangement" => 'required', 'ni_number' => 'required', 'end_date' => 'nullable', 'place_of_work' => 'required',
            'region' => 'required', 'supervisor' => 'required', 'supervisor_email' => 'required', 'supervisor_tel' => 'required',
            'probation_period' => 'required',
            'probation_end_date' => 'required'
        ]);
        $data['created_by'] = $data['updated_by'] = auth()->user()->id;

        EmploymentInfo::create($data);

        return redirect()->route('employee.show', ['employee'=>$data['employee_id'],'click'=>'employment_info'])->with('success', 'Successfully created new employment info');
    }



    public function update(Request $request,$id)
    {
        $em = EmploymentInfo::findOrFail($id);
        $data = $this->validate($request, [
            'employee_id' => 'required', 'job_title' => 'required', 'start_date' => 'required', 'type' => 'required',
            'working_hours' => 'required', 'working_days' => 'required', 'working_time' => 'required', 'salary' => 'required',
            "salary_arrangement" => 'required', 'ni_number' => 'required', 'end_date' => 'nullable', 'place_of_work' => 'required',
            'region' => 'required', 'supervisor' => 'required', 'supervisor_email' => 'required', 'supervisor_tel' => 'required',
            'probation_period' => 'required',
            'probation_end_date' => 'required'
        ]);        
        $data['created_by'] = $data['updated_by'] = auth()->user()->id;

        $em->update($data);

        return redirect()->route('employee.show', ['employee'=>$data['employee_id'],'click'=>'employment_info'])->with('success', 'Successfully updated employment info');
    }
}
