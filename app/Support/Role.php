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
        Role::PANITIA,
        Role::KETUA_KPU,
        Role::DOSEN,
        Role::WD3,
        Role::ADMIN,
        Role::ROOT
    ];

    const PANITIA_KPU = 'kpu';

    const PANITIA_BAWASLU = 'bawaslu';

    const PANITIA_KPS = 'kps';

    const PANITIA_ALL = [
        Role::KETUA_KPU,
        Role::PANITIA_BAWASLU,
        Role::PANITIA_KPS
    ];

    /**
     * mengecek apakah role ada atau tidak
     * @param $role_name
     * @param null $delimitter
     * @return bool
     */
    public static function check($role_name, $delimitter = null)
    {
        if (is_null($delimitter)){
            if (in_array($role_name, Role::ALL)){
                return true;
            }
        }
        else{
            if (in_array(explode($delimitter, $role_name)[0], Role::ALL)){
                if (in_array(explode($delimitter, $role_name)[1], Role::PANITIA_ALL)){
                    return true;
                }
            }
        }

        return false;
    }
}