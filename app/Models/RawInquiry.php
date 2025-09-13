<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class RawInquiry extends Model
{
    protected $fillable = [
        'refusalLetterDate', 'refusalreceivedDate', 'applicationLocation', 'uan', 'ho_ref', 'title', 'other_text',
        'f_name', 'm_name', 'l_name', 'birthDate', 'country_iso_mobile','mobile', 'country_code', 'email',
        'contact_email', 'appellant_nation', 'appellant_address', 'has_uk_sponsor', 'sponsor_name',
        'sponsor_relationship','sponsor_email', 'sponsor_phone', 'sponsor_address', 'sponsor_city',
        'sponsor_preferred', 'sponsor_preEmail', 'preparedby', 'visa', 'prepared_email', 'appellant_email',
        'authorise','authorise_name', 'form_id','extra_details', 'unique_code','iso_country_id','country_id',
        'address', 'postal_code', 'method_decision_received', 'refusal_document','additional_details',
        'extra_details', 'appellant_passport', 'proff_address', 'enquiry', 'notes', 'status', 'form_type', 'refusal_email', 'additional_document'
    ];

    protected $casts = [
        'extra_details' => 'json',
        'validated_at' => 'datetime',   // Fix for format() error
        'refusalLetterDate' => 'datetime',
        'refusalreceivedDate' => 'datetime',
        'birthDate' => 'datetime',
    ];

    protected $appends = [
        'full_name', 'validated_status', 'created_at_formatted', 'is_validated', 'form_name',
        'refusal_document_url', 'appellant_passport_url', 'proff_address_url', 'refusal_email_url', 'additional_document_url'
    ];

    public function getVerifyUrlAttribute()
    {
        return route('rawenquiry.verify', $this->unique_code);
    }

    public function getRefusalDocumentUrlAttribute()
    {
        return $this->getFileUrl($this->refusal_document);
    }

    public function getAppellantPassportUrlAttribute()
    {
        return $this->getFileUrl($this->appellant_passport);
    }

    public function getProffAddressUrlAttribute()
    {
        return $this->getFileUrl($this->proff_address);
    }

    public function getRefusalEmailUrlAttribute()
    {
        return $this->getFileUrl($this->refusal_email);
    }

    public function getAdditionalDocumentUrlAttribute()
    {
        $filePaths = [];
        if(!empty($this->additional_document)){
            $data = json_decode($this->additional_document);
            if(is_array($data)){
                foreach($data as $eachFile){
                    $url = $this->getFileUrl($eachFile);
                    if($url) $filePaths[] = $url;
                }
            }
        }
        return $filePaths;
    }

    private function getFileUrl($file)
    {
        if($file && Storage::disk('uploads')->exists($file)){
            return route('fileurl', base64_encode($file));
        }
        return null;
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->f_name} {$this->m_name} {$this->l_name}");
    }

    public function getValidatedStatusAttribute()
    {
        return $this->validated_at
            ? "Email verified on " . $this->validated_at->format("d M Y h:i:s")
            : "Email not verified";
    }

    public function form()
    {
        return $this->belongsTo(EnquiryForm::class,'form_id','id');
    }

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at ? $this->created_at->format("d M Y h:i:s") : null;
    }

    public function getStatusTextAttribute()
    {
        return $this->active ? "Active" : "Inactive";
    }

    public function mobilecode()
    {
        return $this->belongsTo(IsoCountry::class,'country_iso_mobile');
    }

    public function getContactNumberAttribute()
    {
        $str = "";
        if($this->mobilecode) $str .= "+{$this->mobilecode->calling_code} ";
        if($this->mobile) $str .= $this->mobile;
        return $str;
    }

    public function nationality()
    {
        return $this->belongsTo(IsoCountry::class,'iso_country_id');
    }

    public function country()
    {
        return $this->belongsTo(IsoCountry::class,'country_id');
    }

    public function getNationalityCountryAttribute()
    {
        return $this->nationality ? $this->nationality->title : "";
    }

    public function getIpAddressAttribute()
    {
        return optional($this->extra_details)['ip'] ?? null;
    }

    public function getIsValidatedAttribute()
    {
        return $this->validated_at ? "Yes" : "No";
    }

    public function getFormNameAttribute()
    {
        return $this->form ? $this->form->name : "";
    }

    public function enquiry()
    {
        return $this->hasOne(Enquiry::class, 'raw_enquiry_id');
    }

    public function getFullAddressAttribute()
    {
        return trim("{$this->address}, {$this->postal_code}, {$this->country_name}");
    }

    public function getCountryNameAttribute()
    {
        return $this->country ? ucwords(strtolower($this->country->title)) : "";
    }
}
