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

// Route::get('/', function () {
//     return view('welcome');
// });

#Index page
Route::get('/', "App\Http\Controllers\AppController@index");

//party routes
Route::get('/add-party', "App\Http\Controllers\partyController@addparty")->name('add-party');
Route::post('/create-party', "App\Http\Controllers\partyController@createparty")->name('create-party');
Route::get('/manage-parties', "App\Http\Controllers\partyController@index")->name('manage-parties');


//GST bill routes
Route::get('/add-gst-bill', "App\Http\Controllers\GstBillController@addGstBill")->name('add-gst-bill');
Route::get('/manage-gst-bill', "App\Http\Controllers\GstBillController@index")->name('manage-gst-bill');
Route::get('/print-gst-bill', "App\Http\Controllers\GstBillController@print")->name('print-gst-bill');