<?php

use Illuminate\Database\Seeder;
use App\WorkDay;
use App\User;
class WorkDaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // VAMOS A DEFINIR UN HORARIO POR DEFECTO 
            for($i=0; $i<7; $i++){
                WorkDay::Create([
                    'day'=>$i,
                    'active'=>($i==3), // Jueves(Thursday) , (0=> Lunes,  6=> Domingo)
                    'morning_start'=>(  $i==3? '07:00:00':'05:00:00'),
                    'morning_end'=>($i==3? '09:30:00':'05:00:00'),
                    'afternoon_start'=>( $i==3? '15:00:00':'13:00:00'), 
                    'afternoon_end'=>( $i==3? '18:00:00':'13:00:00'), 
                    'user_id'=>3 // medico Test de (USerTableSeeder) doctor@gmail.com
                ]);  
            }
    }
}
