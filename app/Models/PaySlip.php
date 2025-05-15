<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaySlip extends Model
{
    //
    protected $fillable = ['year', 'month', 'document', 'note','employee_id'];

    public function getFileTypeAttribute()
    {
        $fileType = 'fa fa-eye text-default';

        return $fileType;
    }

    public function getFileUrlAttribute()
    {
        if ($this->document) {
            return route('documenturl', base64_encode($this->document));
        } else {
            return null;
        }
    }

    public function getMonthStringAttribute(){
    	$engmonths = ["","January","February","March","April","May","June","July","August","September","October","November","December"];
		return $engmonths[$this->month];
        // return date_create_from_format("m",$this->month)->format('F');
    }


    public function getYearMonthAttribute(){
        return $this->month_string." ".$this->year;
    }


    public function employee(){
       return $this->belongsTo(Employee::class);
    }
}
