<?php
/**
 * Created by PhpStorm.
 * User: Rafy
 * Date: 11/01/2018
 * Time: 15.41
 */

namespace App\Support;


class Role
{
    const ROOT = 'root';

    const ADMIN = 'admin';

    const WD3 = 'wd3';

    const DOSEN = 'dosen';

    const KETUA_KPU = 'ketua kpu';

    const PANITIA = 'panitia';

    const ALL = [
        'panitia',
        'ketua kpu',
        'dosen',
        'wd3',
        'admin',
        'root'
    ];
}