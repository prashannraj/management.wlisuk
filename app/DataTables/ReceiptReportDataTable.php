<?php

namespace App\DataTables;

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
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptReportDataTable extends DataTable
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
    public function query(Receipt $model,Request $request)
    {
        $model = $model->query()->with(['invoice','currency']);
        if($this->startdate && $this->enddate){
            $start = Carbon::createFromFormat(config('constant.date_format'),$this->startdate);
            $end = Carbon::createFromFormat(config('constant.date_format'),$this->enddate);
            $model->where('date',">=",$start)->where('date',"<=",$end);
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
            ->setTableId('report-table-receipt')
            ->columns($this->getColumns())
            ->minifiedAjax(route('your.route.name'), $js)
            ->orderBy(1)
            ->buttons(
                    Button::make('pdf')->text('Export to PDF'),
                    Button::make('csv')->text('Export to CSV')
                )
                ->parameters([
                    'dom' => 'Bfrtip',
                    'responsive' => true,
                    'processing' => true,
                    'serverSide' => true,
                    'buttons' => ['copy', 'csv', 'excel', 'pdf', 'print'],
                ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make("DT_RowIndex")->title("S/N"),
            Column::make("date",'date')->title("Receipt Date"),

            Column::make("receipt_no",'id')->title("Receipt No"),
            Column::make("invoice.invoice_no",'invoice_id')->title("Invoice No"),
            Column::make("currency.title",'iso_currency_id')->title("Currency"),

			Column::make("amount_received")->title("Amount"),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Receipt Report_' . date('d-m-Y H:i');
    }


    public function pdf()
    {
        $data = $this->getDataForPrint();
        $title = "Receipt Report";

        return Pdf::loadView($this->printPreview,compact('data','title'))->download($this->getFilename() . '.pdf');
    //    return PDF::loadView($this->printPreview, compact('data','title'))->stream();
    }
}
