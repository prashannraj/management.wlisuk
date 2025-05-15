<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ImmigrationInvoice extends Model
{
    //
    protected $table = "immigration_invoices";
    public $timestamps = false;
    protected $appends = ['invoice_no', 'invoice_type', 'total'];
    protected $dates = ['date', 'payment_due_by'];


    public function getTotalAttribute()
    {
        $total = 0;
        if ($this->invoice_items == null) return 0;
        foreach ($this->invoice_items as $item) {
            $total += $item->sub_total;
        }

        return $total;
    }

    public function getInvoiceNoAttribute()
    {
        return $this->payment_reference;
    }

    public function bank()
    {
        return $this->belongsTo("App\Models\Bank");
    }

    
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
    }

    public function setPaymentDueByAttribute($value)
    {
        if ($value == null) {
            $this->attributes['payment_due_by'] = null;
        } else {

            $this->attributes['payment_due_by'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
        }
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format(config('constant.date_format'));
    }

    public function getPaymentDueByAttribute($value)
    {
        if($value == null) return null;
        return Carbon::parse($value)->format(config('constant.date_format'));
    }

    public function currency()
    {
        return $this->belongsTo("App\Models\IsoCurrency", 'iso_currencylist_id');
    }

   
    public function invoice_items()
    {
        return $this->hasMany(ImmigrationInvoiceItem::class, 'immigration_invoice_id');
    }

   
}

