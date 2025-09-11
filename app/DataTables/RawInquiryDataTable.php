<?php

namespace App\DataTables;

use App\Models\RawInquiry;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Barryvdh\DomPDF\Facade\Pdf;

class RawInquiryDataTable extends DataTable
{
    public $startdate;
    public $enddate;
    public $status;

    /**
     * Assign filter parameters.
     */
    public function withFilters(array $params)
    {
        $this->startdate = $params['startdate'] ?? null;
        $this->enddate = $params['enddate'] ?? null;
        $this->status = $params['status'] ?? null;
        return $this;
    }

    /**
     * Build DataTable.
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return view('rawinquiry.partials.action', compact('row'))->render();
            });
    }

    /**
     * Query for datatable.
     */
    public function query(RawInquiry $model)
    {
        $query = $model->newQuery()->latest();

        if ($this->startdate && $this->enddate) {
            $start = Carbon::parse($this->startdate)->startOfDay();
            $end = Carbon::parse($this->enddate)->endOfDay();
            $query->whereBetween('updated_at', [$start, $end]);
        }

        if ($this->status === 'processed') {
            $query->whereHas('enquiry');
        } elseif ($this->status === 'not_processed') {
            $query->whereDoesntHave('enquiry');
        }

        return $query;
    }

    /**
     * HTML builder.
     */
    public function html()
    {
        $js = "data.startdate = $('input[name=startdate]').val();
               data.enddate = $('input[name=enddate]').val();
               data.status = $('select[name=status]').val();";

        return $this->builder()
            ->setTableId('rawinquiry-table')
            ->columns($this->getColumns())
            ->minifiedAjax('', $js)
            ->parameters([
                'dom' => 'Bfrtip',
                'order' => [[1, 'desc']],
                'buttons' => ['copy', 'csv', 'excel', 'pdf', 'print'],
            ]);
    }

    /**
     * Columns.
     */
    protected function getColumns()
    {
        return [
            Column::computed('DT_RowIndex')->title('S/N')->orderable(false)->searchable(false),
            Column::make('form_id')->data('form_name')->title('Form Name'),
            Column::make('f_name')->title('Full Name'),
            Column::make('validated_at')->title('Validated'),
            Column::computed('action')->title('Actions')->searchable(false)->orderable(false),
        ];
    }

    /**
     * Filename for export.
     */
    protected function filename(): string
    {
        return 'Raw_Enquiry_' . now()->format('Y-m-d_H-i-s');
    }

    /**
     * PDF export.
     */
    public function pdf()
    {
        $data = $this->getDataForPrint();
        $title = "Raw Inquiry Report (" . ($this->startdate ?? 'All') . " - " . ($this->enddate ?? 'All') . ")";
        $pdf = Pdf::loadView('rawinquiry.export.pdf', compact('data', 'title'))
                  ->setPaper('A4', 'landscape');
        return $pdf->download($this->filename() . '.pdf');
    }
}
