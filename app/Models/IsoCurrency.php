<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class IsoCurrency extends Model
{
    //
    const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';
    //
    protected $table = 'iso_currencylists';
}
