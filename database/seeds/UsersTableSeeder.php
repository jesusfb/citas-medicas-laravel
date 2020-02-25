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
        App\User::create([
            'name' => 'Jorge Luis',
            'email' => 'jorgestudio2017@gmail.com',
            'password' =>bcrypt('123456'), 
            'dni' => '',
            'address' => '',
            'phone' => '',
            'role' => 'admin',

        ]);
        App\User::create([
            'name' => 'Dr. Ramirez',
            'email' => 'doctor@gmail.com',
            'password' =>bcrypt('123456'), 
            'dni' => '',
            'address' => '',
            'phone' => '',
            'role' => 'doctor',

        ]);
        App\User::create([
            'name' => 'Ricardo Fort',
            'email' => 'patient@gmail.com',
            'password' =>bcrypt('123456'), 
            'dni' => '',
            'address' => '',
            'phone' => '',
            'role' => 'patient',

        ]);
        //DESPUES SE CREAN ESTOS 50 REGISTROS
        factory(App\User::class, 50)->create();
     
    }
}
