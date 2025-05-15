<?php

namespace App\Models;

use App\CoverLetter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImmigrationAppealApplication extends Model
{
    protected $table = 'immigration_appeal_applications';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    protected $appends = ['file_url','country_name','sub_reason','closure_date','file_opening_date_formatted','date_submitted_formatted'];

    //use SoftDeletes;

    public function basicinfo(){
        return $this->belongsTo(BasicInfo::class,'basic_info_id','id');
    }

    public function country(){
        return $this->belongsTo(IsoCountry::class,'iso_countrylist_id','id');
    }

    public function date_submitted_format($format){
        return Carbon::createFromFormat('Y-m-d', $this->date_submitted)->format($format);
    }

    public function getDateSubmittedFormattedAttribute(){
        if(!$this->date_submitted) return '';
        return Carbon::createFromFormat('Y-m-d', $this->date_submitted)->format(config('constant.date_format'));

    }

    

    public function getCountryNameAttribute(){
        return $this->country->title;
    }
    
    public function advisor(){
        return $this->belongsTo(Advisor::class,'advisor_id','id');
    }

    public function client(){
        return $this->belongsTo(BasicInfo::class,'basic_info_id','id');
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
        return $this->hasMany(ImmigrationAppealApplicationProcesses::class, 'application_id', 'id');
    }

    public function coverletter()
    {
        return $this->hasOne(CoverLetter::class, 'application_id', 'id');
    }

    public function getSubReasonAttribute(){
        $process = $this->applicationProcesses()->orderBy('id','desc')->first();
        if($process){
            return $process->reason;
        }else{
            return '';
        }
    }


    public function getClosureDateAttribute(){
        $process = $this->applicationProcesses()->orderBy('id','desc')->first();
        if($process){
            return $process->date;
        }else{
            return '';
        }
    }


    public function status(){
        return $this->belongsTo(ImmigrationAppealApplicationStatus::class,'application_status_id','id');
    }

    public function type(){
        return 'immigration';
    }

    public function getUniqueIdAttribute(){
        return $this->type()."_".$this->id;
    }


    public function setFileOpeningDateAttribute($value)
    {
        $this->attributes['file_opening_date'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
    }


    public function getFileOpeningDateFormattedAttribute($value)
    {
    	$value = $this->file_opening_date;
    	if($value==null) return;
        return Carbon::parse($value)->format(config('constant.date_format'));
    }

}
