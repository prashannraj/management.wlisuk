<?php

namespace App\DataTables;

use App\Models\ImmigrationInvoice;
use App\Models\Invoice;
use App\Models\RawInquiry;
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
use Barryvdh\DomPDF\Facade\Pdf;

class RawInquiryDataTable extends DataTable
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
            ->addIndexColumn()
            ->addColumn('action',function($row){
            return view('rawinquiry.partials.action',compact('row'));
            });

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Report $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(RawInquiry $model)
    {
        $request = $this;
        $model = $model->newQuery()->latest();
        if ($request->startdate && $request->enddate) {
            $start = Carbon::createFromFormat(config('constant.date_format'), $this->startdate);
            $end = Carbon::createFromFormat(config('constant.date_format'), $this->enddate);
            $model->where('updated_at', ">=", $start)->where('updated_at', "<=", $end);
        }


        if($request->status == "processed"){
            $model->whereHas("enquiry");
        }else{
            $model->whereDoesntHave("enquiry");
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
                    data.status = $('select[name=status]').val();";
        // dd("lol");
        return $this->builder()
            ->setTableId('rawinquiry-table')
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
            Column::make("DT_RowIndex")->title("S/N")->orderable(false)->searchable(false),
            // Column::make("created_at")->data("created_at_formatted")->title("Date created"),
            Column::make("form_id")->data('form_name')->title("Form Name"),
            Column::make("f_name")->data('full_name')->title("Full Name")->orderable(true)->searchable(true),
            Column::make("validated_at")->data('is_validated')->title("Validated")->orderable(true)->searchable(false),
            Column::make("action")->searchable(false)->orderable(false),

            // Column::make("receipt_amounts")->title("Receipt Amounts")->orderable(false)->searchable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Raw Enquiry' . date('d-m-Y H:i');
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
