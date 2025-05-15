<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvisorController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = array();
        $data['advisors']= Advisor::all();
        $data['panel_name']= "Advisors";
        return view('admin.advisor.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = array();
        $data['advisor']= new Advisor;
        return view('admin.advisor.create',compact('data'));
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
            'level'=>"required",
            'contact'=>"required",
            'email'=>"required",
            'signature'=>'image|nullable',
            'status'=>'required'
            ]);
            
        
        if($request->hasFile('signature')){

            $file = $request->file('signature');
            $filename = time().'-'.$file->getClientOriginalName();

            $data['signature']=  Storage::disk('uploads')->putFileAs('signatures',$file,$filename);

        }else{
            $data['signature'] = null;
        }

        Advisor::create($data);

        return redirect()->route('advisor.index')->with('success',"Successfully added an advisor");
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
        $data['row']= Advisor::findOrFail($id);
        return view('admin.advisor.show',compact('data'));
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
        $data['advisor']= Advisor::findOrFail($id);
        return view('admin.advisor.edit',compact('data'));
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
        $advisor = Advisor::findOrFail($id);
        $data = $this->validate($request,[
            'category'=>"required",
            'name'=>"required",
            'level'=>"required",
            'contact'=>"required",
            'email'=>"required",
            'signature'=>'image|nullable',
            'status'=>'required'
            ]);
            
        
        if($request->hasFile('signature')){

            $file = $request->file('signature');
            $filename = time().'-'.$file->getClientOriginalName();
            
            $data['signature']=  Storage::disk('uploads')->putFileAs('signatures',$file,$filename);

            Storage::disk('uploads')->delete($advisor->signature);

        }else{
            $data['signature'] = $advisor->signature;
        }

        $advisor->update($data);

        return redirect()->route('advisor.index')->with('success',"Successfully updated the advisor");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
         //
      
         $branch = \App\Models\Advisor::findOrFail($id);
         
         $branch->delete();
         
         
         return redirect()->back()->with('success', 'Successfully deleted advisor.');
    }
}
