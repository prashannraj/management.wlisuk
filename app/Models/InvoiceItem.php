<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    //
    protected $table="invoice_items";
    public $timestamps = false;

    protected $fillable = [
        'invoice_id',
        'quantity',
        'detail',
        'unit_price',
        'sub_total',
        'vat',
        'vat_amount',
    ];

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
}
