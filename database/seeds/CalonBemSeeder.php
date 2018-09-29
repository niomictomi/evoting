<?php

use Illuminate\Database\Seeder;
use App\Mahasiswa;
use App\CalonHMJ;
use App\CalonDPM;
use App\CalonBEM;

class CalonBemSeeder extends Seeder
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
        $mahasiswa = Mahasiswa::getByStatus()
            ->whereNotIn('id', function ($query) {
                $query->select('ketua_id')
                    ->from('calon_hmj');
            })->whereNotIn('id', function ($query) {
                $query->select('wakil_id')
                    ->from('calon_hmj');
            })->whereNotIn('id', function ($query) {
                $query->select('anggota_id')
                    ->from('calon_dpm');
            })->get();
        $acakMahasiswa = array_rand($mahasiswa->toArray(), $jumlahCalon * 2);
        $counter = 0;
        for ($c = 0; $c < $jumlahCalon; $c++){
            CalonBEM::create([
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
