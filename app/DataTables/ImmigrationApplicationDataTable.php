<?php

namespace App\DataTables;

use App\Models\ImmigrationApplication;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;

use Yajra\DataTables\Services\DataTable;

class ImmigrationApplicationDataTable extends DataTable
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
            ->addColumn('action', function($row){
                return view("admin.application.immigration.action",compact('row'));
            })->addColumn('client',function($row){
                if($row->client){
                    return $row->client->full_name;
                }
                return "-";
            })            
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ImmigrationApplication $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ImmigrationApplication $model)
    {
        $query = $model->newQuery()->with(['status','basicinfo'])->latest();
        
        if($this->application_status_id){
            $query = $query->whereApplicationStatusId($this->application_status_id);
        }

        if($this->status){
            $query = $query->whereStatus($this->status);
        }

        if($this->startdate && $this->enddate){
            $start = Carbon::createFromFormat(config('constant.date_format'),$this->startdate);
            $end = Carbon::createFromFormat(config('constant.date_format'),$this->enddate);
            $query->where('file_opening_date',">=",$start)->where('file_opening_date',"<=",$end);
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
        $js = "data.application_status_id = $('select[name=application_status_id]').val();";
        $js .= "data.startdate = $('input[name=startdate]').val();
        data.enddate = $('input[name=enddate]').val();";
        $js .= "data.status = $('input[name=status]').val();";
        return $this->builder()
                    ->setTableId('immigrationapplication-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax('', $js)
                    
                    
                    ->orderBy(1);
                   
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title("S/N")->searchable(false)->orderable(false),
            Column::make("student_name")->title("Name"),
            Column::make("status.title")->title("Status"),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
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
        return 'ImmigrationApplication_' . date('YmdHis');
    }
}
