<?php

namespace App\Http\Controllers\Admin;

use App\Models\CommunicationLog;
use Illuminate\Http\Request;

class CommunicationLogController extends BaseController
{
    //

    public function show($com){
        $data = array();
        $data['row']= CommunicationLog::findOrFail($com);
        return view("admin.communicationlog.show",compact('data'));
    }

    public function index(){
        $data = array();
        $data['communicationlogs'] = CommunicationLog::latest()->paginate(20);
        return view('admin.communicationlog.index',compact('data'));
    }

    public function destroy($com){
        $com = CommunicationLog::findOrFail($com);
        $com->delete();
        return back()->with('success','Successfully deleted communication log');
    }
}
