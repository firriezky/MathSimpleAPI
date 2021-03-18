<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CkeditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layout.ckeditor');
    }

    public function upload(Request $request){
        $file = $request->file('upload'); //SIMPAN SEMENTARA FILENYA KE VARIABLE
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); //KITA GET ORIGINAL NAME-NYA
        //KEMUDIAN GENERATE NAMA YANG BARU KOMBINASI NAMA FILE + TIME
        $fileName =  '_' . time() . '.' . $file->getClientOriginalExtension();

        $file->move(public_path('uploads/ckeditor/'), $fileName); //SIMPAN KE DALAM FOLDER PUBLIC/UPLOADS

        //KEMUDIAN KITA BUAT RESPONSE KE CKEDITOR
        $ckeditor = $request->input('CKEditorFuncNum');
        $url = asset('uploads/ckeditor' ."/". $fileName); 
        $msg = 'Image uploaded successfully'; 
        //DENGNA MENGIRIMKAN INFORMASI URL FILE DAN MESSAGE
        $response = "<script>window.parent.CKEDITOR.tools.callFunction($ckeditor, '$url', '$msg')</script>";

        //SET HEADERNYA
        @header('Content-type: text/html; charset=utf-8'); 
        return $response;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->content=$request->content;

        $post->save();

        if ($post) {
            return "success";
        }else{
            return "failed";
        }
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
    }
}
