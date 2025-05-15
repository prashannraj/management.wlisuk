<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnquiryForm extends Model
{
    //
    protected $fillable = [ 'title',
    'name',
    'description','uuid','status','type'];

    public function getFormUrlAttribute(){
        return route('enquiryform.display',$this->uuid);
    }

    public function getLinkAttribute(){
        return $this->form_url;
    }
}
