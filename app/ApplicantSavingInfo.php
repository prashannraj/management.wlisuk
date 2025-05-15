<?php

namespace App;

use App\Models\IsoCountry;
use App\Models\IsoCurrency;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ApplicantSavingInfo extends Model
{
    //
    protected $fillable = [
        "bank_name",'sponsor_name', "account_name", "account_number","currency_id","currency_rate", "start_date", "minimum_balance", "closing_date", "closing_balance", 'application_assessment_id', 'country_id'
    ];

    protected $dates = ['start_date', 'closing_date'];

    public function setStartDateAttribute($value)
    {
        if ($value == null) {
            $this->attributes['start_date'] = null;
        } else {

            $this->attributes['start_date'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
        }
    }


    public function setClosingDateAttribute($value)
    {
        if ($value == null) {
            $this->attributes['closing_date'] = null;
        } else {
            $this->attributes['closing_date'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
        }
    }


    public function getStartDateFormattedAttribute()
    {
        $value = $this->start_date;
        if ($value == null) return null;
        return Carbon::parse($value)->format(config('constant.date_format'));
    }

    public function getClosingDateFormattedAttribute()
    {
        $value = $this->closing_date;
        if ($value == null) return null;
        return Carbon::parse($value)->format(config('constant.date_format'));
    }

    public function country(){
        return $this->belongsTo(IsoCountry::class,'country_id');
    }

    public function getCountryNameAttribute(){
        return ucfirst(strtolower($this->country->title));
    }

    public function currency(){
        return $this->belongsTo(IsoCurrency::class,'currency_id');
    }


    public function getClosingBalanceInGbpAttribute(){
        if($this->currency->title == "GBP") return $this->closing_balance;
        return $this->closing_balance * $this->currency_rate;
    }

    public function getIsGbpAttribute(){
        return $this->currency->title == "GBP";
    }

    public function getMinimumBalanceInGbpAttribute(){
        if($this->currency->title == "GBP") return $this->minimum_balance;
        return $this->minimum_balance * $this->currency_rate;
    }

}
