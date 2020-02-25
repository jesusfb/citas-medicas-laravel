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
        'password', 'remember_token',
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
        return $this->belongsToMany(Specialty::class);
    }
}
