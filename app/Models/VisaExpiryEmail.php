<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisaExpiryEmail extends Model
{
    public $timestamps = true;
    //
    protected $fillable = ['communication_log_id','visa_id'];

    public function getStatusAttribute(){
        return "Expiry email last sent on ".$this->updated_at->format('d F Y h:i:s A');
    }
}
