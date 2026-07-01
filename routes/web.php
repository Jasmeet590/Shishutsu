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

#basic route
Route::get('/', "App\Http\Controllers\AppController@index");

Route::get('/add-party', "App\Http\Controllers\partyController@addparty")->name('add-party');

#route with parameter
Route::get('/about/{parameter}', "App\Http\Controllers\AppController@about");

#route with optional parameter
Route::get('/service/{parameter?}', "App\Http\Controllers\AppController@service");