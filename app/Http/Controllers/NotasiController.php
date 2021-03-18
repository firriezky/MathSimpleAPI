<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Formula;
use App\Models\Notasi;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NotasiController extends Controller
{

    function showIndexAdmin(Request $request)
    {
        $notation = Notasi::all();
        return view('admin.notation.manage')->with(compact('notation'));
    }

    function showDetail(Request $request)
    {
        $formula = formula::findOrFail($request->id);
        return view("formula.index")->with(compact("formula"));
    }

    function store(Request $request)
    {
        $fileName = "";
        if ($request->hasFile('audio_file')) {
            $file = $request->file('audio_file'); //SIMPAN SEMENTARA FILENYA KE VARIABLE
            $fileName = $request->title . "_" . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/audio/'), $fileName); //SIMPAN KE DALAM FOLDER PUBLIC/UPLOADS
        }

        $object = new Notasi();
        $object->notation = $request->notation;
        $object->audio_path = $fileName;
        $object->read = $request->read;
        $object->description = $request->content;
        $object->save();

        if ($object) {
            return back()->with(["success" => "Rumus Berhasil Disimpan"]);
        } else {
            return back()->with(["error" => "Rumus Gagal Disimpan"]);
        }
    }

    public function destroy(Request $request)
    {
        $object = Notasi::findOrFail($request->id);
        $object->delete();
    }


    function fetchAll(Request $request)
    {
        $data = Formula::where("category_id", '=', $request->id)
            ->orderBy('created_at', 'ASC');

        if ($request->id == "") {
            $data = Formula::all();
        }

        $object = array();
        $object['status'] = 1;
        $object['length'] = 0;

        $counter = 0;
        foreach ($data as $row) {
            $counter++;
            $category = Category::findOrfail($row->category_id);
            $object["data"][] = [
                "id" => $row->id,
                "name" => $row->name,
                "category" => $category->class_name,
                "formula" => $row->formulas,
                "pdf_path" => $row->pdf_path,
                "created_at" => $row->created_at,
                "updated_at" => $row->updated_at,
            ];
        }
        $object['length'] = 0;
        return $object;
    }


    function getAjax(Request $request)
    {
        $data = Notasi::where("category_id", '=', $request->id)
            ->orderBy('created_at', 'ASC');

        if ($request->id == "") {
            $data = Notasi::all();
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('notation')
            ->make(true);
    }

    public function edit(Request $request)
    {
        $object = Notasi::findOrFail($request->id);
        return response()->json($object);
    }
    
}
