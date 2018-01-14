<?php

use Illuminate\Database\Seeder;
use App\CalonHMJ;
use App\CalonBEM;
use App\CalonDPM;
use App\Jurusan;
use App\Mahasiswa;

class CalonHmjSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        foreach (Jurusan::all() as $jurusan){
            $jumlahCalon = rand(2, 4);
            $mahasiswa = $jurusan->getMahasiswa()
                ->whereIn('status', [Mahasiswa::AKTIF])
                ->whereNotIn('id', CalonBEM::getAllIdCalon())
                ->whereNotIn('id', CalonDPM::getAllIdAnggota())
                ->get();
            $acakMahasiswa = array_rand($mahasiswa->toArray(), $jumlahCalon * 2);
            $counter = 0;
            for ($c = 0; $c < $jumlahCalon; $c++){
                CalonHMJ::create([
                    'ketua_id' => $mahasiswa->toArray()[$acakMahasiswa[$counter++]]['id'],
                    'wakil_id' => $mahasiswa->toArray()[$acakMahasiswa[$counter++]]['id'],
                    'dir' => 'http://www.voa-islam.com/photos5/GXaPe9UdAH.png',
                    'visi' => $faker->unique()->text,
                    'misi' => $faker->unique()->text(600),
                    'nomor' => $c + 1
                ]);

            }
        }
    }
}
