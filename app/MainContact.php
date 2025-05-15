<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainContact extends Model
{
    // Assuming your main contact table is related to service_providers table
    protected $fillable = ['serviceprovider_id', 'name', 'phone', 'email'];

    // Define the inverse relationship
    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProviders::class);
    }
}
