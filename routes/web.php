<?php

use Illuminate\Support\Facades\Route;

//Namespace Auth
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\QuestionexController;

//Namespace Admin
use App\Http\Controllers\Admin\AdminController;

//Namespace User
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/','welcome');
Route::view('/cek','layout.ckeditor');

Route::resource("ckeditor","CkeditController");

Route::post("ckeditor/upload",'CkeditController@upload')->name("ckeditor.upload");


Route::any('/admin/formula/fetch','FormulaController@getAjax')->name("formula.fetch");
Route::get('/admin/formula/category/{id}','FormulaController@showClass');
Route::get('/formula/{id}/','FormulaController@showDetail');
Route::post('/admin/formula/store','FormulaController@store')->name("formula.store");
Route::delete('/admin/formula/{id}','FormulaController@destroy')->name("formula.destroy");

Route::any('/admin/questionex/fetch','QuestionexController@getAjax')->name("questionex.fetch");
Route::post('/admin/questionex/store','QuestionexController@store')->name("questionex.store");
Route::delete('/admin/questionex/{id}','QuestionexController@destroy')->name("formula.destroy");
Route::get('/admin/questionex/category/{id}','QuestionexController@showClass');


Route::post('/admin/notations/store','NotasiController@store')->name("notation.store");
Route::get('/admin/notations/manage','NotasiController@showIndexAdmin');
Route::any('/admin/notation/fetch','NotasiController@getAjax')->name("notation.fetch");
Route::delete('/admin/notation/{id}','NotasiController@destroy')->name("notation.destroy");
Route::get('/admin/notation/{id}/edit','NotasiController@edit');


Route::group(['namespace' => 'Admin','middleware' => 'auth','prefix' => 'admin'],function(){
	
	Route::get('/',[AdminController::class,'index'])->name('admin')->middleware(['can:admin']);

	//Route Rescource
	Route::resource('/user','UserController')->middleware(['can:admin']);
	//Route View
	Route::view('/404-page','admin.404-page')->name('404-page');
	Route::view('/blank-page','admin.blank-page')->name('blank-page');
	Route::view('/buttons','admin.buttons')->name('buttons');
	Route::view('/cards','admin.cards')->name('cards');
	Route::view('/utilities-colors','admin.utilities-color')->name('utilities-colors');
	Route::view('/utilities-borders','admin.utilities-border')->name('utilities-borders');
	Route::view('/utilities-animations','admin.utilities-animation')->name('utilities-animations');
	Route::view('/utilities-other','admin.utilities-other')->name('utilities-other');
	Route::view('/chart','admin.chart')->name('chart');
	Route::view('/tables','admin.tables')->name('tables');
	

});

Route::group(['namespace' => 'User','middleware' => 'auth' ,'prefix' => 'user'],function(){
	Route::get('/',[UserController::class,'index'])->name('user');
	Route::get('/profile',[ProfileController::class,'index'])->name('profile');
	Route::patch('/profile/update/{user}',[ProfileController::class,'update'])->name('profile.update');
});

Route::group(['namespace' => 'Auth','middleware' => 'guest'],function(){
	Route::view('/login','auth.login')->name('login');
	Route::post('/login',[LoginController::class,'authenticate'])->name('login.post');
});

// Other
Route::view('/register','auth.register')->name('register');
Route::view('/forgot-password','auth.forgot-password')->name('forgot-password');
Route::post('/logout',function(){
	return redirect()->to('/login')->with(Auth::logout());
})->name('logout');
