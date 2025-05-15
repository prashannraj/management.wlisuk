<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceType extends Model
{
    //
    protected $table ="invoice_types";
    
    
    
   
    
    public function invoices(){
    	return $this->hasMany("App\Models\Invoice");
    }
}
