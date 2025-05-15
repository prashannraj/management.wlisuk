<?php

namespace App\Imports;

use App\Models\CpdDetail;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Throwable;
use Str;
use Flash;

class CpdDetailImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected $cpd_id;

    function __construct($cpd_id)
    {
        $this->cpd_id = $cpd_id;
    }

    public function model(array $row)
    {

        //dd($row);
        
        return new CpdDetail([
            //
            'what' => $row['what_did_you_learn'],
            'date' => $this->formatDate($row['date_of_completion']),
            'why' => $row['why_did_you_do_this_learning'],
            'complete_objective' => $row['did_you_meet_your_objectives'],
            'apply_learning' => $row['how_will_you_apply_this_learning'],
            'cpd_id' => $this->cpd_id,
        ]);
    }


    public function rules(): array
    {
        return [
            'date_of_completion'=>"required",
            'what_did_you_learn' => 'required',
            'why_did_you_do_this_learning' => 'required',
            'did_you_meet_your_objectives' => 'required',
            'how_will_you_apply_this_learning' => 'required',
        ];
    }

    public function onError(Throwable $e)
    {
        //    return back()->withError($e->message);
        //Flash::error("Error occured: " . $e->getMessage());
    }

    

    public function formatDate($p)
    {
        if (Str::contains($p, '/')) return $p;
        return Date::excelToDateTimeObject($p)->format(config('constant.date_format'));
    }
}
