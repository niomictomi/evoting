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
        'id', 'prodi_id', 'nama', 'status', 'login', 'hmj', 'dpm', 'bem', 'telah_login'
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
    public function getProdi()
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

    /**
     * mengecek apakah telah memilih hmj atau belum via relasi tabel
     * @return bool
     */
    public function telahMemilihHmj()
    {
        if ($this->getCalonHmj()->count() > 0)
            return true;
        return false;
    }

    /**
     * mengecek apakah telah memilih dpm atau belum via relasi tabel
     * @return bool
     */
    public function telahMemilihDpm()
    {
        if ($this->getCalonDpm()->count() > 0)
            return true;
        return false;
    }

    /**
     * mengecek apakah telah memilih bem atau belum via relasi tabel
     * @return bool
     */
    public function telahMemilihBem()
    {
        if ($this->getCalonBem()->count() > 0)
            return true;
        return false;
    }

    /**
     * @param $jurusan_id
     * @return mixed
     */
    public static function getYangTelahMemilihHmjViaFlag($jurusan_id)
    {
        return Jurusan::find($jurusan_id)->getMahasiswa()
            ->where('status', Mahasiswa::AKTIF)
            ->where('hmj', true);
    }

    /**
     * @param $jurusan_id
     * @return mixed
     */
    public static function getYangTelahMemilihDpmViaFlag($jurusan_id)
    {
        return Jurusan::find($jurusan_id)->getMahasiswa()
            ->where('status', Mahasiswa::AKTIF)
            ->where('dpm', true);
    }

    /**
     * @return mixed
     */
    public static function getYangTelahMemilihBemViaFlag()
    {
        return Mahasiswa::where('status', Mahasiswa::AKTIF)
            ->where('bem', true);
    }

    /**
     * @param $jurusan_id
     * @return mixed
     */
    public static function getYangBelumMemilihHmjViaFlag($jurusan_id)
    {
        return Jurusan::find($jurusan_id)->getMahasiswa()
            ->where('status', Mahasiswa::AKTIF)
            ->where('hmj', false);
    }

    /**
     * @param $jurusan_id
     * @return mixed
     */
    public static function getYangBelumMemilihHmjViaRelation($jurusan_id)
    {
        $id_mhs = Array();
        foreach (CalonHMJ::all() as $calon){
            $id_mhs = array_merge($id_mhs, array_flatten($calon->getPemilih()->get()->map(function ($mhs){
                    return collect($mhs->toArray())->only(['id'])->all();
                }))
            );
        }

        return Jurusan::find($jurusan_id)->getMahasiswa()
            ->where('status', Mahasiswa::AKTIF)
            ->whereNotIn('id', $id_mhs);
    }

    /**
     * @param $jurusan_id
     * @return mixed
     */
    public static function getYangBelumMemilihDpmViaFlag($jurusan_id)
    {
        return Jurusan::find($jurusan_id)->getMahasiswa()
            ->where('status', Mahasiswa::AKTIF)
            ->where('dpm', false);
    }

    /**
     * @param $jurusan_id
     * @return mixed
     */
    public static function getYangBelumMemilihDpmViaRelation($jurusan_id)
    {
        $id_mhs = Array();
        foreach (CalonDPM::all() as $calon){
            $id_mhs = array_merge($id_mhs, array_flatten($calon->getPemilih()->get()->map(function ($mhs){
                    return collect($mhs->toArray())->only(['id'])->all();
                }))
            );
        }

        return Jurusan::find($jurusan_id)->getMahasiswa()
            ->where('status', Mahasiswa::AKTIF)
            ->whereNotIn('id', $id_mhs);
    }

    /**
     * @return mixed
     */
    public static function getYangBelumMemilihBemViaFlag()
    {
        return Mahasiswa::where('status', Mahasiswa::AKTIF)
            ->where('bem', false);
    }

    /**
     * @return mixed
     */
    public static function getYangBelumMemilihBemViaRelation()
    {
        $id_mhs = Array();
        foreach (CalonBEM::all() as $calon){
            $id_mhs = array_merge($id_mhs, array_flatten($calon->getPemilih()->get()->map(function ($mhs){
                    return collect($mhs->toArray())->only(['id'])->all();
                }))
            );
        }

        return Mahasiswa::where('status', Mahasiswa::AKTIF)
            ->whereNotIn('id', $id_mhs);
    }

    /**
     * @param $calon_hmj_id
     * @return bool
     */
    public function doPilihHmj($calon_hmj_id)
    {
        try{
            $calon = CalonHMJ::find($calon_hmj_id);
            $this->getCalonHmj()->attach($calon);
            $this->hmj = true;
            $this->save();

            return true;
        }
        catch (Exception $exception){
            return false;
        }
    }

    /**
     * @param $calon_hmj_id
     * @return bool
     */
    public function doPilihDpm($calon_dpm_id)
    {
        try{
            $calon = CalonDPM::find($calon_dpm_id);
            $this->getCalonDpm()->attach($calon);
            $this->dpm = true;
            $this->save();

            return true;
        }
        catch (Exception $exception){
            return false;
        }
    }
}