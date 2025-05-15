<?php

namespace App\Imports;

use App\ApplicantPayslip;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Str;
class ApplicantPayslipsImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    function __construct($d){
        $this->id = $d;
    }
    protected $id;
    public function model(array $row)
    {
        // dd($row);
        return new ApplicantPayslip([
            //
            'date'=>$this->formatDate($row['date']),
            'bank_date'=>$this->formatDate($row['bank_date']),
            'employment_info_id'=>$this->id,
            'gross_pay'=>$row['gross_pay'],
            'net_pay'=>$row['net_pay'],
            'proof_sent'=>$row['proof_sent'],
            'note'=>$row['note']
        ]);
    }


    public function rules(): array{
        return [
            'date'=>'required',
            'bank_date'=>'required',
            'gross_pay'=>'required',
            'net_pay'=>'required',
            'proof_sent'=>'required',
            'note'=>'nullable'
        ];
    }

    public function formatDate($p){
        if (Str::contains($p, '/')) return $p;
        return Date::excelToDateTimeObject($p)->format(config('constant.date_format'));

    }
}
