<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AdmissionApplication extends Model
{
    protected $table = 'admission_applications';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    protected $appends = ['country_name'];

    protected $fillable = ['basic_info_id', 'iso_countrylist_id', 'student_name','application_status_id', 'partner_id', 'course_name', 'course_start', 'application_method', 'remarks', 'created_by', 'updated_by'];

    protected $dates = ['course_start'];


    public function basicinfo()
    {
        return $this->belongsTo(BasicInfo::class, 'basic_info_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo(IsoCountry::class, 'iso_countrylist_id', 'id');
    }




    public function getCourseStartAttribute($value)
    {
        return Carbon::parse($value)->format(config('constant.date_format'));
    }

    public function setCourseStartAttribute($value)
    {
        if ($value == "") return $value;
        $this->attributes['course_start'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
    }


    public function getCourseStartDateAttribute($value)
    {
        return Carbon::createFromFormat(config('constant.date_format'), $this->course_start);
    }


    public function getCountryNameAttribute()
    {
        return $this->country->title;
    }


    public function client()
    {
        return $this->belongsTo(BasicInfo::class, 'basic_info_id', 'id');
    }

    public function getFileUrlAttribute()
    {
        if ($this->document) {
            return URL::asset('/uploads/files/' . $this->document);
        } else {
            return null;
        }
    }

    public function applicationProcesses()
    {
        return $this->hasMany(AdmissionApplicationProcess::class, 'application_id', 'id');
    }


    public function status()
    {
        return $this->belongsTo(AdmissionApplicationStatus::class, 'application_status_id', 'id');
    }

    public function getApplicationTypeAttribute()
    {
        return 'admission';
    }

    public function date_submitted_format($format)
    {
        return optional($this->created_at)->format($format);
    }


    public function type()
    {
        return "admission";
    }


    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }


}
