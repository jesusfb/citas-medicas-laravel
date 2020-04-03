<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Appointment;
use DB;

class ChartController extends Controller
{
    //
    function appointments(){
        // hay que agrupar por el campo month pero no lo tenemos, pero tenemos el creadted_at
        // pero el created_at es datetime, tendriamos que sacar el mes para agrupar por meses
        // es  decir la cantidad de appointments por mes

        $montlyCounts=Appointment::select(
                                        DB::raw('MONTH(created_at) as month'), 
                                        DB::raw('COUNT(1) as count '))
                                  ->groupBy('month')->get()->toArray();
        $counts=array_fill(0,12,0); // inicio, fin y valores que quiero setear al array
        foreach($montlyCounts as $montlyCount){
            $index=$montlyCount['month']-1;
            $counts[$index]= $montlyCount['count'];
        }
        return view('reports.appointments',compact('counts'));
    }
    function doctors(){
        return view('reports.doctors');
        
    }
}
