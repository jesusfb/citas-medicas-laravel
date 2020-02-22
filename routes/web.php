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

//ESPECIALIDADES
Route::get('specialties', 'SpecialtyController@index')->name('specialties.index');
Route::get('specialties/create', 'SpecialtyController@create')->name('specialties.create');
//Route::get('specialties/{speciality}/edit', 'SpecialtyController@edit');
Route::post('specialties/store', 'SpecialtyController@store')->name('specialties.store');
Route::get('specialties/{specialty}/edit', 'SpecialtyController@edit')->name('specialties.edit');
Route::put('specialties/{specialty}/update', 'SpecialtyController@update')->name('specialties.update');
Route::delete('specialties/{specialty}/delete', 'SpecialtyController@destroy')->name('specialties.delete');

//MEDICOS
Route::get('doctors', 'DoctorController@index')->name('doctors.index');
Route::get('doctors/create', 'DoctorController@create')->name('doctors.create');
Route::post('doctors/store', 'DoctorController@store')->name('doctors.store');
Route::get('doctors/{doctor}/edit', 'DoctorController@edit')->name('doctors.edit');
Route::put('doctors/{doctor}/update', 'DoctorController@update')->name('doctors.update');
Route::delete('doctors/{doctor}/delete', 'DoctorController@destroy')->name('doctors.delete');

//PACIENTES
Route::get('patients', 'PatientController@index')->name('patients.index');
Route::get('patients/create', 'PatientController@create')->name('patients.create');
Route::post('patients/store', 'PatientController@store')->name('patients.store');
Route::get('patients/{patient}/edit', 'PatientController@edit')->name('patients.edit');
Route::put('patients/{patient}/update', 'PatientController@update')->name('patients.update');
Route::delete('patients/{patient}/delete', 'PatientController@destroy')->name('patients.delete');