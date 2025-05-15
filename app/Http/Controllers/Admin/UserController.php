<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends BaseController
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
        $data['users']= User::all();
        $data['panel_name']= "User";
        return view('admin.user.index',compact('data'));
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
        $data['departments'] =DB::table('departments')->get();
        $data['roles'] =DB::table('roles')->get();

        $data['user']= new User;
        return view('admin.user.create',compact('data'));
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
            'username'=>"required|unique:users,username",
            'email'=>"required|unique:users,email",
            'password'=>'string|min:6|confirmed',
            'department_id'=>'required|integer',
            'role_id'=>'required|integer'
            ]);

            $data['modified_by'] = auth()->user()->id;
        
        
       

        User::create($data);

        return redirect()->route('user.index')->with('success',"Successfully created the user");
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
        $data['user']= User::findOrFail($id);
        $data['departments'] =DB::table('departments')->get();
        $data['roles'] =DB::table('roles')->get();
        return view('admin.user.edit',compact('data'));
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
        $user = User::findOrFail($id);
       
        $data = $this->validate($request,[
            'username'=>"required|unique:users,username,$id",
            'email'=>"required|unique:users,email,$id",
            'department_id'=>'required|integer',
            'role_id'=>'required|integer'
            ]);


            if($request->password){
                $this->validate($request,[
                    'password'=>'string|min:6|confirmed'
                ]);

                $data['password']= Hash::make($request->password);
            }
        
            $data['modified_by'] = auth()->user()->id;


        $user->update($data);

        return redirect()->route('user.index')->with('success',"Successfully updated the user");
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
