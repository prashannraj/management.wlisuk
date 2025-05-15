<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientAddressDetail extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $table = 'student_addresses';
    
    protected $appends=["country_name","full_address"];

    protected $fillable = [
        'uk_address',
        'uk_postcode',
        'overseas_address',
        'overseas_postcode',
        'basic_info_id',
        'iso_countrylist_id',
        'enquiry_id',
        'created_by',
        'created',
        'modified',
        'modified_by'
    ];

    // protected $append = ['contact_mobile','contact_tel'];

    public function getAll()
    {
        return static::all();
    }
    
    public function basicinfo(){
        return $this->belongsTo(BasicInfo::class,'basic_info_id','id');
    }

    public function country(){
        return $this->belongsTo(IsoCountry::class,'iso_countrylist_id','id');
    }
    
    
    public function getCountryNameAttribute(){
    	if($this->country){
    		return ucwords(strtolower($this->country->title));
    	}
    	return "";
    }

    public function getFullAddressAttribute(){
        $address = "";
        if($this->overseas_address != "") $address.= $this->overseas_address.", ";
        if($this->overseas_postcode != "") $address.= $this->overseas_postcode.", ";
        return $address. $this->country_name;
    }
}
