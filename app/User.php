<?php

namespace App;

use App\Models\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use Notifiable;

    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password','modified_by','department_id','role_id'
    ];

    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'allowed_devices'=>'array',
        'last_login'=>'datetime'
    ];

    public function authorizeRoles($roles)
    {
        // if (is_array($roles)) {
        //     return $this->hasAnyRole($roles) || 
        //             abort(401, 'This action is unauthorized.');
        // }
        return $this->hasRole($roles) || 
                abort(401, 'This action is unauthorized.');
    }

    public function hasAnyRole($roles)
    {
        // dd($roles);
        // dd($this->roles()->whereIn('title', strtolower($roles))->first());
        return null !== $this->roles()->whereIn(‘name’, $roles)->first();
    }

    public function hasRole($role)
    {
        return null !== $this->roles()->where('title', ucfirst($role))->first();
    }

    public function roles()
    {
        return $this->belongsTo(Role::class,'role_id');
    }

    public function role()
    {
        return $this->hasOne(Role::class,'role_id');
    }

}
