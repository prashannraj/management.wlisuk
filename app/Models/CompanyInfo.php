<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    protected $table = 'company_infos';

    protected $appends = ['logo_url','stamp_url','regulation_logo_url'];

	protected $fillable=['name','footnote','address','registration_no',
	'website','logo','stamp','telephone','email','registered_in','regulated_by','regulator_logo','regulation_no','vat'];
	
	public function getLogoUrlAttribute(){
		return "/uploads/images/".($this->logo==null?"placeholder.png":$this->logo);
	}
	
	
	public function getRegulatorLogoUrlAttribute(){
		return "/uploads/images/".($this->regulator_logo==null?"placeholder.png":$this->regulator_logo);
	}
	
	
	public function getStampUrlAttribute(){
		return "/uploads/images/".($this->stamp==null?"placeholder.png":$this->stamp);

	}
}
