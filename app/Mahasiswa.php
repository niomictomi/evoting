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

    const AKTIF = 'A';

    const CUTI = 'C';

    const NONAKTIF = 'N';

    const STATUS = [
        'A', 'C', 'N'
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
     * mengambil data calon hmj
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getCalonHmj()
    {
        $calonHmj = $this->hasOne('App\CalonHMJ', 'ketua_id');
        if (is_null($calonHmj)){
            $calonHmj = $this->hasOne('App\CalonHMJ', 'wakil_id');
        }

        return $calonHmj;
    }

    /**
     * data calon bem
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getCalonBem()
    {
        $calonBem = $this->hasOne('App\CalonBEM', 'ketua_id');
        if (is_null($calonBem)){
            $calonHmj = $this->hasOne('App\CalonBEM', 'wakil_id');
        }

        return $calonBem;
    }

    /**
     * data calon dpm
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getCalonDpm()
    {
        return $this->hasOne('App\CalonDPM', 'anggota_id');
    }

    /**
     * mendapatkan data calon hmj yang dipilih
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getPemilihanHmj()
    {
        return $this->belongsToMany('App\CalonHMJ', 'pemilihan_hmj', 'mahasiswa_id', 'calon_hmj_id')->withTimestamps();
    }

    /**
     * mendapatkan data calon bem yang dipilih
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getPemilihanBem()
    {
        return $this->belongsToMany('App\CalonBEM', 'pemilihan_bem', 'mahasiswa_id', 'calon_bem_id')->withTimestamps();
    }

    /**
     * mendapatkan data calon dpm yang dipilih
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getPemilihanDpm()
    {
        return $this->belongsToMany('App\CalonDPM', 'pemilihan_dpm', 'mahasiswa_id', 'calon_dpm_id')->withTimestamps();
    }

    /**
     * mendapatkan mahasiswa dengan status
     * @param array $status
     * @return mixed
     */
    public static function getByStatus($status = Array(Mahasiswa::AKTIF))
    {
        return Mahasiswa::whereIn('status', $status);
    }
}