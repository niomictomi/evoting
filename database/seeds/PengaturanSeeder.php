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
            'value' => Carbon::today()->toDateTimeString()
        ]);

        Pengaturan::create([
            'key' => 'selesai',
            'value' => Carbon::today()->addHours(23)->toDateTimeString()
        ]);
    }
}
