<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EmployeeDocument extends Model
{
    //
    protected $appends = ['file_type', 'file_url'];

    protected $fillable = [
        'employee_id',
        'name',
        'note',
        'document',
        'ftype',
        'created_by',
        'modified_by'
    ];
    public function getFileTypeAttribute()
    {
        $fileType = 'fa fa-eye text-default';
        if (!empty($this->document)) {
            if ($this->ftype == 'image') {
                $fileType = 'fa fa-image text-info';
                return $fileType;
            } elseif ($this->ftype == 'pdf') {
                $fileType = 'fa fa-file-pdf text-danger';
            } elseif ($this->ftype == 'document') {
                $fileType = 'fa fa-file-word text-success';
            } else {
                return $fileType;
            }
            return $fileType;
        } else {
            return $fileType;
        }
    }

    public function getFileUrlAttribute()
    {
        if ($this->document) {
            return route('documenturl', base64_encode($this->document));
        } else {
            return null;
        }
    }

    public function employee()
    {
        return $this->belongsTo(BasicInfo::class, 'employee_id', 'id');
    }

    public function delete()
    {
        Storage::disk('uploads')->delete($this->document);

        return parent::delete();
    }
}
