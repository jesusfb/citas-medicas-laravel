<?php

use Illuminate\Database\Seeder;
use App\Appointment;
use App\User;
class AppointmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Appointment::class, 300)->create();
    }
}
