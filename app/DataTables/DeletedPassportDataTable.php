<?php

namespace App\DataTables;

use App\Models\BasicInfo;
use App\Models\PassportDetail;
use App\Models\Visa;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DeletedPassportDataTable extends DataTable
{
  /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()->eloquent($query)->addIndexColumn()
            ->addColumn('action', function ($row) {
                return view("admin.passport_detail.partials.datatable_action_with_delete", compact('row'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PassportDetail $model)
    {
        $query =  $model->newQuery()->select("*")->addSelect('passport_details.id as passport_id')->with("country")->has('country')->onlyTrashed();//('delete_at');
        $query = $this->filter($query);
        // dd($query->toSql());
        return $query;
    }

    public function filter($query)
    {
        if ($this->status != null) {
            switch ($this->status) {
                case "All":
        
                    return $query->withTrashed();
                case "Deleted":
                   
                    return $query->onlyTrashed();
                case "Not Deleted":
                    
                    return $query;
                default:
                    return $query->withTrashed();
            }
        }

        return $query->withTrashed();
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
            ->setTableId('deletepassports-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('delete.passports'), $js)
            ->dom('Bfrtip')
            ->orderBy(3)
            ->buttons(
                Button::make('pdf')->text('Export to PDF'),
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
            Column::make("passport_id"),
            Column::make('identification')->orderable("false")->searchable(false),

            Column::make("passport_number"),

            Column::make("country.title")->title("Country"),
            Column::make("deleted_at"),
         
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
        return 'clients_' . date('YmdHis');
    }

    public function pdf()
    {
        $data = $this->getDataForPrint();
        $title = "Clients report";
        if($this->startdate && $this->enddate){
        	$title.= " - {$this->startdate} to {$this->enddate}";
        }

        return PDF::loadView($this->printPreview,compact('data','title'))->download($this->getFilename() . '.pdf');
    //    return PDF::loadView($this->printPreview, compact('data','title'))->stream();
    }
}
