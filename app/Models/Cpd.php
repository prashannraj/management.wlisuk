<?php

namespace App\Models;

use Carbon\Carbon;
// use Collective\Html\Eloquent\FormAccessible;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class Cpd
 * @package App\Models
 * @version May 24, 2021, 2:17 pm UTC
 *
 * @property integer $advisor_id
 * @property string $advisor_number
 * @property string $advisor_name
 * @property string $organization
 * @property string $organization_number
 * @property string $period_from
 * @property string $period_to
 * @property string $status
 */
 class Cpd extends Model implements HasMedia
{
    // use FormAccessible;
    use InteractsWithMedia;
    public $table = 'cpds';
    


    protected $appends = ['period_from_formatted','period_to_formatted'];

    public $fillable = [
        'advisor_id',
        'advisor_number',
        'advisor_name',
        'organization',
        'organization_number',
        'period_from',
        'period_to',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'advisor_id' => 'integer',
        'advisor_number' => 'string',
        'advisor_name' => 'string',
        'organization' => 'string',
        'organization_number' => 'string',
        'period_from' => 'date',
        'period_to' => 'date',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'advisor_id'=>"required",
        'advisor_number'=>"nullable",
        'advisor_name'=>"required",
        'organization'=>"required",
        'organization_number'=>"nullable",
        'period_from'=>"required",
        'period_to'=>"required",
        'status'=>'required'
    ];

    public function setPeriodFromAttribute($value)
    {
        $this->attributes['period_from'] = Carbon::createFromFormat(config('constant.cpd_date_format'), $value)->format('Y-m-d');
    }

    public function setPeriodToAttribute($value)
    {
        $this->attributes['period_to'] = Carbon::createFromFormat(config('constant.cpd_date_format'), $value)->format('Y-m-d');
    }


    public function getPeriodFromFormattedAttribute()
    {
        
        return Carbon::parse($this->period_from)->format(config('constant.cpd_date_format'));
    }


    public function getPeriodToFormattedAttribute()
    {
        
        return Carbon::parse($this->period_to)->format(config('constant.cpd_date_format'));
    }


    public function formPeriodFromAttribute()
    {
        
        return Carbon::parse($this->period_from)->format(config('constant.cpd_date_format'));
    }


    public function formPeriodToAttribute()
    {
        
        return Carbon::parse($this->period_to)->format(config('constant.cpd_date_format'));
    }

    public function details(){
        return $this->hasMany(CpdDetail::class,"cpd_id");
    }


    public function generate(){
        $data['cpd'] = $this;

        $this->clearMediaCollection("pdf");
        $data['company'] = CompanyInfo::first();
        $pdf = Pdf::loadView("cpds.pdf",compact('data'));
        $filename = "CPD Report";
        $file_path = storage_path('app/temp/'). $filename.".pdf";
        $pdf->save($file_path);

        $this->addMedia($file_path)->toMediaCollection('pdf');
    }

    public function getPdfAttribute(){
        return $this->getFirstMedia("pdf");
    }
}
