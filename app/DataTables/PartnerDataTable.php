<?php

namespace App\DataTables;

use App\Models\Partner;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PartnerDataTable extends DataTable
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
            ->addColumn('action', function ($row) {
                return view("admin.partner.action", compact('row'));
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\models\Partner $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Partner $model)
    {
        $query = $model->newQuery()->with('country');
        if ($this->country_id) {
            $query = $query->whereIsoCountrylistId($this->country_id);
        }

        if ($this->status) {
            $status = $this->status;
            $query->where('status',  $status);
        }else{
            $query = $query->whereStatus("Active");
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
        $js = "data.country_id = $('select[name=country_id]').val();";
        $js .= "data.status = $('input[name=status]').val();";
        return $this->builder()
            ->setTableId('partner-table')
            ->columns($this->getColumns())
            ->minifiedAjax('', $js)
            ->orderBy(1)
            ->buttons(
                Button::make('create'),
                Button::make('reload')
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
            Column::make('institution_name'),
            Column::make('country.title')->title("Country")->name("iso_countrylist_id"),
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
        return 'Partner_' . date('YmdHis');
    }
}
