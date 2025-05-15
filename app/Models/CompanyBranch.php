<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyBranch extends Model
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    protected $table = 'company_branches';

    protected $appends = ['logo_url','stamp_url'];

	protected $fillable=['name','address','registration_no','website','logo','stamp','telephone','email'];
	
	public function getLogoUrlAttribute(){
		return "/uploads/images/".($this->logo==null?"placeholder.png":$this->logo);
	}
	
	public function getStampUrlAttribute(){
		return "/uploads/images/".($this->stamp==null?"placeholder.png":$this->stamp);

	}
}
