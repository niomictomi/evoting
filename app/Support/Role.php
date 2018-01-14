<?php
/**
 * Created by PhpStorm.
 * User: Rafy
 * Date: 11/01/2018
 * Time: 15.41
 */

namespace App\Support;


use App\User;

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
        Role::PANITIA_KPU,
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

    /**
     * mengecek apakah ketua kpu telah ada tau tidak
     * @return bool
     */
    public static function checkIfKetuaKpuExists()
    {
        return User::whereIn('role', [Role::KETUA_KPU])->count() > 0;
    }

    /**
     * mengecek apakah wd3 telah ada tau tidak
     * @return bool
     */
    public static function checkIfWd3Exists()
    {
        return User::whereIn('role', [Role::WD3])->count() > 0;
    }
}