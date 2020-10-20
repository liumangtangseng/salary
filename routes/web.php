<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/login','HomeController@login')->name('login');

Route::post('/do_login','Ajax\UserAjaxController@doUserLogin')->name('doLogin');
Route::get('/do_logout','HomeController@doUserLogout')->name('logout');
Route::get('/reset_password','HomeController@forgetPassword')->name('forgetPassword');
Route::post('/reset_password','HomeController@submitNewEmail')->name('submitEmail');
Route::any('mail/send','MailController@send');
Route::get('/set_password/{token}','HomeController@setPassword')->name('setPassword');
Route::post('/save_password','HomeController@saveNewPassword');
Route::group(['middleware'=>'CheckLogin'],function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/salary', 'HomeController@searchSalary')->name('search');
});