<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Formula;
use App\Models\Questionex;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QuestionexController extends Controller
{

    function showClass(Request $request, $id)
    {
        $class = Category::findOrFail($id);
        return view('admin.questionex.manage')->with(compact('class'));
    }

    function showDetail(Request $request)
    {
        $formula = formula::findOrFail($request->id);
        return view("formula.index")->with(compact("formula"));
    }

    function store(Request $request)
    {

        $fileName = "";
        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file'); //SIMPAN SEMENTARA FILENYA KE VARIABLE
            $fileName = $request->title . "_" . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pdf/'), $fileName); //SIMPAN KE DALAM FOLDER PUBLIC/UPLOADS
        }

        $object = new Questionex();
        $object->category_id = $request->category_id;
        $object->name = $request->title;
        $object->pdf_path = $fileName;
        $object->content = $request->content;
        $object->save();

        if ($object) {
            return back()->with(["success" => "Rumus Berhasil Disimpan"]);
        } else {
            return back()->with(["error" => "Rumus Gagal Disimpan"]);
        }
    }

    public function destroy(Request $request)
    {
        $object = Questionex::findOrFail($request->id);
        $object->delete();
    }


    function fetchAll(Request $request)
    {
        $data = Questionex::where("category_id", '=', $request->id)
            ->orderBy('created_at', 'ASC');

        if ($request->id == "") {
            $data = Questionex::all();
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
        $object['length'] = $counter;
        return $object;
    }



    function getAjax(Request $request)
    {
        $data = Questionex::where("category_id", '=', $request->id)
            ->orderBy('created_at', 'ASC');

        if ($request->id == "") {
            $data = Questionex::all();
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
