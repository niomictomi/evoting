<?php

use Illuminate\Database\Seeder;
use App\Mahasiswa;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Mahasiswa::class, 3000)->create()->each(function ($u){
            $u->make();
        });
    }
}
