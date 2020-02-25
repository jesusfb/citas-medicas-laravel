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




Route::middleware(['auth', 'admin'])->group( function () {
//ESPECIALIDADE S
        Route::get('specialties', 'Admin\SpecialtyController@index')->name('specialties.index');
        Route::get('specialties/create', 'Admin\SpecialtyController@create')->name('specialties.create');
        //Route::get('specialties/{speciality}/edit', 'SpecialtyController@edit');
        Route::post('specialties/store', 'Admin\SpecialtyController@store')->name('specialties.store');
        Route::get('specialties/{specialty}/edit', 'Admin\SpecialtyController@edit')->name('specialties.edit');
        Route::put('specialties/{specialty}/update', 'Admin\SpecialtyController@update')
        ->name('specialties.update');
        Route::delete('specialties/{specialty}/delete', 'Admin\SpecialtyController@destroy')->name('specialties.delete');

        //MEDICOS
        Route::get('doctors', 'Admin\DoctorController@index')->name('doctors.index');
        Route::get('doctors/create', 'Admin\DoctorController@create')->name('doctors.create');
        Route::post('doctors/store', 'Admin\DoctorController@store')->name('doctors.store');
        Route::get('doctors/{doctor}/edit', 'Admin\DoctorController@edit')->name('doctors.edit');
        Route::put('doctors/{doctor}/update', 'Admin\DoctorController@update')->name('doctors.update');
        Route::delete('doctors/{doctor}/delete', 'Admin\DoctorController@destroy')->name('doctors.delete');

        //PACIENTES
        Route::get('patients', 'Admin\PatientController@index')->name('patients.index');
        Route::get('patients/create', 'Admin\PatientController@create')->name('patients.create');
        Route::post('patients/store', 'Admin\PatientController@store')->name('patients.store');
        Route::get('patients/{patient}/edit', 'Admin\PatientController@edit')->name('patients.edit');
        Route::put('patients/{patient}/update', 'Admin\PatientController@update')->name('patients.update');
        Route::delete('patients/{patient}/delete', 'Admin\PatientController@destroy')->name('patients.delete');
});
    


Route::middleware(['auth', 'doctor'])->group( function () {
    //ESPECIALIDADE S
        Route::get('schedule', 'Doctor\ScheduleController@edit')->name('schedule.edit');
        // para consultar su horario actual
        Route::post('schedule/store', 'Doctor\ScheduleController@store')->name('schedule.store');
        // para guardar o actualizar su informacion 
});
        
Route::get('appointment', 'AppointmentController@create')->name('appointments.create');
Route::post('appointments/create', 'AppointmentController@create')->name('appointments.store');