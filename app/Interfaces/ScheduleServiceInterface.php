<?php
namespace App\Interfaces;
use Carbon\Carbon;
 interface ScheduleServiceInterface {
     // la fecha por la cual se consulta y el medico
    public function getAvailableIntervals($date, $doctorId);
    public function isAvailableInterval($date, $doctorId, Carbon $start);
}