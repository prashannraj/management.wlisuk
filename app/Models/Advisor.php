<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Advisor extends Model
{
    protected $appends = ['signature_url'];
    //
    protected $fillable = [
        'category',
        'name',
        'level',
        'contact',
        'email',
        'signature',
        'status'
    ];


    public function getSignatureUrlAttribute(){
        if ($this->signature) {
			return "/uploads/files/".$this->signature;
		} else {
			return null;
		}
    }

    public function delete(){
        Storage::disk('uploads')->delete($this->signature);
        return parent::delete();
    }

    public function scopeActive($query){
        return $query->whereStatus('Active');
    }
}
