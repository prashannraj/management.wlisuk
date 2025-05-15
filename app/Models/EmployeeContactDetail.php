<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeContactDetail extends Model
{
    //
    protected $fillable = ['employee_id','mobile_number','contact_number','country_contact',
    'country_mobile','primary_email','created_by','modified_by'];


    public function getCountryCodeMobileAttribute(){
        if($this->c_mobile){
            return "+".$this->c_mobile->calling_code;
        }
        return "";
    }

    public function getCountryCodeContactAttribute(){
        if($this->c_contact){
            return "+".$this->c_contact->calling_code;
        }
        return "";
    }

    public function c_mobile()
    {
        return $this->belongsTo(IsoCountry::class,'country_mobile','id');
    }
    
    public function c_contact()
    {
        return $this->belongsTo(IsoCountry::class,'country_contact','id');
    }

    public function getFullMobileNumberAttribute(){
        return $this->country_code_mobile." ".$this->mobile_number;
    }


    public function getFullContactNumberAttribute(){
        return $this->country_code_contact." ".$this->contact_number;
    }

    
}
