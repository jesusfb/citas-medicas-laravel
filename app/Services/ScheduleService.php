<?php
namespace App\Services;
use App\Interfaces\ScheduleServiceInterface;
use App\WorkDay;
use Carbon\Carbon;
use App\Appointment;
class ScheduleService implements ScheduleServiceInterface{

    private function getDayFromDate($date){
        $dateCarbon= new Carbon($date); 
        // carbon : 0 (Sunday) - 6 (Saturday)
        // WorkDay : 0 (Monday) - 6 (Sunday)
        $i = $dateCarbon->dayOfWeek;
        $day= ($i == 0? 6 : $i-1);
        return $day;
    }
    public function isAvailableInterval($date, $doctorId, Carbon $start){
        $exists = Appointment::where('doctor_id' , $doctorId)
        ->where('scheduled_date', $date)
        ->where('scheduled_time', $start->format('g:i A'))->exists();
        // va estar disponible si no hay cita reservada para esa fecha y hora
        return !$exists; //available if already none exists
    }
    public function getAvailableIntervals($date, $doctorId){
 
        $workDays=  WorkDay::where('active',true)
        ->where('day',$this->getDayFromDate($date))
        ->where('user_id',$doctorId) 
        ->first(['user_id','morning_start', 'morning_end', 'afternoon_start', 'afternoon_end']);

        if(!$workDays){
        return [];
        }
        $morningIntervals= $this->getIntervals($workDays->morning_start, $workDays->morning_end,$date,$doctorId);
        $afternoonIntervals= $this->getIntervals($workDays->afternoon_start, $workDays->afternoon_end, $date,$doctorId);
        $data= [];
        $data["morning"]= $morningIntervals;
        $data["afternoon"]= $afternoonIntervals;

        return $data;
    }
    private function getIntervals($start, $end, $date, $doctorId){

        $start= new Carbon($start);
        $end= new Carbon($end);
        $intervals=[];
        while($start < $end){
            // VAMOS A IR GENERANDO LAS HORAS INTERMEDIAS, vamos añadir elementos sobre nuestro arreglo,    // EL ITNERVAL VA TENER UN INICIO Y FIN
            $interval=[];
         
            $interval["start"]= $start->format('g:i A'); // horas y minutos AM o PM
            // para ver si la hora de inicio coincide con alguna otra cita medica
            $available = $this->isAvailableInterval($date, $doctorId, $start);
            $start->addMinutes(30); /// sumas + 30 min. para que el intervalo se haga cada media hora
            $interval["end"]= $start->format('g:i A');
            if($available){
                $intervals[]=$interval;// Si no existe colision de horarios añado ese intervalo al array
            }                       
        }
       // dd($intervals);
        return $intervals;
    }
}