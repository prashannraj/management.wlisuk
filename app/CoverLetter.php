<?php

namespace App;

use App\Models\ImmigrationApplication;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CoverLetter extends Model
{
    //
    protected $fillable = [
        're',
        'to_address',
        'text',
        'date',
        'application_id',
        'application_assessment_id',
        'include_financial_assessment'
    ];

    protected $dates = ['date'];

    public function setDateAttribute($value)
    {
        if ($value == null) {
            $this->attributes['date'] = null;
        } else {

            $this->attributes['date'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
        }
    }

    public function application_assessment(){
        return $this->belongsTo(ApplicationAssessment::class);
    }

    public function application(){
        return $this->belongsTo(ImmigrationApplication::class);
    }

    public function getDateFormattedAttribute()
    {
        if($this->date)
        return Carbon::parse($this->date)->format(config('constant.date_format'));

        return '';
    }
}
