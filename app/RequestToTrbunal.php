<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestToTrbunal extends Model
{
    protected $fillable = ['content', 'sex', 'advisor_id','enquiry_id', 'date','reference_number','appellant_name', 'current_address', 'appeal_number', 'sponsor_address', 'date_of_birth', 'contact_details', 'contacted_by' ];
}
