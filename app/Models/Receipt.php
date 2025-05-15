<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use PDF;
class Receipt extends Model implements HasMedia
{

    use InteractsWithMedia;
    //
    protected $fillable = [
        'invoice_id',
        'amount_received',
        'remarks',
        'date',
        'iso_currency_id',
        'client_name',
        'address',
        'basic_info_id'
    ];

    protected $appends = ['receipt_no','amount_with_currency'];

    public function getReceiptNoAttribute(){
        return "WLIS0".$this->id;
    }


    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format(config('constant.date_format'));
    }


    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::createFromFormat(config('constant.date_format'), $value)->format('Y-m-d');
    }

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }


    public function currency(){
        return $this->belongsTo(IsoCurrency::class,'iso_currency_id');

    }


    public function getAmountWithCurrencyAttribute(){
        return optional($this->currency)->title ." ".$this->amount_received;
    }
    


    public function client(){
        return $this->belongsTo(BasicInfo::class,'basic_info_id');
    }

    public function generate(){
        $this->clearMediaCollection("pdf");
        $data  = array();
        $data['receipt'] = $this;
        $data['company_info'] = CompanyInfo::first();

        $pdf = PDF::loadView('admin.receipt.pdf_with_css', compact('data'));
        $filename = "Receipt-" . $data['receipt']->receipt_no . "-" . $data['receipt']->invoice->client_name ;
        $file_path = storage_path('app/temp/'). $filename.".pdf";
        $pdf->save($file_path);

        $this->addMedia($file_path)->toMediaCollection('pdf');
    }


    public function getPdfAttribute(){
        return $this->getFirstMedia('pdf');
    }
}
