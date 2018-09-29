<?php

use Illuminate\Database\Seeder;
use App\Pengaturan;
use Carbon\Carbon;

class PengaturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pengaturan::create([
            'key' => 'mulai',
            'value' => Carbon::now()->addMinutes(5)->toDateTimeString()
        ]);

        Pengaturan::create([
            'key' => 'selesai',
            'value' => Carbon::now()->addMinutes(5)->addHours(8)->toDateTimeString()
        ]);

        Pengaturan::create([
            'key' => 'buka_hasil',
            'value' => false
        ]);

        Pengaturan::create([
            'key' => 'mhs_max_password',
            'value' => 8
        ]);
    }
}
