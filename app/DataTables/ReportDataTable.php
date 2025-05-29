<?php

namespace App\DataTables;

use App\Models\ImmigrationInvoice;
use App\Models\Invoice;
use App\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ReportDataTable extends DataTable
{

    protected string $excelWriter = 'Xls';



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
        ->addColumn('receipt_details', function ($row) {
            return $row->total - $row->balance;
        })
        ->addColumn('unit_price', function ($row) { // Use unit price
            return $row->unite_price;
        })
        ->addColumn('vat_rate', function ($row) { // Use vat_rate as VAT Rate
            return $row->vat_rate;
        })
        ->addColumn('vatamount', function ($row) {
            // Assuming you have a field for total and a VAT rate
            $vatRate = $row->vat_rate; // Assuming this is a percentage
            $total = $row->unite_price; // Assuming this is the total amount
            return ($total * $vatRate) / 100; // Calculate the VAT amount
        })
        ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Report $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Invoice $model)
    {
        $request = $this;
        $model = $model->query()->with(['receipts', 'currency']);
        if ($request->startdate && $request->enddate) {
            $start = Carbon::createFromFormat(config('constant.date_format'), $this->startdate);
            $end = Carbon::createFromFormat(config('constant.date_format'), $this->enddate);
            $model->where('date', ">=", $start)->where('date', "<=", $end);
        }
        if($request->outstanding_balance){
            $model->where('balance',$request->outstanding_balance);
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
                    data.enddate = $('input[name=enddate]').val();
                    data.outstanding_balance = $('select[name=outstanding_balance]').val();";
        // dd("lol");
        return $this->builder()
            ->setTableId('report-table-invoice')
            ->columns($this->getColumns())
            ->minifiedAjax('', $js)
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
            Column::make("date")->title("Invoice Date"),
            Column::make("client_name", 'client_name')->title("Client Name")->exportable(false),
            Column::make("invoice_no", 'id')->title("Invoice No"),
            Column::make("currency.title", 'iso_currencylist_id')->title("Currency"),
            Column::make("unit_price")->title("Sub Total"),
            Column::make("vat_rate")->title("Vat"),
            Column::make("vatamount")->title("Vat Amount"),
            Column::make("total")->title("Total Amount"),
            Column::make("receipts_list")->title("Receipts")->orderable(false)->searchable(false),

            Column::make("receipt_details")->title("Total Received")->orderable(false)->searchable(false),
            // Column::make("receipt_amounts")->title("Receipt Amounts")->orderable(false)->searchable(false),
            Column::make("balance")->title("Balance")->orderable(false)->searchable(false)
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'INVOICE/RECEIPT/BALANCE/VAT REPORT_' . date('d-m-Y H:i');
    }


    public function pdf()
    {
        $data = $this->getDataForPrint();
    $startDate = Carbon::createFromFormat(config('constant.date_format'), $this->startdate);
    $endDate = Carbon::createFromFormat(config('constant.date_format'), $this->enddate);
    $title = "INVOICE/RECEIPT/BALANCE/VAT REPORT ({$startDate->format('d-m-Y')} - {$endDate->format('d-m-Y')})";

        $pdf = PDF::loadView($this->printPreview, compact('data', 'title'));
    $pdf->setPaper('A4', 'landscape'); // Set the paper size and orientation
    $pdf->setOptions([
        'isRemoteEnabled' => true,
        'isPhpEnabled' => true,
        'isHtml5ParserEnabled' => true,
        'isFontSubsettingEnabled' => true,
        'repeat_table_header' => true,
        'border' => '1', // Set the border width to 1
        'borderColor' => '#000000', // Set the border color to black
    ]);
    return $pdf->download($this->getFilename() . '.pdf');
    //    return PDF::loadView($this->printPreview, compact('data','title'))->stream();
    }
}
