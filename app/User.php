<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'dni','address','phone','role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'pivot'
        // ESTO SON LOS CAMPOS QUE SE PUEDEN ASIGNAR DE FORMA MASIVA, NO QUEREMOS QUE EL ROL
        // SE SIGNE DE FORMA MASIVA POR ESO NO LO PONEMOS EN ESTE ARRAY
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    function scopeDoctors($query){
        return $query->where('role','doctor');
    }
    function scopePatients($query){
        return $query->where('role','patient');
    }
    public function specialties(){
        return $this->belongsToMany(Specialty::class)->withTimestamps();
    }
    /// $user->appointmentsAsPatient
    /// $user->appointmentsAsDoctor

    // 1 Medico atiende de 1 to N citas
    // 1 cita es atendida por un medico
    function asDoctorAppointments(){
        return $this->hasMany(Appointment::class,'doctor_id');
        // mediante este campo se va establercer la relacion con el medico
    }
    
    function asPatientAppointments(){
        return $this->hasMany(Appointment::class,'patient_id');
        // mediante este campo se va establercer la relacion con el paciente
    }
    function attendedAppointments(){
        return $this->asDoctorAppointments()->where('status', 'Atendida');
    } 
    function cancelledAppointments(){
        return $this->asDoctorAppointments()->where('status', 'Cancelada');
    }
    
    
}
