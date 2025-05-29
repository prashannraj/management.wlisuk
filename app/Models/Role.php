<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    
    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function users()
    {
    return $this->hasMany(User::class);
    }
}
