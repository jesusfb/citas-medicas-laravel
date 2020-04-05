<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Appointment;
use DB;
use App\User;

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
    function doctorsData(){
        // withCOunt recibe una relacion, que es la cual nostros tenemos en User.php
        // los 3 medicos mas activos
        $doctors=User::doctors()
                    ->select('id', 'name')
                    // podriamos pasar las 2 restricciones que queremos contar como un array withCount(['attened , 'cancelledappointment'])
                    ->WithCount('attendedAppointments') 
                    ->WithCount('cancelledAppointments')
                    ->orderBy('attended_appointments_count', 'DESC')
                    //->having('cancelled_appointments_count', '>' ,'0')
                    ->take(3)
                    ->get();
        $data=[];
        $data['categories']= $doctors->pluck('name'); // return array
        $series=[];
        // ATENDIAS
        $series1['name']='Citas atendidas';
        $series1['data']=$doctors->pluck('attended_appointments_count');

        //CANCELADAS
        $series2['name']= 'Citas canceladas';
        $series2['data']= $doctors->pluck('cancelled_appointments_count') ;

        $series[]=$series1;
        $series[]=$series2;

        $data['series']= $series;
        //dd($data);
        return $data; //{ categories: [] , series : [] }
    }
}
