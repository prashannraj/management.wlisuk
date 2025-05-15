<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientEmergencyDetail extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    
    protected $table = 'student_emergencies';

    protected $fillable = [
        'name',
        'relationship',
        'contact_number',
        'email',
        'address',
        'basic_info_id'
    ];
}
