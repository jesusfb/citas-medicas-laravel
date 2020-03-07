<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        //PARA CREAR EL PRIMER USER POR DEFECTO
        // ID 1
        App\User::create([
            'name' => 'Admin Test',
            'email' => 'admin@gmail.com',
            'password' =>bcrypt('123456'), 
            'dni' => '',
            'address' => '',
            'phone' => '',
            'role' => 'admin',

        ]);
                // ID 2
       
        App\User::create([
            'name' => 'Pacient Test',
            'email' => 'patient@gmail.com',
            'password' =>bcrypt('123456'), 
            'dni' => '',
            'address' => '',
            'phone' => '',
            'role' => 'patient',

        ]);
           
        // ID 3
        App\User::create([
            'name' => 'Doctor Test',
            'email' => 'doctor@gmail.com',
            'password' =>bcrypt('123456'), 
            'dni' => '',
            'address' => '',
            'phone' => '',
            'role' => 'doctor',

        ]);
        //DESPUES SE CREAN ESTOS 50 REGISTROS
        factory(App\User::class, 50)->state('patient')->create();
      
    }
}
