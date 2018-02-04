<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Support\Role;

class RootSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => '221196',
            'nama' => 'm1ku100',
            'password' => bcrypt('secret'),
            'role' => Role::ROOT
        ]);

        User::create([
            'id' => '10karakter',
            'nama' => 'Ainsworth',
            'password' => bcrypt('secret'),
            'role' => Role::ROOT
        ]);

        User::create([
            'id' => '15051204010',
            'nama' => 'Bagas MHH',
            'password' => bcrypt('secret'),
            'role' => Role::ROOT
        ]);
    }
}
