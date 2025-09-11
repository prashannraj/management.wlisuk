<?php

namespace App\Http\Controllers\Admin;

use App\Mail\EnquiryAlertMail;
use App\Mail\EnquiryVerifyMail;
use App\Models\ClientAddressDetail;
use App\Models\EmailSender;
use App\Models\CompanyInfo;
use App\Models\EnquiryForm;
use App\Models\IsoCountry;
use App\Models\RawInquiry;
use App\Notifications\NewEnquiryAlert;
use App\Rules\GoogleRecaptcha;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;

class EnquiryFormController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['forms'] = EnquiryForm::paginate(20);
        return view('enquiryform.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['form'] = new EnquiryForm;
        return view('enquiryform.create', compact('data'));
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
            'title' => 'required',
            'name' => 'required',
            'description' => 'nullable',
            'status' => 'required',
            'type' => 'required'
        ]);
        $uuid = "";
        do {
            $uuid = Str::random(5);
        } while (EnquiryForm::whereUuid($uuid)->count() != 0);

        $data['uuid'] = $uuid;

        $enq = EnquiryForm::create($data);

        return redirect()->route('enquiryform.index')->with('success', "Successfully created the enquiry forms");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EnquiryForm  $enquiryForm
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data['form'] = EnquiryForm::findOrFail($id);
        $data['countries'] = IsoCountry::orderBy("order", "desc")->get();
        $data['companyinfo'] = CompanyInfo::first();
        return view('enquiryform.show', compact('data'));
    }

    public function display($id)
    {
        //
        $data['form'] = EnquiryForm::whereUuid($id)->firstOrFail();
        $data['companyinfo'] = CompanyInfo::first();
        $data['form']->hits = $data['form']->hits + 1;
        $data['form']->save();
        $data['countries'] = IsoCountry::orderBy("order", "desc")->get();
        return view('enquiryform.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EnquiryForm  $enquiryForm
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data['form'] = EnquiryForm::findOrFail($id);
        return view('enquiryform.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EnquiryForm  $enquiryForm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        //
        $enq = EnquiryForm::findOrFail($id);

        //
        $data = $this->validate($request, [
            'title' => 'required',
            'name' => 'required',
            'description' => 'nullable',
            'status' => 'required',
            'type' => 'required'
        ]);

        $data['uuid'] = $enq->uuid;
        $enq->update($data);

        return redirect()->route('enquiryform.index')->with('success', "Successfully updated the enquiry forms");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EnquiryForm  $enquiryForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(EnquiryForm $enquiryForm)
    {
        //
    }

    public function fillup(Request $request, $uuid)
    {

        $form = EnquiryForm::whereUuid($uuid)->firstOrFail();
        $data = $this->validate($request, [
            // 'g-recaptcha-response' => ['required', new GoogleRecaptcha],
            'allow' => 'required',
            'email' => 'required|email'
        ]);
        $data['form'] = $form;
        $data['company_info'] = CompanyInfo::first();
        if (method_exists($this, $form->type)) {
            return $this->{$form->type}($request);
        }

        abort(404);
    }

    public function general(Request $request)
    {
        $data = $request->all();

        // Always set has_uk_sponsor (fallback to "No")
        $data['has_uk_sponsor'] = $request->input('has_uk_sponsor', 'No');

        // Generate unique code if not already set
        if (empty($data['unique_code'])) {
            $data['unique_code'] = strtoupper(uniqid("RQ"));
        }

        RawInquiry::create($data);

        return view("enquiryform.success", compact('data'));
    }


   public function immigration(Request $request)
    {
        $data = $request->all();

        // Always set has_uk_sponsor (fallback to "No")
        $data['has_uk_sponsor'] = $request->input('has_uk_sponsor', 'No');

        // Generate unique code if not already set
        if (empty($data['unique_code'])) {
            $data['unique_code'] = strtoupper(uniqid("RQ"));
        }

        RawInquiry::create($data);

        return view("enquiryform.success", compact('data'));
    }


    public function reformatDate($date, $from_format = 'd/m/Y', $to_format = 'Y-m-d') {
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux,$to_format);
    }

}
