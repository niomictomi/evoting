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
        $faker = \Faker\Factory::create('ID_id');
        $prodi = \App\Prodi::all();

        for ($c = 0; $c < 3000; $c++){
            $status = Mahasiswa::STATUS[array_rand(Mahasiswa::STATUS, 1)];
            if ($status == Mahasiswa::NONAKTIF || $status == Mahasiswa::CUTI)
                $status = Mahasiswa::STATUS[array_rand(Mahasiswa::STATUS, 1)];
            if ($status == Mahasiswa::NONAKTIF || $status == Mahasiswa::CUTI)
                $status = Mahasiswa::STATUS[array_rand(Mahasiswa::STATUS, 1)];

            Mahasiswa::create([
                'id' => rand(11, 17).$faker->unique()->numerify('#########'),
                'prodi_id' => $prodi->random()->id,
                'nama' => $faker->unique()->name(),
                'status' => $status
            ]);
        }
    }
}
