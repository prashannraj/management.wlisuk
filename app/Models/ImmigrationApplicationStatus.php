<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImmigrationApplicationStatus extends Model
{
    protected $table = 'immigration_application_statuses';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
}
