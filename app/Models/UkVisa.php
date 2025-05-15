<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UkVisa extends Model
{

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $table = 'uk_visas';
    protected $dates = ['course_start_date', 'course_end_date', 'issue_date', 'expiry_date'];

    public function basicinfo()
    {
        return $this->belongsTo(BasicInfo::class, 'basic_info_id', 'id');
    }

    public function getIssueDateAttribute($value)
    {
        if ($value == null) return $value;
        $value = Carbon::parse($value);
        return $value->format(config('constant.date_format'));
    }

    public function setIssueDateAttribute($value)
    {
        if ($value == null) {
            $this->attributes['issue_date'] = null;
        } else {

            $this->attributes['issue_date'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
        }
    }


    public function getExpiryDateAttribute($value)
    {
        if ($value == null) return $value;
        $value = Carbon::parse($value);

        return $value->format(config('constant.date_format'));
    }

    public function setExpiryDateAttribute($value)
    {
        if ($value == null) {
            $this->attributes['expiry_date'] = null;
        } else {

            $this->attributes['expiry_date'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
        }
    }


    public function getCourseStartDateAttribute($value)
    {
        if ($value == null) return $value;
        $value = Carbon::parse($value);

        return $value->format(config('constant.date_format'));
    }

    public function setCourseStartDateAttribute($value)
    {
        if ($value == null) {
            $this->attributes['course_start_date'] = null;
        } else {

            $this->attributes['course_start_date'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
        }
    }


    public function getCourseEndDateAttribute($value)
    {
        if ($value == null) return $value;
        $value = Carbon::parse($value);

        return $value->format(config('constant.date_format'));
    }

    public function setCourseEndDateAttribute($value)
    {
        if ($value == null) {
            $this->attributes['course_end_date'] = null;
        } else {

            $this->attributes['course_end_date'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
        }
    }
}
