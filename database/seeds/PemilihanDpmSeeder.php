<?php

use Illuminate\Database\Seeder;
use App\CalonBEM;
use App\CalonDPM;
use App\Mahasiswa;
use App\Jurusan;

class PemilihanDpmSeeder extends Seeder
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
            $jumlahCalon = rand(2, 5);
            $mahasiswa = $jurusan->getMahasiswa()
                ->whereIn('status', [Mahasiswa::AKTIF])
                ->whereNotIn('id', CalonBEM::getAllIdCalon())
                ->get();
            $acakMahasiswa = array_rand($mahasiswa->toArray(), $jumlahCalon);
            $counter = 0;
            $calon = Array();
            for ($c = 0; $c < $jumlahCalon; $c++){
                array_push($calon, CalonDPM::create([
                    'anggota_id' => $mahasiswa->toArray()[$acakMahasiswa[$counter++]]['id'],
                    'dir' => 'http://www.voa-islam.com/photos5/GXaPe9UdAH.png',
                    'visi' => $faker->unique()->text,
                    'misi' => $faker->unique()->text(600),
                    'nomor' => $c
                ]));

            }
            foreach ($mahasiswa as $mhs){
                $memilih = rand(0,1);
                if ($memilih){
                    $mhs->getPemilihanDpm()->attach($calon[rand(0, $jumlahCalon - 1)]);
                    $mhs->dpm = true;
                    $mhs->telah_login = true;
                    $mhs->save();
                }
                else{
                    $telah_login = rand(0,1);
                    if ($telah_login){
                        $mhs->telah_login = true;
                        $mhs->save();
                    }
                }
            }
        }
    }
}
