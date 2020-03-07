<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\WorkDay;
use Carbon\Carbon;
// VIDEO 12 CURSO LARAVEL 
class ScheduleController extends Controller
{
    //
    function hours(Request $request){
        $rules=[
            'date' => 'required|date_format:"Y-m-d"',
            'doctor_id' => 'required|exists:users,id',

        ];
        $this->validate($request,$rules);
        // las horas la vamos a obtener de nuestro modelo WorkDay 
        // vamos a recibir el dia por el cual esta preguntando el paciente
        // el formato llega con yyyy-mm-dd
        //dd($request->all());  
         /*
            La logica del proyecto es:   
                Lunes->0                 
                Martes->                 
                 ....                   
                Domingo->6

           REVISAR=> https://carbon.nesbot.com/docs/
           especificamente este link: https://imgur.com/wsLL41E
            PERO : pero la logica de carbon cuando uso el dayOfWeek es:   
            // dayOfWeek returns a number between 0 (sunday) and 6 (saturday)     
            es decir : 
                    Domingo -> 0
                    Lunes-->  1
                    .......
                    Sabado->  6 
            entonces esta logica hay que llevarla a nuestra codificacion que ya tenemos en la BD

         */
         $date= $request->input('date');
         $pivote= new Carbon($date); 
         $day= ($pivote->dayOfWeek == 0) ? 6 : $pivote->dayOfWeek-1;
         $doctor_id=  $date= $request->input('doctor_id'); // este campo va venir como un parametro get
         $workDays=  WorkDay::where('active',true)
                            ->where('day',$day )
                            ->where('user_id',$doctor_id) 
                            ->first(['user_id','morning_start', 'morning_end', 'afternoon_start', 'afternoon_end']);
  
        // nostros encesitamos devolver una lista de horas disponibles para ese dia. 
        // es decir en intervalos para que el user pueda seleccionar alguno de ellos
        // en la mañana de 5 a 7 los intervalos serian  05:00 - 05:30 , 05:30 - 06:00
        // en la tarde del horario de las 01:00 PM hasta las 03:00 PM los intervalos serian asi
        //                          01:00 - 01:30 , 01:30-02:00- 02:00 - 02:30 , 02:30 - 03:00
        // cada intervalo deben irse en formato json para mostrarlos en la vista
        /* la respuesta la vamos a preparar de la siguiente manera:
            
                // por cada intervalo vamos a tener un objeto con toda esta inforamcion
            {
               "morning": [
                     {
                        "start" : "5:00 AM" , 
                        "end": "05"30 AM"
                     },
                      {
                        "start" : "5:30 AM" , 
                        "end": "06"00 AM"
                     }, ETC...
                     
                ], 
                "afternoon": [
                     {
                        "start" : "1:00 PM" , 
                        "end": "1"30 PM"
                     },
                      {
                        "start" : "1:30 PM" , 
                        "end": "2:00" PM"
                     }, ETC...
                     
                ]
            
            }    
                ...........
                y al final vamos a devolverl todo en formato de arreglo 
        */
       // dd($workDays->toArray());
       // LES ESTOY PASANDO UNA CADENA NORMAL, LA FUNCION GET INTERVAL VA MANEJAR TODO COMO OBJETO CARBON
       if(!$workDays){
           return [];
       }
        $morningIntervals= $this->getIntervals($workDays->morning_start, $workDays->morning_end);
        $afternoonIntervals= $this->getIntervals($workDays->afternoon_start, $workDays->afternoon_end);
        $data= [];
        $data["morning"]= $morningIntervals;
        $data["afternoon"]= $afternoonIntervals;
        //dd($data);
        return $data;
        
    }
    /// PARA CREAR INTERVALOS TANTO PARA LA TARDE Y MAÑANA ENTONCES VA RECIBIR LAS HORAS DE INICIO Y FIN EN CADENAS
    private function getIntervals($start, $end){

        $start= new Carbon($start);
        $end= new Carbon($end);
        $intervals=[];
        while($start < $end){
            // VAMOS A IR GENERANDO LAS HORAS INTERMEDIAS 
            // vamos añadir elementos sobre nuestro arreglo
            $interval=[];
            // EL ITNERVAL VA TENER UN INICIO Y FIN
            // como solo queremos la hora no todo el objeto vamos hacer lo siguiente
            $interval["start"]= $start->format('g:i A'); // horas y minutos AM o PM
            $start->addMinutes(30); /// sumas + 30 min. para que el intervalo se haga cada media hora
            $interval["end"]= $start->format('g:i A');
            $intervals[]=$interval;

        }
       // dd($intervals);
        return $intervals;
    }
}
