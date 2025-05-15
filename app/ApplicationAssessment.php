<?php

namespace App;

use App\Models\BasicInfo;
use App\Models\IsoCountry;
use App\Models\Servicefee;
use Illuminate\Database\Eloquent\Model;

class ApplicationAssessment extends Model
{
    //
    protected $fillable = ['basic_info_id','description','files','name',
    'applying_from','applying_to','application_detail_id'];

    protected $casts = ['files'=>'json'];

    public function getStatusClassAttribute(){
        if($this->status == 'pending') return 'btn-warning';
        if($this->status == 'completed') return 'btn-primary';
        if($this->status == 'cancelled') return 'btn-error';


    }

    public function country_applying_to(){
        return $this->belongsTo(IsoCountry::class,'applying_to');
    }

    public function country_applying_from(){
        return $this->belongsTo(IsoCountry::class,'applying_from');
    }

    public function client(){
        return $this->belongsTo(BasicInfo::class,'basic_info_id');
    }

    public function application_detail(){
        return $this->belongsTo(Servicefee::class,'application_detail_id');

    }

    public function documents(){
        return $this->hasMany(ApplicationAssessmentFile::class,'application_assessment_id');
    }

    public function sections(){
        return $this->hasMany(AssessmentSection::class,'application_assessment_id');
    }
    public function employment_details(){
        return $this->hasMany(ApplicantEmploymentInfo::class,'application_assessment_id');
    }

    public function saving_infos(){
        return $this->hasMany(ApplicantSavingInfo::class,'application_assessment_id');
    }

    public function getTotalIncomeAttribute(){
        $total = 0;
        foreach($this->employment_details as $em){
            $total+=$em->gross_total;
        }

        return $total;
    }

    public function getTotalSavingsAttribute(){
        $total = 0;
        foreach($this->saving_infos as $em){
            $total+=$em->closing_balance_in_gbp;
        }

        return $total;
    }

    public function shortfall($minimum){
        return $minimum - $this->total_income;
    }

    public function financial_assessment_document(){
        return $this->hasOne(FinancialAssessmentDocument::class,'application_assessment_id');
    }
}

