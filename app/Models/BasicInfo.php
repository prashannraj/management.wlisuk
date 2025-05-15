<?php

namespace App\Models;

use App\ApplicationAssessment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BasicInfo extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $table = 'basic_infos';

    protected $appends = ['age', 'date_of_birth', 'delete_at_formatted', 'full_name', 'full_name_with_title', 'address', 'address_html', 'mobile_number', 'email_address', 'next_of_kin', 'visa_followup_date'];

    protected $dates = ["dob", 'delete_at'];

    use SoftDeletes; //add this line


    public function getDobAttribute($value)
    {
        if ($value == null) return $value;
        $value = Carbon::parse($value);
        return $value->format(config('constant.date_format'));
    }

    public function setDobAttribute($value)
    {
        if ($value == null) {
            $this->attributes['dob'] = null;
        } else {

            $this->attributes['dob'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
        }
    }



    public function getAgeAttribute()
    {
        if (!$this->dob) {
            return '';
        }

        return Carbon::createFromFormat(config('constant.date_format'), $this->dob)->diff(Carbon::now())->format('%y years, %m months and %d days');

        // $birthDate = date('Y-m-d', strtotime($this->dob));
        // $date1 = strtotime($birthDate);
        // $date2 = strtotime(date('Y-m-d'));
        // $diff = abs($date2 - $date1);
        // $years = floor($diff / (365 * 60 * 60 * 24));
        // $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        // $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        // $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));

        // return $years . ' years and ' . $months . ' months';
    }

    public function getDateOfBirthAttribute()
    {
        if (!$this->dob) {
            return '';
        }
        $birthDate = date('d F Y', strtotime($this->attributes['dob']));
        return $birthDate;
    }

    public function dob_format($format)
    {
        return Carbon::createFromFormat('Y-m-d', $this->attributes['dob'])->format($format);
    }

    public function getAddressAttribute()
    {
        $d = $this->studentAddressDetails()->latest()->first();
        if ($d == null) {
            return "";
        } else {
            return $d->overseas_address . ", " . $d->overseas_postcode . ", " . $d->country_name;
        }
    }


    public function getAddressHtmlAttribute()
    {
        $d = $this->studentAddressDetails()->latest()->first();
        if ($d == null) {
            return "";
        } else {
            return $d->overseas_address . "<br>" . $d->overseas_postcode . "<br>" . $d->country_name;
        }
    }

    public function getFullNameAttribute()
    {
        return $this->f_name . ' ' . $this->m_name . ' '  . $this->l_name;
    }

    public function getFullNameWithTitleAttribute()
    {
        return $this->title . '. ' .  $this->f_name . ' ' . $this->m_name . ' '  . $this->l_name;
    }

    public function studentContactDetails()
    {
        return $this->hasMany(StudentContactDetail::class, 'basic_info_id', 'id');
    }

    public function contact_details()
    {
        return $this->hasMany(StudentContactDetail::class, 'basic_info_id', 'id');
    }

    public function getNextOfKinAttribute()
    {
        $d = $this->studentEmergencyDetails()->latest()->first();
        if ($d == null) return new ClientEmergencyDetail(['name' => '-', 'relationship' => '-', 'email' => '-', 'contact_number' => '-']);

        return $d;
    }

    public function immigrationApplicationDetails()
    {
        return $this->hasMany(ImmigrationApplication::class, 'basic_info_id', 'id');
    }
    
    public function immigrationAppealApplication()
    {
        return $this->hasMany(ImmigrationAppealApplication::class, 'basic_info_id', 'id');
    }

    public function admissionApplications()
    {
        return $this->hasMany(AdmissionApplication::class, 'basic_info_id', 'id');
    }



    public function getAllApplicationsAttributes()
    {
        $collections = collect();
        foreach ($this->immigrationApplications as $immig) {
            $collections->push($immig);
        }
        foreach ($this->admissionApplications as $adm) {
            $collections->push($adm);
        }

        return $collections;
    }



    public function studentAddressDetails()
    {
        return $this->hasMany(ClientAddressDetail::class, 'basic_info_id', 'id');
    }

    public function addresses()
    {
        return $this->hasMany(ClientAddressDetail::class, 'basic_info_id', 'id');
    }

    public function studentEmergencyDetails()
    {
        return $this->hasMany(ClientEmergencyDetail::class, 'basic_info_id', 'id');
    }

    public function kins()
    {
        return $this->hasMany(ClientEmergencyDetail::class, 'basic_info_id', 'id');
    }

    public function passport()
    {
        return $this->hasMany(PassportDetail::class, 'basic_info_id', 'id');
    }

    public function attendance_notes()
    {
        return $this->hasMany(AttendanceNote::class, 'basic_info_id', 'id');
    }

    public function currentvisa()
    {
        return $this->hasMany(Visa::class, 'basic_info_id', 'id');
    }



    public function ukvisa()
    {
        return $this->hasMany(UkVisa::class, 'basic_info_id', 'id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'basic_info_id', 'id');
    }


    public function immigration_application_processes()
    {
        return $this->hasManyThrough(ImmigrationApplicationProcess::class, ImmigrationApplication::class, "basic_info_id", "application_id");
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'basic_info_id', 'id');
    }

    public function application_assessments()
    {
        return $this->hasMany(ApplicationAssessment::class, 'basic_info_id', 'id');
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class, 'basic_info_id', 'id');
    }

    public function communicationlogs()
    {
        return $this->hasMany(CommunicationLog::class, 'basic_info_id', 'id');
    }


    public  function getMobileNumberAttribute()
    {
        $d = $this->studentContactDetails()->latest()->first();
        if ($d == null) {
            return "";
        } else {
            return $d->contact_mobile;
        }
    }

    public function getEmailAddressAttribute()
    {
        $d = $this->studentContactDetails()->latest()->first();
        if ($d == null) {
            return "";
        } else {
            return $d->primary_email;
        }
    }

    public function getNationalityAttribute()
    {
        return ($this->passport()->latest()->first()) ? $this->passport()->latest()->first()->country->title : '';
    }


    public function additionaldata()
    {
        return $this->hasMany(AdditionalDocumentData::class, 'basic_info_id');
    }


    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class, 'enquiry_list_id');
    }

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class, 'client_id');
    }


    public function getVisaFollowupDateAttribute()
    {
        $d = $this->currentvisa()->latest()->whereStatus("Active")->first();
        if ($d == null) return '-';
        $followupdate = $d->expiry_date_raw->subMonths(5)->format(config('constant.date_format'));
        return $followupdate;
    }


    public function getDeleteAtFormattedAttribute()
    {
        if ($this->delete_at) {
            return $this->delete_at->format(config('constant.date_format'));
        }

        return "-";
    }


    public function forceDelete()
    {

        foreach ($this->communicationlogs as $log) {
            $log->delete();
        }

        foreach ($this->documents as $document) {
            $document->delete();
        }

        foreach ($this->invoices as $invoice) {
            $invoice->delete();
        }

        foreach ($this->receipts as $receipt) {
            $receipt->delete();
        }

        foreach ($this->studentContactDetails as $std) {
            $std->delete();
        }


        return parent::forceDelete();
    }
}
