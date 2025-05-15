<?php

namespace App\DataTables;

use App\Models\ImmigrationApplication;
use App\Models\ImmigrationInvoice;
use App\Models\Receipt;
use App\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use PDF;

class ImmigrationReportDataTable extends DataTable
{

    protected $excelWriter = 'Xls';

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn();
            
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Report $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ImmigrationApplication $model,Request $request)
    {
        $model = $model->query()->with(['client','status']);
        if($this->startdate && $this->enddate){
            $start = Carbon::createFromFormat(config('constant.date_format'),$this->startdate);
            $end = Carbon::createFromFormat(config('constant.date_format'),$this->enddate);
            $model->where('file_opening_date',">=",$start)->where('file_opening_date',"<=",$end);
        }
        return $model;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
    	$js = "data.startdate = $('input[name=startdate]').val();
                    data.enddate = $('input[name=enddate]').val();";
        // dd("lol");
        return $this->builder()
            ->setTableId('immigration-table-receipt')
            ->columns($this->getColumns())
            ->minifiedAjax(null,$js)
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
               [ Button::make('pdf')->text('Export to PDF'),Button::make('csv')->text('Export to CSV')]
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
            Column::make("student_name",'student_name')->title("Client Full Name"),

            Column::make("client.status")->title("Client Status"),
            Column::make("application_detail")->title("Application"),
            Column::make("date_submitted_formatted",'date_submitted')->title("Application date"),
            Column::make("status.title")->title("Application status"),
            Column::make("sub_reason")->title("Application sub reason")->orderable(false)->searchable(false),
            Column::make("file_opening_date_formatted",'file_opening_date')->title("File opening date"),
            Column::make("closure_date")->title("Closure date")->orderable(false)->searchable(false),

            // Column::make("invoice.invoice_no",'invoice_id')->title("Invoice No"),
            // Column::make("currency.title",'iso_currency_id')->title("Currency"),

			// Column::make("amount_received")->title("Amount"),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'OISC-Report-' . date('d-m-Y H:i');
    }


    public function pdf()
    {
        $data = $this->getDataForPrint();
        $title = "Immigration clients report";
        if($this->startdate && $this->enddate){
        	$title.= " - {$this->startdate} to {$this->enddate}";
        }

        return PDF::loadView($this->printPreview,compact('data','title'))->download($this->getFilename() . '.pdf');
    //    return PDF::loadView($this->printPreview, compact('data','title'))->stream();
    }
}
