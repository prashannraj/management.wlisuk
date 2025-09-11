<?php

namespace App\Models;

use App\ClientCare;
use App\CclApplication;
use App\LetterOfAuthority;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;


class Enquiry extends Model
{
    const CREATED_AT = 'created';
	const UPDATED_AT = 'modified';


    protected $table = 'enquiry_lists';
    protected $appends = ['enquiry_type','full_name','m_code','t_code'];

    protected $fillable = [
		'title',
		'first_name',
		'surname',
		'middle_name',
		'mobile',
		'email',
		'enquiry_type_id',
		'referral',
		'instruction',
		'note',
		'enquiry_assigned_to',
		'country_mobile',
		'country_tel','latest_status','status',
		'surname',
		'status',
		'raw_enquiry_id',
		'modified_by',
		'department_id'
	];

	public function getAll()
    {
        return static::all();
	}

    public function findEnquiry($id)
    {
        return static::find($id);
	}

    public function deleteEnquiry($id)
    {
        return static::find($id)->delete();
	}

    public function type(){
		return $this->belongsTo(EnquiryType::class,'enquiry_type_id');
	}

	public function activities(){
		return $this->hasMany(EnquiryActivity::class,'enquiry_list_id','id') ?? collect();
	}

	public function studentContactDetail(){
		return $this->hasOne(StudentContactDetail::class,'enquiry_list_id','id');
	}

	public function getFullNameAttribute()
	{
		return $this->first_name . ' '.$this->middle_name.' ' . $this->surname;
	}

	public function getFullNameWithTitleAttribute()
	{
		return $this->title . ". " . $this->first_name . ' ' . $this->surname;
	}

	public function getEnquiryTypeAttribute()
	{
		$colors = Config::get('colors');

		return ($this->type && array_key_exists($this->type['id'], $colors))
				?
				'<p class="text-white text-center w-100 '. $colors[$this->type['id']] .'">' . $this->type['title']. '</p>'
				:$this->type['title'];
	}

	public function basicinfo(){
		return $this->belongsTo(BasicInfo::class,'id','enquiry_list_id');
	}

	public function client(){
		return $this->belongsTo(BasicInfo::class,'client_id');
	}


	public function mobilecode()
    {
        return $this->belongsTo(IsoCountry::class, 'country_mobile');
    }


    public function telcode()
    {
        return $this->belongsTo(IsoCountry::class, 'country_tel');
    }

       public function getMCodeAttribute()
    {
        return optional($this->mobilecode)->calling_code ?? '';
    }

    public function getTCodeAttribute()
    {
        return optional($this->telcode)->calling_code ?? '';
    }


	public function clientcare(){
		return $this->belongsTo(ClientCare::class,'id','enquiry_id');
	}

    public function cclapplication()
{
    return $this->hasOne(CclApplication::class, 'enquiry_id', 'id'); // Adjust the foreign key and local key as necessary
}

	public function assigned_user(){
		return $this->belongsTo(User::class,'enquiry_assigned_to');
	}


	public function delete(){
		if($this->clientcare) $this->clientcare->delete();

		if($this->studentContactDetail) $this->studentContactDetail->delete();

		foreach($this->activities as $activity) $activity->delete();

		return parent::delete();
	}

	public function addresses(){
		return $this->hasMany(ClientAddressDetail::class,'enquiry_id','id');
	}

	public function address(){
		return $this->hasOne(ClientAddressDetail::class,'enquiry_id','id');
	}


	public function communicationlogs(){
		return $this->hasMany(CommunicationLog::class,'enquiry_id','id');
	}

	public function documents(){
		return $this->hasMany(Document::class,'enquiry_id','id');
	}

    public function rawInquiry()
    {
        return $this->belongsTo(RawInquiry::class);
    }

}
