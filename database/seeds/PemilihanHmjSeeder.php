<?php

use Illuminate\Database\Seeder;
use App\CalonDPM;
use App\CalonBEM;
use App\CalonHMJ;
use App\Mahasiswa;
use App\Jurusan;

class PemilihanHmjSeeder extends Seeder
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
            $calon = Array();
            for ($c = 0; $c < $jumlahCalon; $c++){
                array_push($calon, CalonHMJ::create([
                    'ketua_id' => $mahasiswa->toArray()[$acakMahasiswa[$counter++]]['id'],
                    'wakil_id' => $mahasiswa->toArray()[$acakMahasiswa[$counter++]]['id'],
                    'dir' => 'http://www.voa-islam.com/photos5/GXaPe9UdAH.png',
                    'visi' => $faker->unique()->text,
                    'misi' => $faker->unique()->text(600),
                    'nomor' => $c + 1
                ]));

            }
            foreach ($mahasiswa as $mhs){
                $memilih = rand(0,1);
                if ($memilih){
                    $mhs->getPemilihanHmj()->attach($calon[rand(0, $jumlahCalon - 1)]);
                    $mhs->hmj = true;
                    $mhs->telah_login = true;
                    $mhs->password = bcrypt('12345');
                    $mhs->save();
                }
                else{
                    $telah_login = rand(0,1);
                    if ($telah_login){
                        $mhs->telah_login = true;
                        $mhs->password = bcrypt('12345');
                        $mhs->save();
                    }
                }
            }
        }
    }
}
