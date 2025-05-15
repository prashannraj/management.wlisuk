<?php

namespace App\Models;

use App\Models\InvoiceItem;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    protected $table = "invoices";
    public $timestamps = false;
    protected $appends = ['invoice_no', 'invoice_type', 'total_with_currency', 'balance_with_currency', 'currency_title', 'receipts_list'];
    protected $dates = ['date', 'payment_due_by'];

    protected $fillable =  [
        'client_name', 'address', 'basic_info_id', 'invoice_type_id', 'iso_currencylist_id', 'bank_id', 'date', 'payment_due_by', 'date', 'note', 'remarks', 'vat',
    'vatamount', 'unit_price'    ];

    public function getUnitePriceAttribute()
    {
        $total = 0;
        if ($this->invoice_items == null) return 0;
        foreach ($this->invoice_items as $item) {
            $total += $item->unit_price;
        }

        return $total;
    }

    public function getCalculatedTotalAttribute()
    {
        $total = 0;
        if ($this->invoice_items == null) return 0;
        foreach ($this->invoice_items as $item) {
            $total += $item->sub_total;
        }

        return $total;
    }

    // Add accessor for vat_rate and vatamount
    public function getVatRateAttribute()
    {
        $vat = 0;
        foreach ($this->invoice_items as $item) {
            $vat += $item->vat;
        }
        return $vat;
    }

    public function getVatamountAttribute()
    {
        $vatAmount = 0;
        foreach ($this->invoice_items as $item) {
            $vatAmount += $item->vatamount;
        }
        return $vatAmount;
    }

    public function getReceiptsListAttribute()
    {
        $t = "";
        foreach ($this->receipts as $rec) {
            $t .= $rec->receipt_no . ", ";
        }
        return $t;
    }


    public function getCalculatedBalanceAttribute()
    {
        $total = $this->calculated_total;
        foreach ($this->receipts as $item) {
            $total -= $item->amount_received;
        }

        return $total;
    }

    public function getCalculatedTotalWithCurrencyAttribute()
    {

        return optional($this->currency)->title . " " . $this->calculated_total;
    }

    public function getCalculatedBalanceWithCurrencyAttribute()
    {
        if ($this->currency)
            return $this->currency->title . " " . $this->calculated_balance;

        return $this->calculated_balance;
    }


    public function getTotalWithCurrencyAttribute()
    {

        return optional($this->currency)->title . " " . $this->total;
    }

    public function getBalanceWithCurrencyAttribute()
    {
        if ($this->currency)
            return $this->currency->title . " " . $this->balance;

        return $this->balance;
    }

    public function bank()
    {
        return $this->belongsTo("App\Models\Bank");
    }

    public function getInvoiceNoAttribute()
    {
        return strtoupper(substr($this->type->title, 0, 3)) . "0" . $this->id;
    }

    public function getInvoiceTypeAttribute()
    {
        return optional($this->type)->title;
    }

    public function getCurrencyTitleAttribute()
    {
        return optional($this->currency)->title;
    }

    public function type()
    {
        return $this->belongsTo("App\Models\InvoiceType", 'invoice_type_id');
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
        if ($value == null) return null;
        return Carbon::parse($value)->format(config('constant.date_format'));
    }

    public function currency()
    {
        return $this->belongsTo("App\Models\IsoCurrency", 'iso_currencylist_id');
    }

    public function client()
    {
        return $this->belongsTo("App\Models\BasicInfo", "basic_info_id");
    }

    public function invoice_items()
    {
    return $this->hasMany(InvoiceItem::class);
    }

    // public function invoice_items()
    // {
    //     return $this->hasMany(InvoiceItem::class, 'invoice_id');
    // }

    public function receipts()
    {
        return $this->hasMany(Receipt::class, 'invoice_id');
    }


    public function recalculateTotals()
    {
        $this->total = $this->calculated_total;
        $this->balance = $this->calculated_balance;
        $this->save();
    }
}
