<?php

namespace App;

use App\Models\IsoCurrency;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ApplicantEmploymentInfo extends Model
{
    //
    protected $fillable = [
        'company_name','position','start_date','end_date','position',
        'currency_id','sponsor_name','currency_rate',
        'calculation_type','salary_requirement','application_assessment_id'
    ];

    protected $dates = ['start_date','end_date'];

    public function setStartDateAttribute($value){
        if ($value == null) {
            $this->attributes['start_date'] = null;
        } else {

            $this->attributes['start_date'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
        }
    }

    public function getStatusAttribute(){
        if($this->payslips()->where('proof_sent',"No")->count()>0) return "Pending";
        return "Completed";
    }


    public function setEndDateAttribute($value){
        if ($value == null) {
            $this->attributes['end_date'] = null;
        } else {
            $this->attributes['end_date'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
        }
    }


    public function getStartDateFormattedAttribute()
    {
        $value = $this->start_date;
        if($value == null ) return null;
        return Carbon::parse($value)->format(config('constant.date_format'));
    }

    public function getEndDateFormattedAttribute()
    {
        $value = $this->end_date;
        if($value == null ) return null;
        return Carbon::parse($value)->format(config('constant.date_format'));
    }


    public function payslips(){
        return $this->hasMany(ApplicantPayslip::class,'employment_info_id');
    }

    public function currency(){
        return $this->belongsTo(IsoCurrency::class,'currency_id');
    }

    public function application_assessment(){
        return $this->belongsTo(ApplicationAssessment::class,'application_assessment_id');
    }

    public function getTotalAttribute(){
        $total = 0;
        foreach($this->payslips as $payslip){
            $total += $payslip->gross_pay;
        }

        return $total;
    }

    public function getTotalInGbpAttribute(){
        if($this->currency->title == "GBP") return $this->total;
        return $this->total * $this->currency_rate;
    }

    public function getIsGbpAttribute(){
        return $this->currency->title == "GBP";
    }

    public function getGrossTotalInGbpAttribute(){
        if($this->currency->title == "GBP") return $this->gross_total;
        return $this->gross_total * $this->currency_rate;
    }

    public function getGrossTotalAttribute(){
        $total = $this->total;
        if($this->calculation_type=='12 months')
        return $total;
        return $total*2;
    }
}
