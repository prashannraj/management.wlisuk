<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EnquiryFollowUp extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $table = 'enquiry_followups';
    protected $dates = ['date'];

    protected $fillable = [
        'enquiry_activity_id',
        'date',
        'followup_mode',
        'followup_status',
        'followup_time',
        'created_by',
        'modified_by',
        'created',
        'modified'
    ];

    public function getDateAttribute($value)
    {
        if ($value == null) {
            return null;
        }
        return Carbon::parse($value)->format(config('constant.date_format'));
    }

    public function setDateAttribute($value)
    {
        if ($value == null) {
            $this->attributes['date'] = null;
            return;
        }
        $this->attributes['date'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
    }

    public function enquiry_activity()
    {
        return $this->belongsTo(EnquiryActivity::class);
    }

    public function date_difference()
    {
        return Carbon::createFromFormat(config('constant.date_format'), $this->date)->diffForHumans();
    }
}
