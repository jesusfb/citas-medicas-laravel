<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('123456'), // 
        'remember_token' => Str::random(10),
        'dni' => $faker->randomNumber(8, true),
        'address' => $faker->address,
        'phone' => $faker->e164PhoneNumber,
        'role' => $faker->randomElement(['patient', 'doctor']),
        
    ];
});
// cada vez que se ejecute este estado va tener un valor que es patient
$factory->state(App\User::class, 'patient',[
    'role' => 'patient',
]);

// cada vez que se ejecute este estado va tener un valor que es doctor (override)
$factory->state(App\User::class, 'doctor',[
    'role' => 'doctor',
]);