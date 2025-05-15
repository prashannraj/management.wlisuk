<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ClientsReportDataTable;
use App\DataTables\ImmigrationReportDataTable;
use App\DataTables\ReportDataTable;
use App\DataTables\ReceiptReportDataTable;
use App\DataTables\VisaReportDataTable;
use App\Models\Advisor;
use App\Models\CompanyDocument;
use App\Models\EmailSender;
use App\Models\EnquiryForm;
use App\Models\Invoice;
use App\Models\Receipt;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends BaseController
{
    //

    public function index(ReportDataTable $datatable, Request $request)
    {

        if ($request->ajax()) {
            // return $this->datatable($request);
        }
        $data['outstanding_balances'] = array_keys(Invoice::where('balance',">",0)->orderBy('balance')->get()->groupBy('balance')->toArray());
        // return view('admin.report.index');
        return $datatable->with(['startdate' => $request->startdate, 'enddate' => $request->enddate,
        'outstanding_balance' => $request->outstanding_balance
        ])->render('admin.report.index',compact('data'));
    }


    public function datatable($request)
    {
        $model = Invoice::query()->with(['receipts.currency', 'currency']);

        if ($request->startdate && $request->enddate) {

            $start = Carbon::createFromFormat(config('constant.date_format'), $request->startdate);
            $end = Carbon::createFromFormat(config('constant.date_format'), $request->enddate);

            $model->where('date', ">=", $start)->where('date', "<=", $end);
        }
        $query = $model;
        return datatables()
            ->of($query)
            ->addColumn('receipt_details', function ($row) {
                if ($row->receipts->count() > 0)
                    return view("admin.report.partials.receiptdetails", compact('row'));
                else {
                    return "";
                }
            })
            ->rawColumns(['receipt_no'])
            ->addIndexColumn()->make(true);
    }


    public function indexReceipt(ReceiptReportDataTable $datatable, Request $request)
    {

        if ($request->ajax()) {
            // return $this->receiptdatatable($request);
        }
        // return view('admin.report.index');
        return $datatable->with(['startdate' => $request->startdate, 'enddate' => $request->enddate])->render('admin.report.receiptindex');
    }


    public function receiptdatatable($request)
    {
        $model = Receipt::query()->with(['invoice', 'currency']);

        if ($request->startdate && $request->enddate) {

            $start = Carbon::createFromFormat(config('constant.date_format'), $request->startdate);
            $end = Carbon::createFromFormat(config('constant.date_format'), $request->enddate);

            $model->where('date', ">=", $start)->where('date', "<=", $end);
        }
        $query = $model;
        return datatables()
            ->of($query)
            ->addIndexColumn()->make(true);
    }


    public function indexImmigration(ImmigrationReportDataTable $datatable, Request $request)
    {

        if ($request->ajax()) {
            // return $this->receiptdatatable($request);
        }
        // return view('admin.report.index');
        return $datatable->with(['startdate' => $request->startdate, 'enddate' => $request->enddate])->render('admin.report.immigrationindex');
    }

    public function indexClient(ClientsReportDataTable $datatable, Request $request)
    {

        if ($request->ajax()) {
            // return $this->receiptdatatable($request);
        }
        // return view('admin.report.index');
        return $datatable->with(['visa_expiry' => $request->visa_expiry])->render('admin.report.clientsreport');
    }


    public function indexVisa(VisaReportDataTable $datatable, Request $request)
    {

        $data['templates'] = Template::all();
        $data['senders'] = Advisor::active()->get();
        $data['forms'] = EnquiryForm::whereStatus('Active')->get();
        $data['documents'] = CompanyDocument::all();
        // return view('admin.report.index');
        return $datatable->with(['visa_expiry' => $request->visa_expiry, 'startdate' => $request->startdate, 'enddate' => $request->enddate])->render('admin.report.visareport',compact('data'));
    }
}
