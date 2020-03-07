<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\Specialty;

class SpecialtyController extends Controller
{
    //
    function doctors(Specialty $specialty){
      //  return $specialty->users; // laravel automaticamente un array lo transforma a JSON si es el dato ouput 
      $doctors = $specialty->users()->get(['users.id', 'users.name']);
      return response()->json([
             "errors" =>false,
             "data"=>$doctors
      ],200);
    }
}
