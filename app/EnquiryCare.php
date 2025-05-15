<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EnquiryCare extends Model
{
    //
    protected $fillable = ['additional_content', 'coverletter_content', 'advisor_id', 'enquiry_id', 'date', 'full_address'];


}
