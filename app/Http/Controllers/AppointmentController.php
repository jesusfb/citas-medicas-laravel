<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Specialty;

class AppointmentController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
       // $this->middleware('patients');

    }
    function create(){
        $specialties= Specialty::all();
      //  dd($specialties->toArray());
        return view('appointments.create',compact('specialties'));
    }
}
