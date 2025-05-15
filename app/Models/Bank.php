<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    //
    protected $table = "banks";
    public $timestamps = false;


    protected $fillable = [
        'title',
        'account_number',
        'account_name',
        'swift_code_bic',
        'iso_countrylist_id',
        'iban',
        'sort_code',
        'branch_address',
        'account_ref',
        'status',
    ];

    public function country(){
        return $this->belongsTo("App\Models\IsoCountry",'iso_countrylist_id');
    }

// Rename this method to avoid confusion
public function formattedDetails()
{
    $detail = "Account Name: " . $this->account_name . "<br>";
    $detail .= "Bank Name: " . $this->title . "<br>";
    $detail .= "Account Number: " . $this->account_number . "<br>";
    $detail .= "Sort Code: " . $this->sort_code . "<br>";
    $detail .= "Branch Address: " . $this->branch_address . "<br>";
    $detail .= "IBAN: " . $this->iban . "<br>";
    $detail .= "Swift Code BIC: " . $this->swift_code_bic . "<br>";
    return $detail;
}

// If you have a BankDetail model, you can define a relationship like this
public function bankDetails() // Assuming you have a BankDetail model
{
    return $this->hasMany(BankDetail::class);
}
}
