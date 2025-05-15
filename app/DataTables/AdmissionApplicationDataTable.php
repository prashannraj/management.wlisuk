<?php

namespace App\DataTables;

use App\Models\AdmissionApplication;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdmissionApplicationDataTable extends DataTable
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
                return view("admin.application.admission.action",compact('row'));
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
     * @param \App\Models\AdmissionApplication $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AdmissionApplication $model)
    {
        $query = $model->newQuery()->with(['status','basicinfo','partner.country'])->latest();
        
        if($this->application_status_id){
            $query = $query->whereApplicationStatusId($this->application_status_id);
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
        return $this->builder()
                    ->setTableId('admissionapplication-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax(null, $js)
                    
                    
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
            Column::make("partner.country.title")->title("Country")->orderable(false)->searchable(false),

            Column::make("partner.institution_name")->title("Institution Name"),
            Column::make("course_start")->title("Course start date"),

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
    protected function filename()
    {
        return 'AdmissionApplication_' . date('YmdHis');
    }
}
