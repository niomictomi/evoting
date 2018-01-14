<?php

use Illuminate\Database\Seeder;
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
        foreach (Jurusan::all() as $jurusan){
            $mahasiswa = $jurusan->getMahasiswa()
                ->whereIn('status', [Mahasiswa::AKTIF])
                ->get();
            $calon = \App\CalonHMJ::getDaftarCalon($jurusan->id)->get();
            foreach ($mahasiswa as $mhs){
                $memilih = rand(0,1);
                if ($memilih){
                    $mhs->getPemilihanHmj()->attach($calon[rand(0, $calon->count() - 1)]);
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
