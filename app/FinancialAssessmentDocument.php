<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FinancialAssessmentDocument extends Model
{
    //
    protected $fillable = ['application_assessment_id','content'];

    protected $casts = [
        'content'=>'json'
    ];

    function application_assessment(){
        return $this->belongsTo(ApplicationAssessment::class,'application_assessment_id');
    }
}
