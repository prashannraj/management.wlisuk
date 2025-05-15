<?php

namespace App\DataTables;

use App\Models\BasicInfo;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use PDF;
class ClientsReportDataTable extends DataTable
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
                return view("admin.client.partials.datatable_action", compact('row'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BasicInfo $model)
    {
        $query =  $model->newQuery();
        $query = $this->filter($query);
        return $query;
    }

    public function filter($query)
    {
        if ($this->visa_expiry != null) {
            switch ($this->visa_expiry) {
                case "6":
                    $query->whereHas('currentvisa', function ($q) {
                        $q->where('status', 'Active')->where('expiry_date', '>=', Carbon::now())->where('expiry_date', '<=', Carbon::now()->addMonths(6));
                    });
                    return $query;
                case "3":
                    $query->whereHas('currentvisa', function ($q) {
                        $q->where('status', 'Active')->where('expiry_date', '>=', Carbon::now())->where('expiry_date', '<=', Carbon::now()->addMonths(3));
                    });
                    return $query;
                case "1":
                    $query->whereHas('currentvisa', function ($q) {
                        $q->where('status', 'Active')->where('expiry_date', '>=', Carbon::now())->where('expiry_date', '<=', Carbon::now()->addMonths(1));
                    });
                    return $query;
                case "1w":
                    $query->whereHas('currentvisa', function ($q) {
                        $q->where('status', 'Active')->where('expiry_date', '>=', Carbon::now())->where('expiry_date', '<=', Carbon::now()->addWeeks(1));
                    });
                    return $query;
                case "0":
                    $query->whereHas('currentvisa', function ($q) {
                        $q->where('status', 'Active')->where('expiry_date', '=', Carbon::now());
                    });
                    return $query;
                default:
                    return $query;
            }
        }

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $js = "data.visa_expiry = $('select[name=visa_expiry]').val();";

        return $this->builder()
            ->setTableId('clientsreport-table')
            ->columns($this->getColumns())
            ->minifiedAjax(null, $js)
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('pdf')->text('Export to PDF'),
                Button::make('csv')->text('Export to CSV')
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
            Column::make('full_name', 'f_name'),
            Column::make('next_of_kin.name')->searchable(false)->orderable(false),
            Column::make('next_of_kin.relationship')->searchable(false)->orderable(false),
            Column::make('mobile_number')->searchable(false)->orderable(false),
            Column::make('email_address')->searchable(false)->orderable(false),
            Column::make('next_of_kin.contact_number')->searchable(false)->orderable(false),
            Column::make('next_of_kin.email')->searchable(false)->orderable(false),
            Column::make('visa_followup_date')->searchable(false)->orderable(false),
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
        return 'clients_' . date('YmdHis');
    }

    public function pdf()
    {
        $data = $this->getDataForPrint();
        $title = "Clients report";
        if($this->startdate && $this->enddate){
        	$title.= " - {$this->startdate} to {$this->enddate}";
        }

        return PDF::loadView($this->printPreview,compact('data','title'))->download($this->getFilename() . '.pdf');
    //    return PDF::loadView($this->printPreview, compact('data','title'))->stream();
    }
}
