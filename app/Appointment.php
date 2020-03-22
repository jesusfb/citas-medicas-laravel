<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\CancelledAppointment;
class Appointment extends Model
{
    //

    protected $fillable=[
        'description',
        'scheduled_date',
        'scheduled_time',
        'type',
        'doctor_id',
        'patient_id',
        'specialty_id',
        'status'
    ];
    // va permitir acceder desde un appointment a la especilidad asociada
    public function specialty(){
        // una especialidad se asocia con multiples citas
        // N appointment-> specialty 1
        return $this->belongsTo(Specialty::class);
     // a cada appointment le pertenece una especialidad determinada
    }


    // UNA CITA ES ATENDIDA POR UN SOLO MEDIOCO
    // Y UN MEDICO ATIENDE VARIA CITAS
     // N Appointment -> user (Doctor) 1
    public function doctor(){
        return $this->belongsTo(User::class);
    }
    // como el metodo es doctor, laravel va y busca dentro de la tabla un atributo con ese mismo nombre (doctor_id) y es por eso que ponemos acceder al nombre del doctor usando 
    ///appointment->d
        // N Appointment -> user (patient) 1
    public function patient(){
        return $this->belongsTo(User::class);
    }

    /* Como queremos mostrar la hora en formato de AM PM necesitamos que ese String que nos devuelve lo transformemos a un objeto carbon y para ello vamos a usar un accesor, los accesor deben tener la siguiente forma getXAttribute donde X es el nombre del metodo que usaremos para despues hacer posible lo siguiente: $appointment-schedule_time12
    */
    //ACCESOR 
   //  $appointment->scheduled_time_12 para acceder a esto
    public function getScheduledTime12Attribute(){
        return (new Carbon($this->scheduled_time))->format('g:i A');

    }

    //relacion 1 - 1/0 
    //(1 appointment se va relacionar con una o ninguna cancelacion)
    //appojntment->cancellation->cancelled_by 
    function cancellation(){
        return $this->hasOne(CancelledAppointment::class);
    } 
}
