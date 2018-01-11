<?php

use Illuminate\Database\Seeder;
use App\CalonBEM;
use App\Mahasiswa;

class PemilihanBemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $jumlahCalon = rand(2, 4);
        $mahasiswa = Mahasiswa::getByStatus()->get();
        $acakMahasiswa = array_rand($mahasiswa->toArray(), $jumlahCalon * 2);
        $counter = 0;
        $calon = Array();
        for ($c = 0; $c < $jumlahCalon; $c++){
            array_push($calon, CalonBEM::create([
                'ketua_id' => $mahasiswa->toArray()[$acakMahasiswa[$counter++]]['id'],
                'wakil_id' => $mahasiswa->toArray()[$acakMahasiswa[$counter++]]['id'],
                'dir' => 'http://www.voa-islam.com/photos5/GXaPe9UdAH.png',
                'visi' => $faker->unique()->text,
                'misi' => $faker->unique()->text(600),
                'nomor' => $c
            ]));

        }
        foreach ($mahasiswa as $mhs){
            $memilih = rand(0,1);
            if ($memilih){
                $mhs->getPemilihanBem()->attach($calon[rand(0, $jumlahCalon - 1)]);
            }
        }
    }
}
