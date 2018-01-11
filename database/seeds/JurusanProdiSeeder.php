<?php

use Illuminate\Database\Seeder;
use App\Jurusan;
use App\Prodi;

class JurusanProdiSeeder extends Seeder
{
    const EKONOMI = [
        'Pendidikan Ekonomi' => [
            'S1 Pendidikan Ekonomi',
            'S1 Pendidikan Administrasi Perkantoran',
            'S1 Pendidikan Akuntansi',
            'S1 Pendidikan Tata Niaga',
        ],
        'Manajemen' => [
            'S1 Manajemen',
        ],
        'Akutansi' => [
            'S1 Akuntansi',
            'D3 Akuntansi'
        ],
        'Ilmu Ekonomi' => [
            'S1 Ekonomi Islam',
            'S1 Ilmu Ekonomi'
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (static::EKONOMI as $jurusan => $daftarProdi){
            $id = Jurusan::create([
                'nama' => $jurusan
            ])->id;
            foreach ($daftarProdi as $prodi){
                Prodi::create([
                    'nama' => $prodi,
                    'jurusan_id' => $id
                ]);
            }
        }
    }
}
