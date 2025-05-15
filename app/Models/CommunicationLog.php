<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunicationLog extends Model
{
    //
    protected $fillable = ['to','description','email_content','basic_info_id','employee_id','enquiry_id'];
    protected $appends = ['client_name'];


    public function getClientNameAttribute(){
        if($this->client) {
            return $this->client->full_name;
        }
        	else if($this->to != null){
        		return $this->to;
        	}
        else{
            return "No client Name";
        }
    }
    
    public function client(){
        return $this->belongsTo("App\Models\BasicInfo",'basic_info_id');
    }
}
