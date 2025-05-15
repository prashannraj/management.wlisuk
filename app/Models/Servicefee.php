<?php

namespace App\Models;

use App\Models\IsoCurrency;
use Illuminate\Database\Eloquent\Model;

class Servicefee extends Model
{
    //
    protected $fillable  = [
        'category',
        'name',
        'net',
        'vat',
        'iso_currency_id',
        'note',
        'status',
        'total'
    ];

    public function currency(){
        return $this->belongsTo(IsoCurrency::class,'iso_currency_id');
    }
}
