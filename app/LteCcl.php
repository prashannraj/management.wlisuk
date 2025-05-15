<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Servicefee;
use App\Models\Visa;

class LteCcl extends Model
{
    protected $fillable = ['discussion_date', 'visa_application_submitted', 'visa_type', 'tribunal_fee', 'vat', 'travel_fee', 'reappear_fee', 'discussion_details','advisor_id','enquiry_id','bank_id','servicefee_id','agreed_fee_currency_id','agreed_fee','date','full_address', 'additional_notes', 'full_name_with_title'];

    public function servicefee(){
        return $this->hasOne(Servicefee::class,'id','servicefee_id');
    }

    public function visa(){
        return $this->hasOne(Visa::class,'id','visa_id');
    }
}
