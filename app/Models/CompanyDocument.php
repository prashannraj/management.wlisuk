<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// Client Document
use URL;

class CompanyDocument extends Model
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $table = "company_documents";
    protected $appends = ['file_type', 'file_url'];

    protected $fillable = [
        'ftype',
        'name',
        'note',
        'documents',
    ];

    public function getFileTypeAttribute()
	{
        $fileType = 'fa fa-eye text-default';
        if (!empty($this->document)) {
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
        if ($this->document) {
			return route('companydocumenturl', base64_encode($this->document));
		} else {
			return null;
		}
	}

    public function getDocumentPathAttribute(){
        return public_path("/uploads/company_documents/").$this->document;
    }
  

}
