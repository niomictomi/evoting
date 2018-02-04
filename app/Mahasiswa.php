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
        'id', 'prodi_id', 'nama', 'status', 'login', 'hmj', 'dpm', 'bem', 'telah_login', 'password'
    ];

    const AKTIF = 'A';

    const CUTI = 'C';

    const NONAKTIF = 'N';

    const STATUS = [
        'A', 'C', 'N'
    ];

    /**
     * Mendapatkan relasi ke tabel prodi
     * gunanya untuk bisa menggunakan whereHas
     *
     * @return BelongsTo
     */
    public function getRelasiProdi()
    {
        return $this->belongsTo('App\Prodi', 'prodi_id');
    }

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
     * 
     * @return bool
     */
    public function telahMemilihHmj()
    {
        return $this->getPemilihanHmj()->count() > 0;
    }

    /**
     * mengecek apakah telah memilih dpm atau belum via relasi tabel
     * 
     * @return bool
     */
    public function telahMemilihDpm()
    {
        return $this->getPemilihanDpm()->count() > 0;
    }

    /**
     * mengecek apakah telah memilih bem atau belum via relasi tabel
     * 
     * @return bool
     */
    public function telahMemilihBem()
    {
        return $this->getPemilihanBem()->count() > 0;
    }

    /**
     * @param $jurusan_id
     * @return mixed
     */
    public static function getYangTelahMemilihHmjViaFlag($jurusan_id)
    {
        return Jurusan::find($jurusan_id)->getMahasiswa()
            ->where('status', Mahasiswa::AKTIF)
            ->where('hmj', true)
            ->leftJoin('pemilihan_hmj', 'mahasiswa_id', '=', 'id');
    }

    /**
     * @param $jurusan_id
     * @return mixed
     */
    public static function getYangTelahMemilihDpmViaFlag($jurusan_id)
    {
        return Jurusan::find($jurusan_id)->getMahasiswa()
            ->where('status', Mahasiswa::AKTIF)
            ->where('dpm', true)
            ->leftJoin('pemilihan_dpm', 'mahasiswa_id', '=', 'id');
    }

    /**
     * @return mixed
     */
    public static function getYangTelahMemilihBemViaFlag()
    {
        return Mahasiswa::where('status', Mahasiswa::AKTIF)
            ->where('bem', true)
            ->leftJoin('pemilihan_bem', 'mahasiswa_id', '=', 'id');
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
     * @param null $waktu_mulai
     * @param null $waktu_selesai
     * @return mixed
     */
    public static function getYangTelahMemilihHmjViaRelation($jurusan_id, $waktu_mulai = null, $waktu_selesai = null)
    {
        $id_mhs = Array();
        foreach (CalonHMJ::all() as $calon){
            if ($waktu_mulai == null || $waktu_selesai == null){
                $id_mhs = array_merge($id_mhs, array_flatten($calon->getPemilih()->get()->map(function ($mhs){
                        return collect($mhs->toArray())->only(['id'])->all();
                    }))
                );
            }
            else{
                $id_mhs = array_merge($id_mhs, array_flatten($calon->getPemilih()
                        ->wherePivot('created_at','>=', $waktu_mulai)
                        ->wherePivot('created_at', '<', $waktu_selesai)
                        ->get()->map(function ($mhs){
                        return collect($mhs->toArray())->only(['id'])->all();
                    }))
                );
            }
        }

        return Jurusan::find($jurusan_id)->getMahasiswa()
            ->where('status', Mahasiswa::AKTIF)
            ->whereIn('id', $id_mhs)
            ->leftJoin('pemilihan_hmj', 'mahasiswa_id', '=', 'id');
    }

    /**
     * @param $jurusan_id
     * @param null $waktu_mulai
     * @param null $waktu_selesai
     * @return mixed
     */
    public static function getYangTelahMemilihDpmViaRelation($jurusan_id, $waktu_mulai = null, $waktu_selesai = null)
    {
        $id_mhs = Array();
        foreach (CalonDPM::all() as $calon){
            if ($waktu_mulai == null || $waktu_selesai == null){
                $id_mhs = array_merge($id_mhs, array_flatten($calon->getPemilih()->get()->map(function ($mhs){
                        return collect($mhs->toArray())->only(['id'])->all();
                    }))
                );
            }
            else{
                $id_mhs = array_merge($id_mhs, array_flatten($calon->getPemilih()
                        ->wherePivot('created_at','>=', $waktu_mulai)
                        ->wherePivot('created_at', '<=', $waktu_selesai)
                        ->get()->map(function ($mhs){
                            return collect($mhs->toArray())->only(['id'])->all();
                        }))
                );
            }
        }

        return Jurusan::find($jurusan_id)->getMahasiswa()
            ->where('status', Mahasiswa::AKTIF)
            ->whereIn('id', $id_mhs)
            ->leftJoin('pemilihan_dpm', 'mahasiswa_id', '=', 'id');
    }

    /**
     * @param null $waktu_mulai
     * @param null $waktu_selesai
     * @return mixed
     */
    public static function getYangTelahMemilihBemViaRelation($waktu_mulai = null, $waktu_selesai = null)
    {
        $id_mhs = Array();
        foreach (CalonBEM::all() as $calon){
            if ($waktu_mulai == null || $waktu_selesai == null){
                $id_mhs = array_merge($id_mhs, array_flatten($calon->getPemilih()->get()->map(function ($mhs){
                        return collect($mhs->toArray())->only(['id'])->all();
                    }))
                );
            }
            else{
                $id_mhs = array_merge($id_mhs, array_flatten($calon->getPemilih()
                        ->wherePivot('created_at','>=', $waktu_mulai)
                        ->wherePivot('created_at', '<=', $waktu_selesai)
                        ->get()->map(function ($mhs){
                            return collect($mhs->toArray())->only(['id'])->all();
                        }))
                );
            }
        }

        return Mahasiswa::getByStatus()
            ->whereIn('id', $id_mhs)
            ->leftJoin('pemilihan_bem', 'mahasiswa_id', '=', 'id');
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
        if($this->telahMemilihHmj())
            return false;

        try{
            $calon = CalonHMJ::findOrFail($calon_hmj_id);
            $this->getPemilihanHmj()->attach($calon);
            $this->hmj = true;
            $this->save();

            return true;
        }
        catch (ModelNotFoundException $exception){
            return false;
        }
    }

    /**
     * @param $calon_dpm_id
     * @return bool
     */
    public function doPilihDpm($calon_dpm_id)
    {
        if($this->telahMemilihDpm())
            return false;

        try{
            $calon = CalonDPM::find($calon_dpm_id);
            $this->getPemilihanDpm()->attach($calon);
            $this->dpm = true;
            $this->save();

            return true;
        }
        catch (ModelNotFoundException $exception){
            return false;
        }
    }

    /**
     * @param $calon_bem_id
     * @return bool
     */
    public function doPilihBem($calon_bem_id)
    {
        if($this->telahMemilihBem())
            return false;

        try{
            $calon = CalonBEM::find($calon_bem_id);
            $this->getPemilihanBem()->attach($calon);
            $this->bem = true;
            $this->save();

            return true;
        }
        catch (ModelNotFoundException $exception){
            return false;
        }
    }

    /**
     * Mengecek apakah mahasiswa adalah mahasiswa aktif, ditandai
     * dengan field status pada tabel mahasiswa bernilai 'A'
     *
     * @return boolean
     */
    public function isMahasiswaAktif()
    {
        return ($this->status === 'A');
    }

    /**
     * Mendapatkan daftar mahasiswa yang aktif
     *
     * @param $query
     * @return mixed
     */
    public function scopeAktif($query)
    {
        return $query->where('status', Mahasiswa::AKTIF);
    }

    /**
     * Mendapatkan daftar mahasiswa yang non aktif
     *
     * @param $query
     * @return mixed
     */
    public function scopeNonAktif($query)
    {
        return $query->where('status', Mahasiswa::NONAKTIF);
    }

    /**
     * Mendapatkan daftar mahasiswa yang cuti
     *
     * @param $query
     * @return mixed
     */
    public function scopeCuti($query)
    {
        return $query->where('status', Mahasiswa::CUTI);
    }

    /**
     * mendapatkan mahasiswa yang abstain dalam pemilihan bem via flag
     * @return mixed
     */
    public function getAbstainBemViaFlag()
    {
        return self::getYangBelumMemilihBemViaFlag()->where('login', true);
    }

    /**
     * mendapatkan mahasiswa yang abstain dalam pemilihan bem via relation
     * @return mixed
     */
    public function getAbstainBemViaRelation()
    {
        return self::getYangBelumMemilihBemViaRelation()->where('login', true);
    }

    /**
     * mendapatkan mahasiswa yang abstain dalam pemilihan dpm via flag
     * @param $jurusan_id
     * @return mixed
     */
    public function getAbstainDpmViaFlag($jurusan_id)
    {
        return self::getYangBelumMemilihDpmViaFlag($jurusan_id)->where('login', true);
    }
}