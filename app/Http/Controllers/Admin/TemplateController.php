<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Models\CompanyInfo;
use App\Models\Template;
use Illuminate\Http\Request;
use PDF;
class TemplateController extends BaseController
{

    public function show(Request $request,$id)
    {
        if($request->ajax()){
            $t = Template::find($id);
            return response()->json($t);
        }
        $data = array();
        $data['row'] = Template::findOrFail($id);

        return view('templates.show', compact('data'));
    }
    //
    public function index()
    {
        $data = array();
        $data['panel_name'] = "Templates";
        $data['templates'] = Template::orderBy("id","asc")->paginate(10);
        return view('templates.index', compact('data'));
    }


    public function create()
    {
        $data = array();
        $template = new Template;
        $data['template'] = $template;

        return view('templates.create', compact("data"));
    }

    public function preview($data){
        // dd("preview");
        $data['company_info'] = CompanyInfo::first();
        $pdf = PDF::loadView("templates.preview",compact('data'));

        return $pdf->stream();
    }


    public function edit($id)
    {

        $data = array();
        $template = Template::findOrFail($id);
        $data['template'] = $template;

        return view('templates.edit', compact("data"));
    }


    public function update(Request $request, $id)
    {
        
        $t = Template::findOrFail($id);
        $data = $this->validate($request, [
            'title' => "required|unique:templates,title,{$t->id}",
            'content' => 'required'
        ]);

        if($request->action == 'preview'){
            return $this->preview($data);
        }

        $template = Template::findOrFail($id);
        $template->update($data);

        return redirect()->route('template.index')->with('success', "Successfully updated Template details");
    }


    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'title' => "required|unique:templates,title",
            'content' => 'required'
        ]);
        if($request->action == 'preview'){
            return $this->preview($data);
        }

        Template::create($data);

        return redirect()->route('template.index')->with('success', "Successfully updated Template details");
    }

    public function destroy(Request $request){
        $id = $request->id;
        $t = Template::findOrFail($id);
        $t->delete();
        
        return redirect()->route('template.index')->with('success', "Successfully deleted Template");
    }
}
