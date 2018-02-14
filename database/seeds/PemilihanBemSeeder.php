<?php

use Illuminate\Database\Seeder;
use App\CalonBEM;
use App\Mahasiswa;
use Carbon\Carbon;

class PemilihanBemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $calon = CalonBEM::all();
        foreach (Mahasiswa::getByStatus()->get() as $mhs){
            $memilih = rand(0,1);
            if ($memilih){
                $waktu = Carbon::today()->addHours(rand(7,15))->addMinutes(rand(0,59))->addSeconds(rand(0,59));
                $mhs->getPemilihanBem()->attach($calon[rand(0, $calon->count() - 1)], [
                    'created_at' => $waktu->toDateTimeString(),
                    'updated_at' => $waktu->toDateTimeString()
                ]);
                $mhs->bem = true;
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
