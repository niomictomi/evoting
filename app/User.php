<?php

namespace App;

use App\Support\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nama', 'password', 'role', 'helper', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Mengecek apakah user ini adalah admin atau bukan
     * @return bool
     */
    public function isPanitia()
    {
        return ($this->role == Role::PANITIA);
    }

    /**
     * Mengecek apakah user ini adalah ketua kpu atau bukan
     * @return bool
     */
    public function isKetuaKPU()
    {
        return ($this->role == Role::KETUA_KPU);
    }

    /**
     * Mengecek apakah user ini adalah dosen atau bukan
     * @return bool
     */
    public function isDosen()
    {
        return ($this->role == Role::DOSEN);
    }

    /**
     * Mengecek apakah user ini adalah wd1 atau bukan
     * @return bool
     */
    public function isWD3()
    {
        return ($this->role == Role::WD3);
    }

    /**
     * Mengecek apakah user ini adalah admin atau bukan
     * @return bool
     */
    public function isAdmin()
    {
        return ($this->role == Role::ADMIN);
    }

    /**
     * Mengecek apakah user ini adalah root atau bukan
     * @return bool
     */
    public function isRoot()
    {
        return ($this->role == Role::ROOT);
    }
}
