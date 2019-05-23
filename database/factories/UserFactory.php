<?php

use App\Models\User;
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

$factory->define(App\Models\User::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$piu5X9eV4L5xT6egP.NL6uxOZO9kaaozhe3L/18HqO6xaiaGTc52i', // 111111
        'remember_token' => Str::random(10),
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
