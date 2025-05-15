<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    //
    protected $table = 'partners';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $dates = ['created', 'modified', 'contract_start', 'contract_end'];

    protected $fillable = [
        'institution_name', 'contract_holder', 'contract_type', 'contract_category',
        'contact_person', 'contactperson_position', 'contactperson_email', 'contact_number',
        'contactperson_two', 'contactperson_positiontwo', 'contactperson_emailtwo', 'contact_numbertwo',
        'contact_address',
        'agreement', 'status',
        'contract_start', 'contract_end', 'note',
        'iso_countrylist_id',
        'created_by',
        'modified_by'
    ];


    public static $rules = [
        'institution_name' => "required|string",
        'contract_holder' => "required|string",
        'contract_type' => "required|string",
        'contract_category' => "required|string",
        'contact_person' => "required|string",
        'contactperson_position' => "required|string",
        'contactperson_email' => "nullable|string",
        'contact_number' => "nullable|string",
        'contactperson_two' => "nullable|string",
        'contactperson_positiontwo' => "nullable|string",
        'contactperson_emailtwo' => "nullable|string",
        'contact_numbertwo' => "nullable|string",
        'contact_address' => "nullable|string",
        'agreement' => "nullable|string",
        'status' => "required|string",
        'contract_start' => "nullable|string",
        'contract_end' => "nullable|string",
        'note' => "nullable|string",
        'iso_countrylist_id' => "required|string",
    ];


    public function country()
    {
        return $this->belongsTo(IsoCountry::class, 'iso_countrylist_id');
    }


    public function getContractStartAttribute($value)
    {
        if ($value == null) return $value;
        $value = Carbon::parse($value);
        return $value->format(config('constant.date_format'));
    }

    public function setContractStartAttribute($value)
    {
        if ($value == null) {
            $this->attributes['contract_start'] = null;
        } else {

            $this->attributes['contract_start'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
        }
    }


    public function getContractEndAttribute($value)
    {
        if ($value == null) return $value;
        $value = Carbon::parse($value);

        return $value->format(config('constant.date_format'));
    }

    public function setContractEndAttribute($value)
    {
        if ($value == null) {
            $this->attributes['contract_end'] = null;
        } else {

            $this->attributes['contract_end'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
        }
    }


    public function applications(){
        return $this->hasMany(AdmissionApplication::class);
    }
}
