<?php

namespace App\DataTables;

use App\ServiceProviders;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ServiceProviderDataTable extends DataTable
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
            ->addColumn('action', function ($row) {
                return view("admin.serviceprovider.action", compact('row'));
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\models\ServiceProviders $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ServiceProviders $model)
    {
    $query = $model->newQuery();

    // Check if company_name filter is set in the request
    if ($this->request()->has('company_name') && $this->request()->get('company_name') != '') {
        $company_name = $this->request()->get('company_name');
        $query->where('company_name', 'like', "%$company_name%"); // Adjusted filtering logic
    }

    // Check if regulated_by filter is set in the request
    if ($this->request()->has('regulated_by') && $this->request()->get('regulated_by') != '') {
        $regulated_by = $this->request()->get('regulated_by');
        $query->where('regulated_by', $regulated_by);
    }

    // Remove the default filter condition
    // $query->where('regulated_by', "SRA"); // Removed for no default filter

    return $query;
    }


    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
{
    return $this->builder()
        ->setTableId('serviceproviders-table')
        ->columns($this->getColumns())
        ->ajax(route('ajax.serviceprovider.index'))  // Use the correct AJAX route here
        ->minifiedAjax()
        ->dom('Bfrtip')
        ->orderBy(1)
        ->buttons(

            Button::make('create'),
            Button::make('reload'),
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
            Column::make('DT_RowIndex')->title("S/N")->searchable(false),
            Column::make('company_name'),
            Column::make('regulated_by'),
            // Column::make('main_contact'),
            // Column::make('contact_two'),
            // Column::make('email_one'),
            // Column::make('email_two'),
            // Column::make('main_tel'),
            // Column::make('address'),
            // Column::make('direct_contact'),
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
        return 'ServiceProvider_' . date('YmdHis');
    }
}
