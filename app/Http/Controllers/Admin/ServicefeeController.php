<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ServicefeeDataTable;
use App\Models\IsoCurrency;
use App\Models\Servicefee;
use Illuminate\Http\Request;

class ServicefeeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,ServicefeeDataTable $table)
    {
        //
        $data=array();
        $data['panel_name']= "Service Fee";
        // $data['servicefees'] = Servicefee::all();
        // print_r($request->status);exit;
        return $table->with(['status' => $request->status])->render('admin.servicefee.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data= array();
        $data['servicefee'] = new Servicefee;
        $data['currencies'] = IsoCurrency::all();
        return view('admin.servicefee.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $this->validate($request,[
            'category'=>"required",
            'name'=>"required",
            'net'=>"required|numeric",
            'vat'=>"nullable",
            'iso_currency_id'=>"required",
            'note'=>'nullable',
            'status'=>'required|boolean'
            ]);
        if($data['vat'] == null){
            $data['vat'] = 0;
        }
        $data['total']= (100+$data['vat'])/100 * $data['net'];

        Servicefee::create($data);

        return redirect()->route('servicefee.index')->with('success',"Successfully added a service fee");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = array();
        $data['row']= Servicefee::findOrFail($id);
        return view("admin.servicefee.show",compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = array();
        $servicefee = Servicefee::findOrFail($id);
        $data['servicefee']=$servicefee;
        $data['currencies']= IsoCurrency::all();

        return view('admin.servicefee.edit',compact("data"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $this->validate($request,[
            'category'=>"required",
            'name'=>"required",
            'net'=>"required|numeric",
            'vat'=>"nullable",
            'iso_currency_id'=>"required",
            'note'=>'nullable',
            'status'=>'required|boolean'
            ]);
        if($data['vat'] == null){
            $data['vat'] = 0;
        }
        $data['total']= (100+$data['vat'])/100 * $data['net'];

        Servicefee::findOrFail($id)->update($data);

        return redirect()->route('servicefee.index')->with('success',"Successfully updated the service fee");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $data  = $request->all();
		$id=$data['id'];
		$branch = \App\Models\Servicefee::findOrFail($id);
		
		$branch->delete();
		
		
        return redirect()->back()->with('success', 'Successfully deleted service fee.');
    }

    public function ajaxIndex(Request $request){
        $search = $request->q ?? "";
       
        $data = \App\Models\Servicefee::select("*");
        $data->where("status",1);
        $data->where('name','LIKE','%'.$search."%");
        $data->limit(6);
        return response()->json($data->get());
    }

}
