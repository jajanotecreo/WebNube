<?php

use Illuminate\Support\Facades\Route;
use App\Models\Agenda;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\AgendaController;

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

Route::middleware(['auth']) ->group(function (){
    Route::get('/', function () {
        $personas = Agenda::all();
        return view('welcome')->with(['personas' => $personas]);
    });
});



Auth::routes();

Route::get('/insert/person', 'App\Http\Controllers\AgendaController@viewInsert')->name('insert');
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/person/{id}','App\Http\Controllers\AgendaController@findById')->name('person_update');
Route::post('/save', 'App\Http\Controllers\AgendaController@insert')->name('save_person');
Route::post('/delete/{id}/destroy', 'App\Http\Controllers\AgendaController@delete')->name('delete_person');
Route::post('/update/{id}', 'App\Http\Controllers\AgendaController@update')->name('update_person');
