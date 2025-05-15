<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ServiceProviders extends Model
{
    protected $table = 'serviceprovider';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $dates = ['created', 'modified'];
    protected $fillable = ['company_name', 'regulated_by', 'main_contact','contact_two', 'email_one','email_two','main_tel', 'address', 'direct_contact' ];

    public static $rules = [
        'company_name' => "required|string",
        'regulated_by' => "required|string",
        'main_contact' => "nullable|array", // Ensure main_contact is an array
        'main_contact.*.name' => "required|string", // Validate the name field inside main_contact array
        'main_contact.*.phone' => "nullable|string", // Validate the phone field inside main_contact array
        'main_contact.*.email' => "nullable|email", // Validate the email field inside main_contact array
        'contact_two' => "nullable|string",
        'email_one' => "nullable|string",
        'email_two' => "nullable|string",
        'main_tel' => "nullable|string",
        'address' => "nullable|string",
        'direct_contact' => "nullable|string",
    ];


    public function mainContacts()
    {
        return $this->hasMany(MainContact::class);
    }


}

