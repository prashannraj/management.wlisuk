<?php

namespace App\Models;

use App\Events\ModelUpdatedEvent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Event;
use Illuminate\Notifications\Notifiable;

class Employee extends Model
{
    //
    use SoftDeletes; //add this line

    protected $fillable = ['m_name','signature','f_name','l_name','dob','gender','status','created_by','title','modified_by'];

    protected $dates = ['created_at','updated_at','dob','delete_at'];
    protected $appends = ['full_name','delete_at_formatted'];


    public function getAgeAttribute()
    {
        if (!$this->dob) {
            return '';
        }

        return $this->dob->diff(Carbon::now())->format('%y years, %m months and %d days');
    }

    public function setDobAttribute($value){
        if($value==null){
            $this->attributes['dob'] = null;
            return;
        }
        $this->attributes['dob'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');

    }

    public function getDobFormattedAttribute(){
        if($this->dob == null) return '';
        return $this->dob->format(config('constant.date_format'));
    }

    public function getFullNameAttribute(){
        if($this->m_name){
            return $this->f_name." ".$this->m_name." ".$this->l_name;
        }
        return $this->f_name." ".$this->l_name;
    }


    public function getFullNameWithTitleAttribute(){
        if($this->m_name){
            return $this->title.". ".$this->f_name." ".$this->m_name." ".$this->l_name;
        }
        return $this->title.". ".$this->f_name." ".$this->l_name;
    }

    public function contact_details(){
        return $this->hasMany(EmployeeContactDetail::class);
    }

    public function addresses(){
        return $this->hasMany(EmployeeAddress::class);
    }

    public function employment_infos(){
        return $this->hasMany(EmploymentInfo::class);
    }

    public function getCurrentEmploymentInfoAttribute(){
        $i = $this->employment_infos()->where('end_date',null)->latest()->first();
        return $i;
    }

    public function emergency_contacts(){
        return $this->hasMany(EmployeeEmergencyContact::class);
    }

    public function passports(){
        return $this->hasMany(PassportDetail::class);
    }

    public function currentvisas(){
        return $this->hasMany(Visa::class);
    }

    public function documents(){
        return $this->hasMany(EmployeeDocument::class);
    }

    public function payslips(){
        return $this->hasMany(PaySlip::class);
    }
    public function p4560s(){
        return $this->hasMany(P5060::class);
    }


    public function communicationlogs(){
        return $this->hasMany(CommunicationLog::class);
    }

    public function additionaldata(){
        return $this->hasMany(AdditionalDocumentData::class);
    }

    public function getEmailAttribute(){
        $e = $this->contact_details()->latest()->first();
        if($e){
            return $e->primary_email;
        }
        return '';
    }

    public function getNationalityAttribute(){
        return ($this->passports()->latest()->first())? $this->passports()->latest()->first()->country->title: '';
     }


     public function getSignatureUrlAttribute(){
         if($this->signature)
         return Storage::disk("uploads")->url($this->signature);
         return "";
     }

     public function getDeleteAtFormattedAttribute(){
        if($this->delete_at){
            return $this->delete_at->format(config('constant.date_format'));
        }
        return "-";
     } 
}
