<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'ftype',
    ];

    // ----------------------
    // ICON TYPE BASED ON ftype
    // ----------------------
    public function getFileTypeAttribute()
    {
        if (empty($this->documents)) {
            return 'fa fa-eye text-default';
        }

        return match ($this->ftype) {
            'image'    => 'fa fa-image text-info',
            'pdf'      => 'fa fa-file-pdf text-danger',
            'document' => 'fa fa-file-word text-success',
            default    => 'fa fa-eye text-default',
        };
    }

    // ----------------------
    // FILE URL (download/preview)
    // ----------------------
    public function getFileUrlAttribute()
    {
        // यदि documents = "/uploads/files/newccl/12345.pdf"
        return $this->documents
            ? asset(ltrim($this->documents, '/'))
            : null;
    }

    // ----------------------
    // RELATION
    // ----------------------
    public function basicinfo()
    {
        return $this->belongsTo(BasicInfo::class, 'basic_info_id', 'id');
    }

    // ----------------------
    // DELETE WITH FILE REMOVE
    // ----------------------
    public function delete()
    {
        $absolutePath = public_path($this->documents);

        if (file_exists($absolutePath)) {
            @unlink($absolutePath);
        }

        return parent::delete();
    }
}
