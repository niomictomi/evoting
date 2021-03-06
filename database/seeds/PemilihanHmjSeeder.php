<?php

use Illuminate\Database\Seeder;
use App\Mahasiswa;
use App\Jurusan;
use Carbon\Carbon;

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
                    $waktu = Carbon::now()->addHours(rand(0,7))->addMinutes(rand(0,59))->addSeconds(rand(0,59));
                    $mhs->getPemilihanHmj()->attach($calon[rand(0, $calon->count() - 1)], [
                        'created_at' => $waktu->toDateTimeString(),
                        'updated_at' => $waktu->toDateTimeString()
                    ]);
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
