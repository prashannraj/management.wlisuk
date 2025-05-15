<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ServiceProviderDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;
use App\Models\IsoCountry;
use App\ServiceProviders;

class ServiceProviderController extends BaseController
{
    public function index(ServiceProviderDataTable $dataTable)
    {
        $serviceProviders = ServiceProviders::all(); // Fetch all service providers
        return $dataTable->render('admin.serviceprovider.index', compact('serviceProviders'));
    }

    public function ajaxIndex(Request $request)
    {
        // Start the query for ServiceProviders
        $query = ServiceProviders::query();

        // You can add filters if needed
        if ($request->company_name) {
            $query->where("company_name", "like", "%" . $request->company_name . "%");
        }

        // Return the data in DataTables format
        return datatables()->eloquent($query)->make(true);
    }



    public function show($id)
    {
        $data = array();
        $data['serviceproviders'] = ServiceProviders::findOrFail($id);

        $data['countries'] = IsoCountry::all();
        return view("admin.serviceprovider.show", compact('data'));
    }


    public function create()
    {
        $data = array();
        $data['countries'] = IsoCountry::all();
        $data['serviceproviders'] = new ServiceProviders;
        return view("admin.serviceprovider.create", compact('data'));
    }


    public function store(Request $request)
{
    // Validate the data
    $data = $this->validate($request, ServiceProviders::$rules);

    // Add created_by and modified_by
    $data['created_by'] = $data['modified_by'] = auth()->user()->id;

    // Handle main contact data
    if ($request->has('main_contact')) {
        $mainContacts = $request->input('main_contact');
    } else {
        $mainContacts = [];
    }

    // Create the service provider
    $serviceProvider = ServiceProviders::create($data);

    // Save Main Contact Data (if any)
    foreach ($mainContacts as $contact) {
        $serviceProvider->mainContacts()->create([
            'name' => $contact['name'],
            'phone' => $contact['phone'],
            'email' => $contact['email'],
        ]);
    }

    return redirect()->route("serviceprovider.index")->with("success", "Successfully created the service provider.");
}



    public function edit($id)
    {
        $data = array();
        $data['serviceproviders'] = ServiceProviders::findOrFail($id);

        $data['countries'] = IsoCountry::all();
        return view("admin.serviceprovider.edit", compact('data'));
    }


    public function update(Request $request, $id)
    {
        // Find the service provider
        $serviceprovider = ServiceProviders::findOrFail($id);

        // Validate the data
        $data = $this->validate($request, ServiceProviders::$rules);
        $data['created_by'] = $serviceprovider->created_by;
        $data['modified_by'] = auth()->user()->id;

        // Handle main contact data (if any)
        if ($request->has('main_contact')) {
            $mainContacts = $request->input('main_contact');
        } else {
            $mainContacts = [];
        }

        // Update the service provider details
        $serviceprovider->update($data);

        // Remove old main contacts if they exist and then save the new ones
        $serviceprovider->mainContacts()->delete();

        // Save each main contact (assuming there is a related table)
        foreach ($mainContacts as $contact) {
            $serviceprovider->mainContacts()->create([
                'name' => $contact['name'],
                'phone' => $contact['phone'],
                'email' => $contact['email'],
            ]);
        }

        return redirect()->route("serviceprovider.index")->with("success", "Successfully updated the service provider.");
    }




    public function destroy($id)
    {
        // Find the service provider by ID
        $serviceprovider = ServiceProviders::findOrFail($id);

        // Delete the service provider
        $serviceprovider->delete();

        // Redirect with a success message
        return redirect()->route("serviceprovider.index")->with("success", "Successfully deleted the service provider.");
    }


    public function toggle($id){
    	$serviceproviders = ServiceProviders::findOrFail($id);
    	$serviceproviders->status = strtolower($serviceproviders->reulated_by) == "active"?"Inactive":"Active";
    	$serviceproviders->save();
    	return redirect()->route("serviceprovider.index")->with("success","Successfully toggled the status of the serviceprovider");
    }
}
