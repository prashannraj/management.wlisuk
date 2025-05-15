<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientOfAuthority extends Model
{
    protected $fillable = ['client_name',
    'full_address',
    'parent_address',
    'content',
    'date',
    'date_of_birth',
    'iso_country_id',
    'email',
    'attachments','advisor_id','enquiry_id'];

}
