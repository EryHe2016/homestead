<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('baby',function(){
    echo 'Baby, Hello!';
});
Route::get('form',function(){
    return view('form');
});
Route::post('insert',function(Request $request){
    var_dump($request->all());var_dump($request->input('username'));exit;
});
//Route::post('insert', 'UserController@store');
