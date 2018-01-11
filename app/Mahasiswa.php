<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mockery\Exception;

class Mahasiswa extends Authenticatable
{

    use Notifiable;

    protected $table = 'mahasiswa';

    public $timestamps = false;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id', 'prodi_id', 'nama', 'status', 'login', 'hmj', 'dpm', 'bem'
    ];

    /**
     * Mendapatkan data prodi dari salah satu mahasiswa
     * @return Model|null|static
     */
    public function prodi()
    {
        return $this->belongsTo('App\Prodi', 'prodi_id')->first();
    }

    /**
     * Mengeset remember_token
     * Tapi karena pada tabel tidak terdapat kolom remember_token,
     * maaka tidak perlu mengupdate field tersebut
     *
     * @param string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        // karena pada tabel tidak ada field remember_token
        // maka buat saja accessornya menjadi kosong
    }

    /**
     * data calon hmj
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ketuaHMJ()
    {
        return $this->hasOne('App\CalonHMJ', 'ketua_id');
    }

    /**
     * data calon hmj
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wakilHMJ()
    {
        return $this->hasOne('App\CalonHMJ', 'wakil_id');
    }

    /**
     * data calon bem
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ketuaBEM()
    {
        return $this->hasOne('App\CalonBEM', 'ketua_id');
    }

    /**
     * data calon bem
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wakilBEM()
    {
        return $this->hasOne('App\CalonBEM', 'wakil_id');
    }

    /**
     * data calon dpm
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function anggotaDPM()
    {
        return $this->hasOne('App\CalonDPM', 'anggota_id');
    }
}