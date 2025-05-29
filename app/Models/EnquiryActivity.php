<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;

class EnquiryActivity extends Model
{
    //
    const CREATED_AT = 'created';
	const UPDATED_AT = 'modified';

	protected $table = 'enquiry_activities';
	
    protected $appends = ['status_attr', 'process_status', 'activity_created_by'];

    protected $fillable = [
    	'enquiry_list_id',
    	'note',
    	'processing',
    	'status',
    	'created_by',
    	'modified_by',
    	'created',
    	'modified'
	];

	public function enquiry(){
		return $this->belongsTo(Enquiry::class,'enquiry_list_id','id');
	}
	public function enquiryFollowup(){
		return $this->hasOne(EnquiryFollowUp::class,'enquiry_activity_id','id');
	}

	public function getStatusAttrAttribute()
	{
		$activity_status = Config::get('constant.ENQUIRY_STATUS');
		foreach($activity_status as $key => $st){
			if ($this->status == $key) {
				return $st;
			}
		}
	}
	
	public function getProcessStatusAttribute()
	{
			if ($this->status == 0) {
				return 'Not processed';
			}else{
				return 'Processed';
			}
	}

	public function getNoteAttribute($value)
	{
		if ($value == null) {
			return '';
		}else{
			return $value;
		}
	}

	public function getActivityCreatedByAttribute()
	{
		if ($this->created_by) {
			$user = User::find($this->created_by);
			return ucfirst($user->username);
		}else{
			return '';
		}
	}
}
