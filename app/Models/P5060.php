<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class P5060 extends Model
{
    //
    protected $fillable = ['year', 'type', 'document', 'note','employee_id'];

    public function getFileTypeAttribute()
    {
        $fileType = 'fa fa-eye text-default';

        return $fileType;
    }

    public function getFileUrlAttribute()
    {
        if ($this->document) {
            return route('documenturl', base64_encode($this->document));
        } else {
            return null;
        }
    }



    public function employee(){
       return $this->belongsTo(Employee::class);
    }
}
