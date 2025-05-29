<?php

namespace App\DataTables;

use App\Models\Servicefee;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ServicefeeDataTable extends DataTable
{
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
            ->addColumn('action', 'admin.servicefee.action')->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Servicefee $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Servicefee $model)
    {
        $query =  $model->newQuery()->with("currency");
        if($this->status!= null){
            $query = $query->where('status',$this->status);
        }
        else{
            $query->where('status',true);
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
        $js = "data.status = $('select[name=status]').val();";
        return $this->builder()
                    ->setTableId('servicefee-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax('',$js)
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
           
            Column::make('DT_RowIndex')->title("S/N")->orderable(false)->searchable(false),
            Column::make('name'),

            Column::make('category'),
            Column::make('net'),
            Column::make('vat'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Servicefee_' . date('YmdHis');
    }
}
