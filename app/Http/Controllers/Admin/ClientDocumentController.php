<?php

namespace App\Http\Controllers\Admin;


use DB;
use Auth;
use App\Models\Enquiry;
use Session;
use App\Models\BasicInfo;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;

class ClientDocumentController extends BaseController
{
    private $title;
    private $enquiry;
    private $country_code;
    private $destinationPath;
    // private $users;

    public function __construct()
    {
        $this->middleware('auth');
        $this->title = $this->getTitle();
        $this->destinationPath = 'uploads/files';
    }

    public function addDocument($id)
    {
        $data = [];
        $basicInfo = BasicInfo::find($id);
        if (!$basicInfo) {
            return 'Not Found';
        }
        $url            = '';
        $data['panel_name']   = "Add Document  For #" . $basicInfo->full_name;
        $data['link']         = $url;
        $data['row']          = $basicInfo;
        return view('admin.basic_info.document.add', compact('data'));
    }

    public function editDocument($id)
    {
        $data = [];
        $document = Document::find($id);
        if (!$document) {
            return 'Not Found';
        }
        $data['panel_name'] = "Edit Document For #" . $document->basicinfo->full_name;
        $url    = '';
        $data['link'] = $url;
        $data['row']  = $document;
        return view('admin.basic_info.document.edit', compact('data'));
    }

    public function storeDocument(Request $request)
    {

        // dd($request->all());        

        $validator = \Validator::make($request->all(), [
            "basic_info_id"     => "required|exists:basic_infos,id",
            "name"         => "required",
            "note"       => "max:300",
            "documents"        => "required|file|mimes:jpeg,bmp,png,pdf",
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {

            $file = $request->file('documents');
            $fileType = '';
            if ($file) {
                switch ($file->getClientOriginalExtension()) {
                    case 'jpeg':
                        $fileType = 'image';
                        break;
                    case 'bmp':
                        $fileType = 'image';
                        break;
                    case 'jpg':
                        $fileType = 'image';
                        break;
                    case 'pdf':
                        $fileType = 'pdf';
                        break;
                    case 'png':
                        $fileType = 'image';
                        break;
                    case 'doc':
                        $fileType = 'document';
                    default:
                        $fileType = '';
                }
            }

            $extra = $request->basic_info_id;
            $path = $this->destinationPath . '/' . $extra;

            $file_uploaded_path = $this->saveUpdateImage($file, $filename = null, $path, $extra);

            $document                    = new Document();
            $document->basic_info_id     = $request->basic_info_id;
            $document->name         = $request->name;
            $document->note       = $request->note;
            $document->documents      = $file_uploaded_path;
            $document->ftype      = $fileType;
            $document->created_by        = Auth::user()->id;
            $document->created           = now();
            $document->modified          = now();
            $document->modified_by       = Auth::user()->id;
            if ($document->save()) {
                return redirect()->route('client.show', ['id' => $request->basic_info_id, 'click' => 'documents'])->with('success', 'Add success');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function storeDocuments(Request $request)
    {

        // dd($request->all());        

        $validator = \Validator::make($request->all(), [
            "basic_info_id"     => "required|exists:basic_infos,id",
            "documents"        => "required|array",
            "documents.*"        => "file|mimes:jpeg,bmp,png,pdf",
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        foreach ($request->documents as $file) {
            $fileType = '';
            if ($file) {
                switch ($file->getClientOriginalExtension()) {
                    case 'jpeg':
                        $fileType = 'image';
                        break;
                    case 'bmp':
                        $fileType = 'image';
                        break;
                    case 'jpg':
                        $fileType = 'image';
                        break;
                    case 'pdf':
                        $fileType = 'pdf';
                        break;
                    case 'png':
                        $fileType = 'image';
                        break;
                    case 'doc':
                        $fileType = 'document';
                    default:
                        $fileType = '';
                }
            }

            $extra = $request->basic_info_id;
            $path = $this->destinationPath . '/' . $extra;

            $file_uploaded_path = $this->saveUpdateImage($file, $filename = null, $path, $extra);

            $document                    = new Document();
            $document->basic_info_id     = $request->basic_info_id;
            $document->name         = $file->getClientOriginalName();
            $document->note       = null;
            $document->documents      = $file_uploaded_path;
            $document->ftype      = $fileType;
            $document->created_by        = Auth::user()->id;
            $document->created           = now();
            $document->modified          = now();
            $document->modified_by       = Auth::user()->id;
            $document->save();
        }

        return redirect()->route('client.show', ['id' => $request->basic_info_id, 'click' => 'documents'])->with('success', 'Add success');
    }

    public function updateDocument(Request $request, $id)
    {

        $document = Document::find($id);

        if (!$document) {
            return 'Not Found';
        }

        $validator = \Validator::make($request->all(), [
            "basic_info_id"     => "required|exists:basic_infos,id",
            "name"         => "required",
            "note"       => "max:300",
            "documents"        => "file|mimes:jpeg,bmp,png,pdf|nullable",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $fileType = '';
            $file = $request->file('documents');

            $extra = $request->basic_info_id;
            $path = $this->destinationPath . '/' . $extra;

            $file_uploaded_path = $document->documents;
            if ($request->hasFile('documents')) {
                $file_uploaded_path = $this->saveUpdateImage($file, $filename = null, $path, $extra);

                if ($file) {
                    switch ($file->getClientOriginalExtension()) {
                        case 'jpeg':
                            $fileType = 'image';
                            break;
                        case 'bmp':
                            $fileType = 'image';
                            break;
                        case 'jpg':
                            $fileType = 'image';
                            break;
                        case 'pdf':
                            $fileType = 'pdf';
                            break;
                        case 'png':
                            $fileType = 'image';
                            break;
                        case 'doc':
                            $fileType = 'document';
                        default:
                            $fileType = '';
                    }
                    if ($document->documents) {
                        $old_img = $document->documents;
                        if (file_exists($old_img)) {
                            unlink($old_img);
                        }
                    }
                } elseif (isset($document->document) && !empty($document->document)) {
                    $file_uploaded_path = $document->document;
                }
            }

            $document->basic_info_id     = $request->basic_info_id;
            $document->name         = $request->name;
            $document->note       = $request->note;
            $document->documents      = $file_uploaded_path;
            $document->ftype      = $fileType;
            $document->created_by        = ($document->created_by) ?? Auth::user()->id;
            $document->created           = now();
            $document->modified          = now();
            $document->modified_by       = Auth::user()->id;
            if ($document->save()) {
                return redirect()->route('client.show', ['id' => $request->basic_info_id, 'click' => 'documents'])->with('success', 'updated successfully');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function deleteDocument($id)
    {
        $file = Document::findOrFail($id);
        $id = $file->basic_info_id;
        $file->delete();
        return redirect()->route('client.show', ['id' => $id, 'click' => 'documents'])->with("success", "Successfully deleted document");
    }

    public function destroy($id)
    {
        $file = Document::findOrFail($id);
        $eid = $file->enquiry_id;
        $cid = $file->basic_info_id;

        $file->delete();
        if ($cid)
            return redirect()->route('client.show', ['id' => $cid, 'click' => 'documents'])->with("success", "Successfully deleted document");
        if ($eid)
            return redirect()->route('enquiry.log', ['id' => $eid,])->with("success", "Successfully deleted document");
    }
}
