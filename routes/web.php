<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

//用户注册
Route::get('/signup', 'UsersController@create')->name('signup');
Route::get('/signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

Route::get('/users', 'UsersController@index')->name('users.index'); //用户列表页
//Route::get('/users/create', 'UsersController@create')->name('users.create');    //创建用户表单页
Route::post('/users', 'UsersController@store')->name('users.store');    //表单数据提交处理保存
Route::get('/users/{user}', 'UsersController@show')->name('users.show');    //个人数据展示页面
Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');     //个人资料编辑页面
Route::patch('/users/{user}', 'UsersController@update')->name('users.update');  //个人信息更新表达数据提交
Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');//用户删除

//关注的人和粉丝列表页路由
Route::get('/users/{user}/followers', 'UsersController@followers')->name('users.followers');
Route::get('/users/{user}/followings', 'UsersController@followings')->name('users.followings');

//资源路由等同于上面的7个路由
//Ruote::resource('users', 'UsersController');

//用户登录
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'sessionsController@destroy')->name('logout');

//重置密码
Route::get('/password/reset', 'PasswordController@showLinkRequestForm')->name('password.request');
Route::post('/password/email', 'PasswordController@sendResetLinkEmail')->name('password.email');

Route::get('password/reset/{token}', 'PasswordController@showResetForm')->name('password.reset');
Route::post('/password/reset', 'PasswordController@reset')->name('password.update');

//微博路由
Route::resource('statuses', 'StatusesController', ['only' => ['create', 'store', 'destroy']]);

//关注用户和取消关注
Route::post('/users/followers/{user}', 'FollowersController@store')->name('followers.store');
Route::delete('/users/followers/{user}', 'FollowersController@destroy')->name('followers.destroy');
