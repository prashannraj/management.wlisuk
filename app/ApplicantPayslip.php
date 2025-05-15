<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ApplicantPayslip extends Model
{
    //
    protected $fillable = [
        'date',
        'bank_date',
        'employment_info_id',
        'gross_pay' ,
        'net_pay',
        'proof_sent',
        'note'
    ];

    protected $dates = ['date','bank_date'];

    public function getProofClassAttribute(){
        if($this->proof_sent == 'Yes') return 'btn-primary';
        if($this->proof_sent == 'No') return 'btn-warning';

    }

    public function setDateAttribute($value){
        if ($value == null) {
            $this->attributes['date'] = null;
        } else {

            $this->attributes['date'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
        }
    }


    public function setBankDateAttribute($value){
        if ($value == null) {
            $this->attributes['bank_date'] = null;
        } else {
            $this->attributes['bank_date'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
        }
    }


    public function getDateFormattedAttribute()
    {
        $value = $this->date;
        if($value == null ) return null;
        return Carbon::parse($value)->format(config('constant.date_format'));
    }

    public function getBankDateFormattedAttribute()
    {
        $value = $this->bank_date;
        if($value == null ) return null;
        return Carbon::parse($value)->format(config('constant.date_format'));
    }

    public function employment_info(){
        return $this->belongsTo(ApplicantEmploymentInfo::class,'employment_info_id');
    }

  
    
}
