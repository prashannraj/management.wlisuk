<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Servicefee;

class CclApplication extends Model
{
    //
    protected $fillable = ['discussion_details','advisor_id','enquiry_id','bank_id','servicefee_id','agreed_fee_currency_id','agreed_fee','date','full_address','added_names_input', 'additional_notes', 'full_name_with_title'];

    public function servicefee(){
        return $this->hasOne(Servicefee::class,'id','servicefee_id');
    }

}
