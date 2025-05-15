<?php

namespace App\Http\Controllers\Admin;

use App\Mail\VisaExpiryMail;
use App\Models\Advisor;
use App\Models\CompanyInfo;
use App\Models\Employee;
use App\Models\EmployeeContactDetail;
use App\Models\EnquiryForm;
use App\Models\PassportDetail;
use App\Models\UkVisa;
use App\Models\Visa;
use App\Models\VisaExpiryEmail;
use Illuminate\Http\Request;
use Auth;
use Mail;

class VisaController extends BaseController
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
            'visa_type' => 'required', 'issue_date' => 'required', 'expiry_date' => 'required', 'visa_number' => 'required',
            'employee_id' => 'required'
        ]);
        $data['created_by'] = $data['modified_by'] = auth()->user()->id;
        $p = Visa::create($data);
        if ($p->type == "basicinfo") {
            return redirect()->route("client.show")->with('success', "Successfully stored passport details");
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
        $data['row'] = Visa::findOrFail($id);
        $data['country_code'] = $this->getCounrtyCode();
        return view('admin.visa.show', compact('data'));
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
    public function destroy(Request $request, $id)
    {
        //
        if ($id == "_")
            $id = $request->visa_id;
        $visa = Visa::withTrashed()->findOrFail($id);
        if (request()->action == 'delete-permanently') {
            $visa->forceDelete();
            return back()->with('success', "Successfully wiped the visa");
        }

        $visa->delete();
        return back()->with('success', "Successfully deleted the visa");
    }


    public function restore($id)
    {
        $visa = Visa::withTrashed()->findOrFail($id);
        $visa->restore();
        return back()->with('success', "Successfully restored the visa");
    }


    public function destroyUkvisa(Request $request)
    {
        //
        $id = $request->ukvisa_id;
        $visa = UkVisa::findOrFail($id);
        $visa->delete();
        return back()->with('success', "Successfully deleted the uk visa");
    }


    public function toggle($id)
    {
        //
        $v  = Visa::findOrFail($id);
        $v->status = $v->status == "Active" ? "Inactive" : "Active";
        $v->save();
        return back()->with('success', "Successfully toggled the status of the visa");
    }




    public function edit($id)
    {
        $data['row'] = Visa::findOrFail($id);
        $data['country_code'] = $this->getCounrtyCode();
        return view('admin.visa.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'visa_type' => 'required', 'issue_date' => 'required', 'expiry_date' => 'required', 'visa_number' => 'required',
            'employee_id' => 'required'
        ]);
        $data['created_by'] = $data['modified_by'] = auth()->user()->id;
        Visa::findOrFail($id)->update($data);
        return redirect()->route('employee.show', $data['employee_id'])->with("success", "Successfully update passport details");
    }



    public function sendEmail(Request $request)
    {
        $data = $this->validate($request, [
            'receivers' => 'required',
            'sender_id' => 'required',
            'email_content' => 'nullable',
            'form_id'=>'required'
        ]);

        if($request->ajax()){
            $data['visa'] = Visa::find($request->receivers);
            $data['client'] = $data['visa']->client;
            $data['sender'] = Advisor::find($data['sender_id']);
            $data['companyinfo'] = CompanyInfo::first();
            $data['form'] = EnquiryForm::find($data['form_id']);

            $email_content = view('admin.visa.partials.email_content',compact('data'))->render();
            $subject = "Attn: {$data['client']->full_name} upcoming visa expiry {$data['visa']->expiry_date_formatted} please contact us.";
            return response()->json(["content"=>$email_content,"subject"=>$subject]);
        }

        $this->validate($request,[
            'subject'=>'required',
            'attachments' => 'nullable',
            'attachments.*' => 'file|max:5034',
        ]);

        $receivers = explode(',', $data['receivers']);
        $data['client_email'] = $request->client_email;
        $data['kin_email']= $request->kin_email;
       if (count($receivers) > 0) {

            foreach ($receivers as $receiver) {
                $copy = $data;
                $copy['attachments'] = null;
                $copy['receiver_id'] = $receiver;
                $copy['attachment_paths'] = array();
                $copy['subject'] = $request->subject;
                $copy['documents'] = $request->documents;

                if ($request->hasFile('attachments')) {
                    foreach ($request->file('attachments')  as $attachment) {

                        $path = $attachment->storeAs('temp', $attachment->getClientOriginalName(), 'local');
                        // dd($path);
                        $copy['attachment_paths'][] = $path;
                    }
                }
                // $copy['attachments'] = null;
                $mailable = new VisaExpiryMail($copy);

                Mail::send($mailable);
            }
        } else {
            return back()->withSuccess("Some error occurred");
        }

        return back()->withSuccess("Successfully queued email for " . count($receivers) . " clients");
    }


    public function ajaxShow($id){
        $v = Visa::with('client.contact_details')->with('client.kins')->find($id);
        return response()->json($v);
    }
}
