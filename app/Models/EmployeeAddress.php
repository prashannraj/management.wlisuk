<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeAddress extends Model
{
    //
    protected $fillable = ['employee_id','postal_code','address','iso_countrylist_id','created_by','modified_by'];


    
    
    public function country()
    {
        return $this->belongsTo(IsoCountry::class,'iso_countrylist_id','id');
    }

    public function getCountryNameAttribute(){
        if($this->country){
            return ucwords($this->country->title);
        }
        return "";
    }


    public function getFullAddressAttribute(){
        return $this->address.", ". $this->postal_code.", ". $this->country_name;
    }

    public function getFullAddressOnlyAttribute(){
        return $this->address.", ". $this->country_name;
    }
    
}
