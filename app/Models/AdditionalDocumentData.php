<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdditionalDocumentData extends Model
{
    //
    protected $casts = [
        'content' => 'json',
    ];
    protected $fillable = ['content','basic_info_id','type'];

}
