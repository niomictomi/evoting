<?php

use Illuminate\Database\Seeder;
use App\CalonBEM;
use App\Mahasiswa;

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
        foreach (Mahasiswa::all() as $mhs){
            $memilih = rand(0,1);
            if ($memilih){
                $mhs->getPemilihanBem()->attach($calon[rand(0, $calon->count() - 1)]);
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
