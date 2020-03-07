<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    //No necesitamos poner el nombre de la tabla a la cual se asocia este modelo
    // porque estamos siguiendo la convencion es decir laravel buscara una tabla que se llame speicalties o sea //en "plurar"

    function users(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }
    
}
