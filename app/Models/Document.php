<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
// Client Document
use URL;

class Document extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $table = "student_documents";
    protected $appends = ['file_type', 'file_url'];

    protected $fillable = [
        'basic_info_id',
        'name',
        'note',
        'documents',
    ];

    public function getFileTypeAttribute()
	{
        $fileType = 'fa fa-eye text-default';
        if (!empty($this->documents)) {
            if($this->ftype == 'image'){
                $fileType = 'fa fa-image text-info';
                return $fileType;
            }elseif($this->ftype == 'pdf'){
                $fileType = 'fa fa-file-pdf text-danger';
            }elseif($this->ftype == 'document'){
                $fileType = 'fa fa-file-word text-success';
            }else{
                return $fileType;
            }
            return $fileType;
		} else {
			return $fileType;
		}
    }
    
    public function getFileUrlAttribute()
	{
        if ($this->documents) {
			return route('documenturl', base64_encode($this->documents));
		} else {
			return null;
		}
	}

    public function basicinfo()
    {
        return $this->belongsTo(BasicInfo::class, 'basic_info_id', 'id');
    }

    public function delete(){
        Storage::disk('uploads')->delete($this->documents);
        
        return parent::delete();

    }

}
