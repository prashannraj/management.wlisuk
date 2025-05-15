<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employee;
use App\Models\EmployeeContactDetail;
use App\Models\PassportDetail;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $query = Employee::query();
        if ($request->show == 'Active' || $request->show == null)
            $query = $query->where('status', "Active");

        if ($request->show == 'Inactive')
            $query = $query->where('status', "Inactive");

 
        $data['employees'] = $query->paginate(10);

        return view('admin.employee.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['row'] = new Employee;
        $data['title'] = $this->getTitle();
        $data['country_code'] = $this->getCounrtyCode();
        return view('admin.employee.create', compact('data'));
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
        $rules = [
            'm_name' => 'nullable',
            'f_name' => 'required',
            'l_name' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'status' => 'required',
            'title' => 'required',
            'signature' => 'nullable|image|max:1024'
        ];



        $data = $this->validate($request, $rules);
        if ($request->hasFile('signature')) {
            $file = $request->file("signature");
            $file_name = "signature_" . time() . "." . $file->getClientOriginalExtension();

            $data['signature'] = $file->storeAs('employee_signatures', $file_name, "uploads");
        }
        $data['created_by'] = Auth::user()->id;
        $data['modified_by'] = Auth::user()->id;
        $d = Employee::create($data);

        return redirect()->route('employee.index')->with('success', "Successfully created an employee");
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
        $data['country_code'] = $this->getCounrtyCode();
        $data['employee'] = $employee;
        $data['active_visas'] = $employee->currentvisas()->whereStatus('active')->get();
        return view('admin.employee.show', compact('data'));
    }


    public function restore($id)
    {
        //
        $basicinfo = Employee::withTrashed()->find($id);
        if($basicinfo){
            $basicinfo->restore();
        }

        return back()->with("success","Restored employee");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
        $data['row'] = $employee;
        $data['title'] = $this->getTitle();
        return view('admin.employee.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $employee)
    {
        //
        //
        $employee = Employee::findOrFail($employee);
        $rules = [
            'm_name' => 'nullable',
            'f_name' => 'required',
            'l_name' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'status' => 'required',
            'title' => 'required',
            'signature' => 'nullable|image|max:1024'

        ];

        $data = $this->validate($request, $rules);
        if ($request->hasFile('signature')) {
            $file = $request->file("signature");
            $file_name = "signature_" . time() . "." . $file->getClientOriginalExtension();
            Storage::disk('uploads')->delete($employee->signature);
            $data['signature'] = $file->storeAs('employee_signatures', $file_name, "uploads");
        }
        $data['modified_by'] = Auth::user()->id;
        $d = $employee->update($data);
        if($employee->status == "Inactive"){
            $employee->delete_at = now()->addDays(config('cms.delete_after'));
            $employee->save();
        }

        return back()->with('success', "Successfully updated the employee");
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
        // dd(request()->all());
        if(request()->action == "delete-permanently"){
            $employee->forceDelete();
            return back()->with('success',"Successfully wiped out employee");
        }
    }


    public function storePassport(Request $request)
    {
        $data = $this->validate($request, [
            'issue_date' => 'required', 'expiry_date' => 'required',
            'employee_id' => 'required', 'passport_number' => 'required', 'iso_countrylist_id' => 'required',
            'birth_place' => 'required', 'issuing_authority' => 'required', 'citizenship_number' => 'required'
        ]);
        $data['created_by'] = $data['modified_by'] = auth()->user()->id;
        PassportDetail::create($data);
        return redirect()->route('employee.show', $data['employee_id'])->with("success", "Successfully stored passport details");
    }

    public function editPassport($id)
    {
        $data['row'] = PassportDetail::findOrFail($id);
        $data['country_code'] = $this->getCounrtyCode();
        return view('admin.employee.passport.edit', compact('data'));
    }

    public function updatePassport(Request $request, $id)
    {
        $data = $this->validate($request, [
            'issue_date' => 'required', 'expiry_date' => 'required',
            'employee_id' => 'required', 'passport_number' => 'required', 'iso_countrylist_id' => 'required',
            'birth_place' => 'required', 'issuing_authority' => 'required', 'citizenship_number' => 'required'
        ]);
        $data['created_by'] = $data['modified_by'] = auth()->user()->id;
        PassportDetail::findOrFail($id)->update($data);
        return redirect()->route('employee.show', $data['employee_id'])->with("success", "Successfully update passport details");
    }
}
