<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CancelledAppointment extends Model
{
    //
    function cancelled_by(){ // laravel automaticamente va buscar un campo en mi bd con cancelled_by_id
        //cANCELLATION N - 1 USER
         return $this->belongsTo(User::class);
    }
}
