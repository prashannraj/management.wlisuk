<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionApplicationStatus extends Model
{
    protected $table = 'admission_application_statuses';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
}
