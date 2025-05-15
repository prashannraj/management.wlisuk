<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EmploymentInfo extends Model
{
    //
    protected $fillable = [
        'created_by', 'updated_by',
        'employee_id', 'job_title', 'start_date', 'type',
        'working_hours', 'working_days', 'working_time', 'salary',
        "salary_arrangement", 'ni_number', 'end_date', 'place_of_work',
        'region', 'supervisor', 'supervisor_email', 'supervisor_tel',
        'probation_period',
        'probation_end_date'
    ];

    public function setStartDateAttribute($value)
    {
        if($value)
        $this->attributes['start_date'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
        else 
            $this->attributes['start_date'] = null;
    }

    public function setEndDateAttribute($value)
    {
        if($value)
        $this->attributes['end_date'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
        else 
            $this->attributes['end_date'] = null;
    }


    public function setProbationEndDateAttribute($value)
    {
        if($value)
        $this->attributes['probation_end_date'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
        else 
            $this->attributes['probation_end_date'] = null;
    }


    public function getStartDateFormattedAttribute()
    {
        $value = $this->start_date;
        if($value != null)
        return Carbon::parse($value)->format(config('constant.date_format'));

        return '';
    }

    public function getEndDateFormattedAttribute()
    {
        $value = $this->end_date;
        if($value != null)
        return Carbon::parse($value)->format(config('constant.date_format'));

        return '';
    }

    public function getProbationEndDateFormattedAttribute()
    {
        $value = $this->probation_end_date;
        if($value != null)
        return Carbon::parse($value)->format(config('constant.date_format'));

        return '';
    }

    public function getStartAndEndAttribute(){
        $suffix='';
        if($this->end_date){
            $suffix = " to ".$this->end_date_formatted;
        }

        return $this->start_date_formatted.$suffix;
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
    

}
