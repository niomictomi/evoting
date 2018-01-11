<?php

use Faker\Generator as Faker;
use App\Prodi;
use App\Mahasiswa;

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
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(Mahasiswa::class, function (Faker $faker) {
    return [
        'id' => rand(11, 17).$faker->unique()->numerify('#########'),
        'prodi_id' => rand(1, Prodi::all()->count()),
        'nama' => $faker->unique()->name(),
        'status' => Mahasiswa::STATUS[array_rand(Mahasiswa::STATUS, 1)],
        'login' => false,
        'hmj' => false,
        'dpm' => false,
        'bem' => false
    ];
});
