<?php

namespace App\DataTables;

use App\Models\BasicInfo;
use App\Models\Visa;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use PDF;
use DB;

class VisaReportDataTable extends DataTable
{


    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()->eloquent($query)->addIndexColumn()
            ->addColumn('action', function ($row) {
                return view("admin.visa.partials.datatable_action", compact('row'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Visa $model)
    {
        $query =  Visa::query()->with('client')->with('expiry_email')->addSelect('*',DB::raw('current_visas.id as visa_id'));
        $query = $query->where('current_visas.status', 'Active');
        $query = $query->whereHas('client');
        // $query = $query->with('client');
        $query = $this->filter($query);
        return $query;
    }

    public function filter($query)
    {
        $q = $query;
        if ($this->visa_expiry != null) {
            switch ($this->visa_expiry) {
                case "6":

                    $q->where('expiry_date', '>=', Carbon::now())->where('expiry_date', '<=', Carbon::now()->addMonths(6));

                    break;
                case "3":

                    $q->where('expiry_date', '>=', Carbon::now())->where('expiry_date', '<=', Carbon::now()->addMonths(3));

                    break;
                case "1":

                    $q->where('expiry_date', '>=', Carbon::now())->where('expiry_date', '<=', Carbon::now()->addMonths(1));

                    break;
                case "1w":

                    $q->where('expiry_date', '>=', Carbon::now())->where('expiry_date', '<=', Carbon::now()->addWeeks(1));

                    break;
                case "0":

                    $q->where('expiry_date', '=', Carbon::now());

                    break;
                default:
                    break;
            }
        }


        if ($this->startdate && $this->enddate) {
            $start = Carbon::createFromFormat(config('constant.date_format'), $this->startdate);
            $end = Carbon::createFromFormat(config('constant.date_format'), $this->enddate);
            $q = $q->where('expiry_date', ">=", $start)->where('expiry_date', "<=", $end);
        }

        return $q;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $js = "data.visa_expiry = $('select[name=visa_expiry]').val();";
        $js .= "data.startdate = $('input[name=startdate]').val();
        data.enddate = $('input[name=enddate]').val();";
        return $this->builder()
            ->setTableId('visareport-table')
            ->columns($this->getColumns())
            ->minifiedAjax(null, $js)
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('pdf')->text('Export to PDF'),
                Button::make('csv')->text('Export to CSV'),

            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make("DT_RowIndex")->title("S/N")->searchable(false)->orderable(false),
            Column::make('client.full_name', 'client.f_name'),

            Column::make("visa_type"),

            Column::make("visa_number"),
            Column::make("expiry_date")->title("Expiry date"),
            Column::make('client.visa_followup_date')->searchable(false)->orderable(false)->title("Visa followup date"),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'clients_visas_' . date('YmdHis');
    }

    public function pdf()
    {
        $data = $this->getDataForPrint();
        $title = "Client Visa report";
        if ($this->startdate && $this->enddate) {
            $title .= " - {$this->startdate} to {$this->enddate}";
        }

        return PDF::loadView($this->printPreview, compact('data', 'title'))->download($this->getFilename() . '.pdf');
        //    return PDF::loadView($this->printPreview, compact('data','title'))->stream();
    }


}
