<?php
/**
 * Created by PhpStorm.
 * User: rafya
 * Date: 28/09/2018
 * Time: 20:55
 */

namespace App\Support;

use App\Mahasiswa;

class Helper
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getDuplicatePemilihanDpm($queryReturn = true)
    {
        $data = Mahasiswa::query()
            ->whereIn('id', function ($query) {
                $query->select('mahasiswa_id')
                    ->from('pemilihan_dpm')
                    ->groupBy('mahasiswa_id')
                    ->havingRaw('count(*) > 1');
            });

        return $queryReturn ? $data : $data->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getDuplicatePemilihanHmj($queryReturn = true)
    {
        $data = Mahasiswa::query()
            ->whereIn('id', function ($query) {
                $query->select('mahasiswa_id')
                    ->from('pemilihan_hmj')
                    ->groupBy('mahasiswa_id')
                    ->havingRaw('count(*) > 1');
            });

        return $queryReturn ? $data : $data->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getDuplicatePemilihanBem($queryReturn = true)
    {
        $data = Mahasiswa::query()
            ->whereIn('id', function ($query) {
                $query->select('mahasiswa_id')
                    ->from('pemilihan_bem')
                    ->groupBy('mahasiswa_id')
                    ->havingRaw('count(*) > 1');
            });

        return $queryReturn ? $data : $data->get();
    }
}