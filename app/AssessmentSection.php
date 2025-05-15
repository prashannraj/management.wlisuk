<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessmentSection extends Model
{
    //
    public function documents()
    {
        return $this->hasMany(ApplicationAssessmentFile::class, 'assessment_section_id');
    }

    public function getStatusClassAttribute()
    {
        if ($this->status == 'pending') return 'btn-warning';
        if ($this->status == 'completed') return 'btn-primary';
    }
}
