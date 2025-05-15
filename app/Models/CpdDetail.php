<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CpdDetail
 * @package App\Models
 * @version May 25, 2021, 10:59 am UTC
 *
 * @property \App\Models\Cpd $id
 * @property string $date
 * @property string $what
 * @property string $why
 * @property string $complete_objective
 * @property string $apply_learning
 * @property integer $cpd_id
 */
class CpdDetail extends Model
{

    public $table = 'cpd_details';
    

    protected $appends = ['date_formatted'];

    public $fillable = [
        'date',
        'what',
        'why',
        'complete_objective',
        'apply_learning',
        'cpd_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date' => 'date',
        'complete_objective' => 'string',
        'cpd_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'date'=>'required',
        'what'=>'required',
        'why'=>'required',
        'complete_objective'=>'required',
        'apply_learning'=>'required',
        'cpd_id'=>'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function Cpd()
    {
        return $this->belongsTo(\App\Models\Cpd::class, 'id', 'cpd_id');
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
    }


    public function getDateFormattedAttribute($value)
    {
        $value = $this->attributes['date'];
        return Carbon::parse($value)->format(config('constant.date_format'));
    }
}
