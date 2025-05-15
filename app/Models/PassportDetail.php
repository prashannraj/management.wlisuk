<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PassportDetail extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    use SoftDeletes;
    // protected $appends = 'latest_passport';
    protected $table = 'passport_details';

    protected $dates =['issue_date','expiry_date'];
    protected $appends = ['identification'];
    protected $fillable = ['issue_date','expiry_date','employee_id','passport_number','iso_countrylist_id',
    'birth_place','issuing_authority','citizenship_number','created_by','modified_by','basic_info_id'];

    public function getLatestPassportAttribute()
    {
        if(count($this)>0){
            return 0;
        }
        // return $this->orderBy('created','desc')->first();
    }
    public function country(){
        return $this->belongsTo(IsoCountry::class,'iso_countrylist_id','id');
    }
    
    public function basicinfo(){
        return $this->belongsTo(BasicInfo::class,'basic_info_id','id');
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

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function client(){
        return $this->belongsTo(BasicInfo::class,'basic_info_id');
    }

    public function getTypeAttribute(){
        if($this->employee_id) return "employee";
        return "basic_info";
    }

    public function getIdentificationAttribute(){
        if($this->employee){
            return $this->employee->full_name." (employee)";
        }
        if($this->client){
            return $this->client->full_name." (client)";
        }
        return "Client/Employee Deleted";
    }
}
