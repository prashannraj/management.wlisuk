<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class NotificationDataTable extends DataTable
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
            ->addColumn('action', 'notificationdatatable.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query($model)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        return $user->notifications()->getQuery(); // Corrected line for Intelephense
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('notification-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->buttons(
                Button::make('csv')->text('Export to CSV'),
                Button::make('pdf')->text('Export to PDF')
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
            Column::make('DT_RowIndex')->title("S/N")->searchable(false),
            Column::make('data'),
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
    protected function filename(): string
    {
        return 'Notification_' . date('YmdHis');
    }
}
