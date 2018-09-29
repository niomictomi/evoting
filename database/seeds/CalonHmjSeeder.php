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
        $faker = \Faker\Factory::create('ID_id');
        foreach (Jurusan::all() as $jurusan){
            $jumlahCalon = rand(2, 4);
            $mahasiswa = $jurusan->getMahasiswa()
                ->where('status', Mahasiswa::AKTIF)
                ->whereNotIn('id', function ($query) {
                    $query->select('ketua_id')
                        ->from('calon_bem');
                })->whereNotIn('id', function ($query) {
                    $query->select('wakil_id')
                        ->from('calon_bem');
                })->whereNotIn('id', function ($query) {
                    $query->select('anggota_id')
                        ->from('calon_dpm');
                })->get();
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
