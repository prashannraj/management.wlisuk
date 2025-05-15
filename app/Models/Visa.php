<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visa extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $table = 'current_visas';
    protected $appends = ['identification','expiry_email_status'];
    use SoftDeletes;

    protected $fillable = ['visa_type','issue_date','expiry_date','visa_number',
    'basic_info_id','employee_id','created_by','modified_by'] ;

    public function basicinfo()
    {
        return $this->belongsTo(BasicInfo::class, 'basic_info_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(BasicInfo::class, 'basic_info_id', 'id');
    }
    
      public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
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

    public function getExpiryDateRawAttribute(){
        return Carbon::parse($this->attributes['expiry_date']);
    }

    public function getIssueDateRawAttribute(){
        return $this->attributes['issue_date'];
    }

    public function setExpiryDateAttribute($value)
    {
        if ($value == null) {
            $this->attributes['expiry_date'] = null;
        } else {

            $this->attributes['expiry_date'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
        }
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

    public function expiry_email(){
        return $this->hasOne(VisaExpiryEmail::class,'visa_id');
    }

    public function getExpiryEmailStatusAttribute(){
        if($this->expiry_email)
        return "Expiry email was last sent on ".$this->expiry_email->updated_at->format('d F Y h:i:s A');
        else{
            return "Expiry Email has not been sent yet.";
        }
    }

}
