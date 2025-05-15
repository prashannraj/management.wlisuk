<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeEmergencyContact extends Model
{
    //
    protected $fillable = ['employee_id','name','address','contact_number',
    'relationship','email','created_by','modified_by'];




    public function getCountryCodeAttribute(){
        if($this->c_code){
            return "+".$this->c_code->calling_code;
        }
        return "";
    }

    public function c_code()
    {
        return $this->belongsTo(IsoCountry::class,'iso_countrylist_id','id');
    }
    

    
}
