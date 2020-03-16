<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Interfaces\ScheduleServiceInterface;
use Illuminate\Http\Request;
use App\User;
use App\WorkDay;
use Carbon\Carbon;
// VIDEO 12 CURSO LARAVEL 
class ScheduleController extends Controller
{
    //injeccion de dependencias
    function hours(Request $request,ScheduleServiceInterface $scheduleService){
        $rules=[
            'date' => 'required|date_format:"Y-m-d"',
            'doctor_id' => 'required|exists:users,id',

        ];
        $this->validate($request,$rules);
        $date= $request->input('date');
        $doctorId=$request->input('doctor_id'); 
        return $scheduleService->getAvailableIntervals($date,$doctorId);;
        
    }
   
}
