<?php
namespace App\Services;
// aqui va la logica de la app
use App\WorkDay;
use App\Interfaces\ScheduleServiceInterface;
use Carbon\Carbon;
class ScheduleService implements ScheduleServiceInterface{

    private function getDayFromDate($date){
        $dateCarbon= new Carbon($date); 
        // carbon : 0 (Sunday) - 6 (Saturday)
        // WorkDay : 0 (Monday) - 6 (Sunday)
        $i = $dateCarbon->dayOfWeek;
        $day= ($i == 0? 6 : $i-1);
        return $day;
    }

    public function getAvailableIntervals($date, $doctorId){
 
        $workDays=  WorkDay::where('active',true)
        ->where('day',$this->getDayFromDate($date))
        ->where('user_id',$doctorId) 
        ->first(['user_id','morning_start', 'morning_end', 'afternoon_start', 'afternoon_end']);

        if(!$workDays){
        return [];
        }
        $morningIntervals= $this->getIntervals($workDays->morning_start, $workDays->morning_end);
        $afternoonIntervals= $this->getIntervals($workDays->afternoon_start, $workDays->afternoon_end);
        $data= [];
        $data["morning"]= $morningIntervals;
        $data["afternoon"]= $afternoonIntervals;

        return $data;
    }
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