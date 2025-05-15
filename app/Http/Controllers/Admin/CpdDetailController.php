<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CpdDetailDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCpdDetailRequest;
use App\Http\Requests\UpdateCpdDetailRequest;
use App\Models\CpdDetail;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Imports\CpdDetailImport;
use App\Models\Cpd;
use Illuminate\Http\Request;
use Response;

class CpdDetailController extends AppBaseController
{
    /**
     * Display a listing of the CpdDetail.
     *
     * @param CpdDetailDataTable $cpdDetailDataTable
     * @return Response
     */
    public function index(CpdDetailDataTable $cpdDetailDataTable)
    {
        return $cpdDetailDataTable->render('cpd_details.index');
    }

    /**
     * Show the form for creating a new CpdDetail.
     *
     * @return Response
     */
    public function create()
    {
        return view('cpd_details.create');
    }

    /**
     * Store a newly created CpdDetail in storage.
     *
     * @param CreateCpdDetailRequest $request
     *
     * @return Response
     */
    public function store(CreateCpdDetailRequest $request)
    {
        $input = $request->all();

        /** @var CpdDetail $cpdDetail */
        $cpdDetail = CpdDetail::create($input);

        Flash::success('Cpd Detail saved successfully.');

        return redirect(route('cpds.show', $cpdDetail->cpd_id));
    }

    /**
     * Display the specified CpdDetail.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CpdDetail $cpdDetail */
        $cpdDetail = CpdDetail::find($id);

        if (empty($cpdDetail)) {
            Flash::error('Cpd Detail not found');

            return redirect(route('cpdDetails.index'));
        }

        return view('cpd_details.show')->with('cpdDetail', $cpdDetail);
    }

    /**
     * Show the form for editing the specified CpdDetail.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var CpdDetail $cpdDetail */
        $cpdDetail = CpdDetail::find($id);

        if (empty($cpdDetail)) {
            Flash::error('Cpd Detail not found');

            return redirect(route('cpdDetails.index'));
        }

        return view('cpd_details.edit')->with('cpdDetail', $cpdDetail);
    }

    /**
     * Update the specified CpdDetail in storage.
     *
     * @param  int              $id
     * @param UpdateCpdDetailRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCpdDetailRequest $request)
    {
        /** @var CpdDetail $cpdDetail */
        if ($id == "_") {
            $id = $request->id;
        }
        $cpdDetail = CpdDetail::find($id);

        if (empty($cpdDetail)) {
            Flash::error('Cpd Detail not found');

            return redirect(route('cpdDetails.index'));
        }

        $cpdDetail->fill($request->all());
        $cpdDetail->save();

        Flash::success('Cpd Detail updated successfully.');

        return redirect(route('cpds.show', $cpdDetail->cpd_id));
    }

    /**
     * Remove the specified CpdDetail from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CpdDetail $cpdDetail */
        $cpdDetail = CpdDetail::find($id);

        if (empty($cpdDetail)) {
            Flash::error('Cpd Detail not found');

            return redirect(route('cpdDetails.index'));
        }

        $cpdDetail->delete();

        Flash::success('Cpd Detail deleted successfully.');

        return redirect(route('cpds.show', $cpdDetail->cpd_id));
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xlsx,csv,xls',
            'cpd_id' => 'required'
        ]);

        $cpd = Cpd::find($request->cpd_id);
        if ($cpd == null) {
            Flash::error("Error finding cpd");
            return redirect()->route('cpds.index');
        }
        $p = new CpdDetailImport($cpd->id);

        try {
            $p->import($request->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // $failures = $e->errors();
            dd($e);

            Flash::error("Error happened: check if all the fields are there");
            // return back()->withError("Error happened: ");
            return back();
        }

        Flash::success("Successfully imported.");
        return redirect()->route('cpds.show', $cpd->id);
    }
}
