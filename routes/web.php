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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//RUTAS PARA SPECIALTY

Route::get('specialties', 'SpecialtyController@index')->name('specialties.index');
Route::get('specialties/create', 'SpecialtyController@create')->name('specialties.create');
//Route::get('specialties/{speciality}/edit', 'SpecialtyController@edit');
Route::post('specialties/store', 'SpecialtyController@store')->name('specialties.store');
Route::get('specialties/{specialty}/edit', 'SpecialtyController@edit')->name('specialties.edit');
Route::put('specialties/{specialty}/update', 'SpecialtyController@update')->name('specialties.update');
Route::delete('specialties/{specialty}/delete', 'SpecialtyController@destroy')->name('specialties.delete');
