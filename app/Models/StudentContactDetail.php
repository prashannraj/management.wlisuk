<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentContactDetail extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $table = 'student_contact_details';

    protected $fillable = [
        'basic_info_id',
        'primary_mobile',
        'contact_number_two',
        'primary_email',
        'country_mobile',
        'country_contacttwo',
        'enquiry_list_id',
        'created_by',
        'created',
        'modified',
        'modified_by'
    ];

    protected $append = ['contact_mobile','contact_tel'];

    public function getAll()
    {
        return static::all();
    }
    
    public function basicinfo(){
        return $this->belongsTo(BasicInfo::class,'basic_info_id','id');
    }

    public function enquiry(){
        return $this->belongsTo(Enquiry::class,'enquiry_list_id','id');
    }

    public function getContactMobileAttribute()
    {
        // dd($this->countryMobile);
        if($this->primary_mobile){
            return '+' . $this->countryMobile->calling_code . '-' . $this->primary_mobile;
        }else{
            return '-';
        }
    }

    public function getContactTelAttribute()
    {
        if($this->contact_number_two){
            return '+' . $this->countryTel->calling_code . '-' . $this->contact_number_two;
        }else{
            return '-';
        }
    }

    public function countryMobile()
    {
        return $this->belongsTo(IsoCountry::class,'country_mobile','id');
    }
    
    public function countryTel()
    {
        return $this->belongsTo(IsoCountry::class,'country_contacttwo','id');
    }

}
