<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestToMedical extends Model
{
    protected $fillable = ['content', 'sex','language', 'contact_by',  'advisor_id','enquiry_id','iso_country_id','date','practice_name','practice_address', 'current_address', 'paitent_name', 'paitent_address', 'date_of_birth' ];
}



