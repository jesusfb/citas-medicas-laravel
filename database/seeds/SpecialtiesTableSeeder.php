<?php

use Illuminate\Database\Seeder;

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
                        'Oftalmologia' ,
                        'Pediatria','Neurologia', 
                        'Cardiologia'
                     ];
        foreach ($specialties as $specialty) {
            # code...
            App\Specialty::create([
                'name' => $specialty
            ]);
        }
       
    }
}
