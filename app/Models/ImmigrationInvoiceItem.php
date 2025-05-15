<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImmigrationInvoiceItem extends Model
{
    //
    protected $table="immigration_invoice_items";
    public $timestamps = false;

    protected $fillable =['immigration_invoice_id','quantity','detail','unit_price','sub_total','vat','vat_amount'];

}
