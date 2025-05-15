<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DeletedClientsDataTable;
use App\DataTables\DeletedEmployeeDataTable;
use App\DataTables\DeletedPassportDataTable;
use App\DataTables\DeletedVisaDataTable;
use App\Models\Advisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeleteController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(
        DeletedClientsDataTable $deletedClientsDataTable,
        DeletedEmployeeDataTable $deletedEmployeeDataTable,
        DeletedPassportDataTable $deletedPassportDataTable,
        DeletedVisaDataTable $deletedVisaDataTable
    ) {
        $data['deletedClientsDatatable'] = $deletedClientsDataTable->html();
        $data['deletedEmployeeDataTable'] = $deletedEmployeeDataTable->html();
        $data['deletedPassportDatatable'] = $deletedPassportDataTable->html();
        $data['deletedVisaDataTable'] = $deletedVisaDataTable->html();

        // dd($deletedClientsDataTable->html()->getTableAttributes()['id']);
        return view('admin.delete.index',compact('data'));
    }


    public function clients(DeletedClientsDataTable $dataTable)
    {
        //

        return $dataTable->with(['status' => request()->status])->render('admin.delete.clients');
    }


    public function employees(DeletedEmployeeDataTable $dataTable)
    {
        //

        return $dataTable->with(['status' => request()->status])->render('admin.delete.employees');
    }

    public function visas(DeletedVisaDataTable $dataTable)
    {
        //

        return $dataTable->with(['status' => request()->status])->render('admin.delete.visas');
    }

    public function passports(DeletedPassportDataTable $dataTable)
    {
        //

        return $dataTable->with(['status' => request()->status])->render('admin.delete.passports');
    }
}
