<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AttendanceNote extends Model
{
    //
    protected $fillable = [
        'date',
        'details',
        'mode',
        'advisor_id',
        'hours', 'minutes',
        'file',
        'basic_info_id',
        'type',
    ];

    protected $dates = ['date'];

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::createFromFormat(config('constant.another_date_format'), $value)->format('Y-m-d');
    }

    public function getDateFormattedAttribute()
    {
        if ($this->date)
            return $this->date->format(config('constant.another_date_format'));
        return '';
    }

    public function getTypeStringAttribute()
    {
        $p = config('cms.attendance_types');
        return $p[$this->type];
    }

    public function client()
    {
        return $this->belongsTo(BasicInfo::class, 'basic_info_id', 'id');
    }

    public function advisor()
    {
        return $this->belongsTo(Advisor::class, 'advisor_id', 'id');
    }

    public function getFileUrlAttribute()
    {
        if ($this->file) {
            // return Storage::disk('uploads')->url($this->file);
            return route('documenturl', base64_encode($this->file));
        }
        return '';
    }


    public function delete()
    {
        if ($this->file) {
            Storage::disk('uploads')->delete($this->file);
        }

        return parent::delete();
    }

    public function getDurationAttribute()
    {
        $str = '';
        if ($this->hours != 0) {
            if ($this->hours == 1)
                $str .= $this->hours . " hour ";

            else {
                $str .= $this->hours . " hours ";
            }
        }
        if ($this->minutes != 0) {
            if ($this->minutes == 1)
                $str .= $this->minutes . " minute ";

            else {
                $str .= $this->minutes . " minutes ";
            }
        }
        return $str;
    }
    
    public function getModeStringAttribute(){
    	$p = config('cms.attendance_modes');
    	if($this->mode == null) return '';
    	return $p[$this->mode];
    }
}
