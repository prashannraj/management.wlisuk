<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImmigrationAppealApplicationStatus extends Model
{
    protected $table = 'immigration_appeal_application_statuses';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
}
