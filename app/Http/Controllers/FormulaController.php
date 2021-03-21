<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Formula;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FormulaController extends Controller
{

    function showClass(Request $request, $id)
    {
        $class = Category::findOrFail($id);
        return view('admin.formula.manage')->with(compact('class'));
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

        $formula = new Formula();
        $formula->category_id = $request->category_id;
        $formula->name = $request->title;
        $formula->formulas = $request->content;
        $formula->save();

        if ($formula) {
            return back()->with(["success" => "Rumus Berhasil Disimpan"]);
        } else {
            return back()->with(["error" => "Rumus Gagal Disimpan"]);
        }
    }

    public function destroy(Request $request)
    {
        $formula = formula::findOrFail($request->id);
        $formula->delete();
    }


    function fetchAll(Request $request , $formula_id)
    {
        $type = "";
        if ($formula_id == "" || $formula_id == null) {
            $data = Formula::all();
            $type = "no argument";
        }else{
            $data = Formula::where("category_id", '=', $formula_id)
            ->get();
            $type = "with argument";  
        }

        $object = array();
        $object['status'] = 1;
        $object['request'] = $formula_id;
        $object['request_arg_status'] = $type;
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
        $data = Formula::where("category_id", '=', $request->id)
            ->orderBy('created_at', 'ASC');

        if ($request->id == "") {
            $data = Formula::all();
        }

        $object = array();
        $object["draw"] = 0;
        $object["recordsTotal"] = 0;
        $object["recordsFiltered"] = 0;

        foreach ($data as $row) {
            $object["data"][] = [
                "id" => $row->id,
                "name" => $row->id,
                "formula" => $row->id,
            ];
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->escapeColumns('formulas')
            ->make(true);
    }
}
