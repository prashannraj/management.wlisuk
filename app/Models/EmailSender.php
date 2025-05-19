<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * Class EmailSender
 * @package App\Models
 * @version May 17, 2021, 11:46 am UTC
 *
 * @property string $name
 * @property string $email
 * @property string $remarks
 */
class EmailSender extends Model
{
    use Notifiable;
    public $table = 'email_senders';
    



    public $fillable = [
        'id',
        'name',
        'email',
        'remarks'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'remarks' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id'=>'required|unique:email_senders,id',
        'name'=>'required',
        'email'=>'required',
        'remarks'=>'nullable'
    ];

    
}
