<?php

use Illuminate\Database\Seeder;
use App\CalonDPM;
use App\CalonHMJ;
use App\CalonBEM;
use App\Jurusan;
use App\Mahasiswa;

class CalonDpmSeeder extends Seeder
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
                ->where('status', Mahasiswa::AKTIF)
                ->whereNotIn('id', function ($query) {
                    $query->select('ketua_id')
                        ->from('calon_hmj');
                })->whereNotIn('id', function ($query) {
                    $query->select('wakil_id')
                        ->from('calon_hmj');
                })->whereNotIn('id', function ($query) {
                    $query->select('ketua_id')
                        ->from('calon_bem');
                })->whereNotIn('id', function ($query) {
                    $query->select('wakil_id')
                        ->from('calon_bem');
                })->get();
            $acakMahasiswa = array_rand($mahasiswa->toArray(), $jumlahCalon);
            for ($c = 0; $c < $jumlahCalon; $c++){
                CalonDPM::create([
                    'anggota_id' => $mahasiswa->toArray()[$acakMahasiswa[$c]]['id'],
                    'dir' => 'http://www.voa-islam.com/photos5/GXaPe9UdAH.png',
                    'visi' => $faker->unique()->text,
                    'misi' => $faker->unique()->text(600),
                    'nomor' => $c + 1
                ]);
            }
        }
    }
}
