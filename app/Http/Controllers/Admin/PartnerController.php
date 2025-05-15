<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PartnerDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;
use App\Models\IsoCountry;
use App\Models\Partner;

class PartnerController extends BaseController
{
    public function index(PartnerDataTable $table,Request $request)
    {
        $countries = IsoCountry::all();
        return $table->with(['country_id' => $request->country_id, 'status' => $request->status])->render("admin.partner.index",compact('countries'));
    }


    public function ajaxIndex(Request $request)
    {
        $query = Partner::query()->select("id", "institution_name")->whereStatus("Active");
        if ($request->iso_countrylist_id) {
            $query->where("iso_countrylist_id", $request->iso_countrylist_id);
        } else {
            $query->limit(6);
        }

        return response()->json($query->get());
    }


    public function show($id)
    {
        $data = array();
        $data['partner'] = Partner::findOrFail($id);

        $data['countries'] = IsoCountry::all();
        return view("admin.partner.show", compact('data'));
    }


    public function create()
    {
        $data = array();
        $data['countries'] = IsoCountry::all();
        $data['partner'] = new Partner;
        return view("admin.partner.create", compact('data'));
    }


    public function store(Request $request)
    {
        $data = $this->validate($request, Partner::$rules);
        $data['created_by'] = $data['modified_by'] = auth()->user()->id;
        Partner::create($data);

        return redirect()->route("partner.index")->with("success", "Successfully created the partner");
    }

    public function edit($id)
    {
        $data = array();
        $data['partner'] = Partner::findOrFail($id);

        $data['countries'] = IsoCountry::all();
        return view("admin.partner.edit", compact('data'));
    }


    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);
        $data = $this->validate($request, Partner::$rules);
        $data['created_by'] = $partner->created_by;
        $data['modified_by'] = auth()->user()->id;
        $partner->update($data);

        return redirect()->route("partner.index")->with("success", "Successfully updated the partner");
    }


    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        if ($partner->applications()->count() > 0) {
            return redirect()->route("partner.index")->with("failed", "Delete applications associated with this partner first.");
        }
        $partner->delete();

        return redirect()->route("partner.index")->with("success", "Successfully deleted the partner");
    }
    
    public function toggle($id){
    	$partner = Partner::findOrFail($id);
    	$partner->status = strtolower($partner->status) == "active"?"Inactive":"Active";
    	$partner->save();
    	return redirect()->route("partner.index")->with("success","Successfully toggled the status of the partner");
    }
}
