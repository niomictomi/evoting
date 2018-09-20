<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Support\Role;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $id_panitia = 12345543210;
        $id_others = 12345543220;

        foreach (Role::ALL as $role){
            $user = null;
            if ($role == Role::PANITIA){
                foreach (Role::PANITIA_ALL as $panitia){
                    $user = User::create([
                        'id' => ++$id_panitia,
                        'nama' => $panitia,
                        'password' => bcrypt('secret'),
                        'role' => $role,
                        'helper' => $panitia
                    ]);
                }
            }
            else{
                $user = User::create([
                    'id' => $id_others,
                    'nama' => $faker->unique()->name,
                    'password' => bcrypt('secret'),
                    'role' => $role,
                ]);
                $id_others += 10;
            }
            if ($user->isWD3() || $user->isDosen()){
                $user->helper = bcrypt('bukahasil');
                $user->save();
            }
            if ($user->isKetuaKPU()){
                $user->helper = bcrypt('secret');
                $user->save();
            }
        }
    }
}
