<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileOpeningForm extends Model
{
    protected $fillable = ['client_name',
    'current_address',
    'mobile',
    'content',
    'date',
    'date_of_birth',
    'iso_country_id',
    'email',
    'matter',
    'nationality',
    'iso_country_id',
    'authorised_name',
    'authorised_relation',
    'contact_no',
    'authorised_email',
    'authorised_address',
    'word',
    'attachments','advisor_id','enquiry_id'];

}
