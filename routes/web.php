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

Route::get('/', function () {
    if(Auth::guest()){
        return view('welcome');
    }else{
        return redirect('/home');
    }
});

Auth::routes();

Route::get('/hr', 'HomeController@hr');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/task', 'TaskController@index');
Route::post('/task/add', "TaskController@store");

Route::get('user/register', 'UserController@index');
Route::post('/user/register', 'UserController@register');
Route::post('/updatepassword', 'UserController@update_password');

Route::get('/security', function(){
    return view('user.security');
});

Route::post('/log/timein', 'TimeLogController@timein');
Route::get('/log', 'TimeLogController@log');

Route::get('/report', 'ReportController@showUsers');
Route::get('/timelogs', 'ReportController@showTimeLogs');

Route::get('/end_session',function() {
    Auth::logout();
    return redirect('/login');
});