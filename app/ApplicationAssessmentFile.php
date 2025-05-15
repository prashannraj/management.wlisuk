<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ApplicationAssessmentFile extends Model
{
    //
    protected $fillable = ['name','description','application_assessment_id','location','assessment_section_id'];

    public function delete(){
        Storage::disk('uploads')->delete($this->location);
        return parent::delete();
    }

    public function getUrlAttribute(){
        return route('application_assessment_file.preview',$this->id);
    }

    public function section(){
        return $this->belongsTo(AssessmentSection::class,'assessment_section_id');
    }
}
