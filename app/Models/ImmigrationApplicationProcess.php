<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ImmigrationApplicationProcess extends Model
{
    protected $table = 'immigration_application_processes';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    
    protected $appends = ['elapsed_days','file_url'];
    protected $dates = ['date'];
    
    
    protected $fillable= ['note','application_status_id','reason','date','application_id','document','modified_by','created_by','created','modified'];
    
    public function getDateAttribute($value)
    {
        if($value==null){
            return null;
        }
        return Carbon::parse($value)->format(config('constant.date_format'));
    }

    public function setDateAttribute($value)
    {
        if($value==null){
            $this->attributes['date'] = null;
            return;
        }
        $this->attributes['date'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
    }

    public function application(){
        return $this->belongsTo(ImmigrationApplication::class,'application_id','id');
    }
    public function applicationStatus(){
        return $this->belongsTo(ImmigrationApplicationStatus::class,'application_status_id','id');
    }

    

    public function getFileUrlAttribute()
	{
        if ($this->document) {
			return route('documenturl', base64_encode($this->document));
		} else {
			return null;
		}
    }


    public function getElapsedDaysAttribute()
    {
        $date = Carbon::parse($this->created);
        $now = Carbon::now();
        $e = "";
        $p = \App\Models\ImmigrationApplicationProcess::where("application_status_id",">",$this->application_status_id)->where('application_id',$this->application_id)->orderBy("application_status_id","asc")->first();
        if($p){
        	$now = $p->created;
        	$e = $p->id;
        	
        }
        // $updated = Carbon::parse($this->updated);

        return $date->diffInDays($now) . ' days';//.$e;
    }

    public function getCreatedAtAttribute()
    {
        $date = Carbon::parse($this->created)->format('d F Y');
        return $date;
    }

    public function delete(){
        Storage::disk("uploads")->delete($this->document);
        return parent::delete();
    }
}
