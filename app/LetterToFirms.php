<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LetterToFirms extends Model
{
    protected $fillable = ['content','advisor_id','enquiry_id','date', 'date_of_birth','full_address', 'your_date_of_birth', 'your', 'firmsname', 'firmsaddress', 'firmsemail', 'sponsor_relationship', 'sponsor_name'];
}
