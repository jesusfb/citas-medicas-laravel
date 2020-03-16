<?php
namespace App\Interfaces;
 interface ScheduleServiceInterface {
     // la fecha por la cual se consulta y el medico
    public function getAvailableIntervals($date, $doctorId);

}