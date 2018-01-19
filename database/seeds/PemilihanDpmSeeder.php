<?php

use Illuminate\Database\Seeder;
use App\CalonDPM;
use App\Mahasiswa;
use App\Jurusan;
use Carbon\Carbon;

class PemilihanDpmSeeder extends Seeder
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
            $calon = CalonDPM::getDaftarCalon($jurusan->id)->get();
            foreach ($mahasiswa as $mhs){
                $memilih = rand(0,1);
                if ($memilih){
                    $waktu = Carbon::today()->addHours(rand(7,15))->addMinutes(rand(0,59))->addSeconds(rand(0,59));
                    $mhs->getPemilihanDpm()->attach($calon[rand(0, $calon->count() - 1)], [
                        'created_at' => $waktu->toDateTimeString(),
                        'updated_at' => $waktu->toDateTimeString()
                    ]);
                    $mhs->dpm = true;
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
