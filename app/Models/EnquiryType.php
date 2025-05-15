<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnquiryType extends Model
{
    //
    protected $table = 'enquiry_types';
    const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';

	public function enquiry(){
		 return $this->hasMany(Enquiry::class);
	}
}
