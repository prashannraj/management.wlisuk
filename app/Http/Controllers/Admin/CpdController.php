<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CpdDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCpdRequest;
use App\Http\Requests\UpdateCpdRequest;
use App\Models\Cpd;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\Advisor;
use App\Models\CompanyInfo;
use Response;

class CpdController extends AppBaseController
{
    /**
     * Display a listing of the Cpd.
     *
     * @param CpdDataTable $cpdDataTable
     * @return Response
     */
    public function index(CpdDataTable $cpdDataTable)
    {
        return $cpdDataTable->render('cpds.index');
    }

    /**
     * Show the form for creating a new Cpd.
     *
     * @return Response
     */
    public function create()
    {
        $data['advisors'] = Advisor::active()->get()->pluck('name', 'id');
        $data['company'] = CompanyInfo::first();
        return view('cpds.create', compact('data'));
    }

    /**
     * Store a newly created Cpd in storage.
     *
     * @param CreateCpdRequest $request
     *
     * @return Response
     */
    public function store(CreateCpdRequest $request)
    {
        $input = $request->all();

        /** @var Cpd $cpd */
        $cpd = Cpd::create($input);

        Flash::success('Cpd saved successfully.');

        return redirect(route('cpds.index'));
    }

    /**
     * Display the specified Cpd.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Cpd $cpd */
        $cpd = Cpd::find($id);

        if (empty($cpd)) {
            Flash::error('Cpd not found');

            return redirect(route('cpds.index'));
        }

        if (request()->download == "pdf") {
            $media = $cpd->pdf;
            if ($media) {
                return $media->toResponse(request());
            } else {
                Flash::error("Pdf has not been generated. Please generate one.");
            }
        }

        if (request()->preview == "pdf") {
            $media = $cpd->pdf;
            if ($media) {
                return response()->file($media->getPath());
            } else {
                Flash::error("Pdf has not been generated. Please generate one.");
            }
        }

        if (request()->generate == "pdf") {
            $cpd->generate();
            Flash::success("Successfully generated pdf file.");
            return redirect(route('cpds.show', $cpd->id));
            // return response()->file($cpd->pdf->getPath());
        }

        return view('cpds.show')->with('cpd', $cpd);
    }

    /**
     * Show the form for editing the specified Cpd.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $data['advisors'] = Advisor::active()->get()->pluck('name', 'id');
        $data['company'] = CompanyInfo::first();
        /** @var Cpd $cpd */
        $cpd = Cpd::find($id);

        if (empty($cpd)) {
            Flash::error('Cpd not found');

            return redirect(route('cpds.index'));
        }

        return view('cpds.edit', compact('data'))->with('cpd', $cpd);
    }

    /**
     * Update the specified Cpd in storage.
     *
     * @param  int              $id
     * @param UpdateCpdRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCpdRequest $request)
    {
        /** @var Cpd $cpd */
        $cpd = Cpd::find($id);

        if (empty($cpd)) {
            Flash::error('Cpd not found');

            return redirect(route('cpds.index'));
        }

        $cpd->fill($request->all());
        $cpd->save();

        Flash::success('Cpd updated successfully.');

        return redirect(route('cpds.index'));
    }

    /**
     * Remove the specified Cpd from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Cpd $cpd */
        $cpd = Cpd::find($id);

        if (empty($cpd)) {
            Flash::error('Cpd not found');

            return redirect(route('cpds.index'));
        }

        $cpd->delete();

        Flash::success('Cpd deleted successfully.');

        return redirect(route('cpds.index'));
    }
}
