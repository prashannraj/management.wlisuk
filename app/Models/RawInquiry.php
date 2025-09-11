<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class RawInquiry extends Model
{
    //
    protected $fillable = [
        'refusalLetterDate', 'refusalreceivedDate', 'applicationLocation', 'uan', 'ho_ref', 'title', 'other_text', 'f_name', 'm_name', 'l_name', 'birthDate',
         'country_iso_mobile','mobile', 'country_code', 'email', 'contact_email', 'appellant_nation', 'appellant_address', 'has_uk_sponsor', 'sponsor_name', 'sponsor_relationship',
        'sponsor_email', 'sponsor_phone', 'sponsor_address', 'sponsor_city', 'sponsor_preferred', 'sponsor_preEmail', 'preparedby', 'visa', 'prepared_email', 'appellant_email', 'authorise','authorise_name', 'form_id',
        'extra_details', 'unique_code','iso_country_id','country_id','address', 'postal_code', 'method_decision_received', 'refusal_document','additional_details', 'extra_details', 'appellant_passport', 'proff_address', 'enquiry', 'notes', 'status', 'form_type'
    ];

    //public $incrementing = ['enq_number'];
    protected $casts = ['extra_details'=>'json'];


    protected $dates=['validated_at'];

    protected $appends = ['full_name','validated_status','created_at_formatted','is_validated','form_name', 'refusal_document_url', 'appellant_passport_url', 'proff_address_url', 'refusal_email_url', 'additional_document_url'];

    public function getVerifyUrlAttribute()
    {
        return route('rawenquiry.verify',$this->unique_code);
    }


    public function getRefusalDocumentUrlAttribute()
    {
        if ($this->refusal_document && Storage::disk('uploads')->exists($this->refusal_document)) {
            return route('fileurl', base64_encode($this->refusal_document));
        }
        return null; // or '' if you prefer
    }


    public function getAppellantPassportUrlAttribute()
    {
        if ($this->appellant_passport && Storage::disk('uploads')->exists($this->appellant_passport)) {
            return route('fileurl', base64_encode($this->appellant_passport));
        }
        return null;
    }

    public function getProffAddressUrlAttribute()
    {
        if ($this->proff_address && Storage::disk('uploads')->exists($this->proff_address)) {
            return route('fileurl', base64_encode($this->proff_address));
        }
        return null;
    }

    public function getRefusalEmailUrlAttribute()
    {
        if ($this->refusal_email && Storage::disk('uploads')->exists($this->refusal_email)) {
            return route('fileurl', base64_encode($this->refusal_email));
        }
        return null;
    }

    public function getAdditionalDocumentUrlAttribute()
    {
        $filePaths = [];
        if(isset($this->additional_document)){
            $data = json_decode($this->additional_document);
            if(count($data) > 0){
                foreach($data as $eachFile){
                    if($eachFile && Storage::disk('uploads')->exists($eachFile)) {
                        $filePaths[] = route('fileurl', base64_encode($eachFile));
                    }
                }
            }
        }
        return $filePaths;
    }


    public function getFullNameAttribute(){
        $str = "";
        if($this->f_name!=null) $str.=$this->f_name." ";
        if($this->m_name!=null) $str.=$this->m_name." ";
        if($this->l_name!=null) $str.=$this->l_name;

        return $str;


    }

    public function getValidatedStatusAttribute()
    {
        return $this->validated_at
            ? "Email verified on " . $this->validated_at->format("d M Y h:i:s")
            : "Email not verified";
    }


    public function form(){
        return $this->belongsTo(EnquiryForm::class,'form_id','id');
    }

    public function getCreatedAtFormattedAttribute(){
        return $this->created_at->format("d M Y h:i:s");
    }

    public function getStatusTextAttribute(){
        if($this->active) return "Active";
        else return "Inactive";
    }

    public function mobilecode(){
        return $this->belongsTo(IsoCountry::class,'country_iso_mobile');
    }

    public function getContactNumberAttribute(){
        $str = "";
        if($this->mobilecode) $str.= "+".$this->mobilecode->calling_code." ";
        if($this->mobile) $str.= $this->mobile;

        return $str;
    }

    public function nationality(){
        return $this->belongsTo(IsoCountry::class,'iso_country_id');
    }

    public function country(){
        return $this->belongsTo(IsoCountry::class,'country_id');
    }

    public function getNationalityCountryAttribute(){
        $str = "";
        if($this->nationality) return $this->nationality->title;

        return "";
    }

    public function getIpAddressAttribute(){
        return optional($this->extra_details)['ip'] ;
    }

    public function getIsValidatedAttribute(){
    	if($this->validated_at == null) return "No";
    	return "Yes";
    }

    public function getFormNameAttribute(){
         //todo
         if($this->form) return $this->form->name;
         return "";
    }

    public function enquiry()
    {
        return $this->hasOne(Enquiry::class, 'raw_enquiry_id');
    }

    public function getFullAddressAttribute(){
        return $this->address . ", " . $this->postal_code . ", " . $this->country_name;
    }


    public function getCountryNameAttribute(){
    	if($this->country){
    		return ucwords(strtolower($this->country->title));
    	}
    	return "";
    }

}
