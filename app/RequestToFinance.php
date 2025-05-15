<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestToFinance extends Model
{
    protected $fillable = ['content','advisor_id','enquiry_id', 'iso_country_id', 'date','agency','client_name', 'date_of_birth', 'street_address', 'post_code', 'account', 'previous_address', 'sex', 'contact_by', 'language'];
}
