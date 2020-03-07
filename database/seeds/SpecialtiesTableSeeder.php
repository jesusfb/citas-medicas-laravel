<?php

use Illuminate\Database\Seeder;
use App\User;
class SpecialtiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $specialties=[
                        'Oftalmología' ,
                        'Pediatría',
                        'Neurología', 
                        //'Cardiologia'
                     ];
        foreach ($specialties as $specialtyName) {
            # code...
           $specialty= App\Specialty::create([
                'name' => $specialtyName
            ]);
            // make genera datos sin insertarlos en la BD, crea 3 MEDICOS POR ESPECIALIDAD
            $specialty->users()->saveMany(
                factory(User::class,3)->states('doctor')->make()
            );
        }
        User::find(3)->specialties()->save($specialty);
       
    }
}
