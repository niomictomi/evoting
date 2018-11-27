<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Yajra\DataTables\Utilities\Request;

class Mahasiswa extends Authenticatable
{
    use Notifiable;

    protected $table = 'mahasiswa';

    public $timestamps = false;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id', 'prodi_id', 'nama', 'status', 'login', 'hmj', 'dpm', 'bem', 'telah_login', 'password', 'last_login'
    ];

    const AKTIF = 'A';

    const CUTI = 'C';

    const NONAKTIF = 'N';

    const STATUS = [
        'A', 'C', 'N'
    ];

    /**
     * Mendapatkan data prodi dari salah satu mahasiswa
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getProdi($queryReturn = true)
    {
        $data = $this->belongsTo('App\Prodi', 'prodi_id');
        return $queryReturn ? $data : $data->first();
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
    public function getCalonHmj($queryReturn = true)
    {
        $calonHmjKetua = $this->hasOne('App\CalonHMJ', 'ketua_id');

        $calonHmjWakil = $this->hasOne('App\CalonHMJ', 'wakil_id');

        $data = empty($calonHmjKetua) ? $calonHmjWakil : $calonHmjKetua;

        return ($queryReturn ? $data : $data->first()) ?? null;
    }

    /**
     * data calon bem
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getCalonBem($queryReturn = true)
    {
        $calonBemKetua = $this->hasOne('App\CalonBEM', 'ketua_id');

        $calonBemWakil = $this->hasOne('App\CalonBEM', 'wakil_id');

        $data = empty($calonBemKetua) ? $calonBemWakil : $calonBemKetua;

        return ($queryReturn ? $data : $data->first()) ?? null;
    }

    /**
     * data calon dpm
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getCalonDpm($queryReturn = true)
    {
        $data = $this->hasOne('App\CalonDPM', 'anggota_id');
        return $queryReturn ? $data : $data->first();
    }

    /**
     * mendapatkan data calon hmj yang dipilih
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getPemilihanHmj($queryReturn = true)
    {
        $data = $this->belongsToMany('App\CalonHMJ', 'pemilihan_hmj', 'mahasiswa_id', 'calon_hmj_id')->withTimestamps();

        return $queryReturn ? $data : $data->first();
    }

    /**
     * mendapatkan data calon bem yang dipilih
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getPemilihanBem($queryReturn = true)
    {
        $data = $this->belongsToMany('App\CalonBEM', 'pemilihan_bem', 'mahasiswa_id', 'calon_bem_id')->withTimestamps();

        return $queryReturn ? $data : $data->first();
    }

    /**
     * mendapatkan data calon dpm yang dipilih
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getPemilihanDpm($queryReturn = true)
    {
        $data = $this->belongsToMany('App\CalonDPM', 'pemilihan_dpm', 'mahasiswa_id', 'calon_dpm_id')->withTimestamps();

        return $queryReturn ? $data : $data->first();
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
     * @param null $waktu_mulai
     * @param null $waktu_selesai
     * @return mixed
     */
    public static function getYangTelahMemilihHmjViaRelation($jurusan_id, $waktu_mulai = null, $waktu_selesai = null)
    {
        return Jurusan::find($jurusan_id)
            ->getMahasiswa()
            ->whereHas(
                'getPemilihanHmj',
                function ($query) use ($jurusan_id, $waktu_mulai, $waktu_selesai){
                    $query->when($waktu_mulai, function ($query) use ($jurusan_id, $waktu_mulai, $waktu_selesai) {
                        $query->when($waktu_selesai, function ($query) use ($jurusan_id, $waktu_mulai, $waktu_selesai) {
                            $query->whereBetween('created_at', [$waktu_mulai, $waktu_selesai]);
                        });
                    });
                }
            );
    }

    /**
     * @param $jurusan_id
     * @param null $waktu_mulai
     * @param null $waktu_selesai
     * @return mixed
     */
    public static function getYangTelahMemilihDpmViaRelation($jurusan_id, $waktu_mulai = null, $waktu_selesai = null)
    {
        return Jurusan::find($jurusan_id)
            ->getMahasiswa()
            ->whereHas(
                'getPemilihanDpm',
                function ($query) use ($jurusan_id, $waktu_mulai, $waktu_selesai){
                    $query->when($waktu_mulai, function ($query) use ($jurusan_id, $waktu_mulai, $waktu_selesai) {
                        $query->when($waktu_selesai, function ($query) use ($jurusan_id, $waktu_mulai, $waktu_selesai) {
                            $query->whereBetween('created_at', [$waktu_mulai, $waktu_selesai]);
                        });
                    });
                }
            );
    }

    /**
     * @param null $waktu_mulai
     * @param null $waktu_selesai
     * @return mixed
     */
    public static function getYangTelahMemilihBemViaRelation($waktu_mulai = null, $waktu_selesai = null)
    {
        return Mahasiswa::whereHas(
                'getPemilihanBem',
                function ($query) use ($waktu_mulai, $waktu_selesai){
                    $query->when($waktu_mulai, function ($query) use ($waktu_mulai, $waktu_selesai) {
                        $query->when($waktu_selesai, function ($query) use ($waktu_mulai, $waktu_selesai) {
                            $query->whereBetween('created_at', [$waktu_mulai, $waktu_selesai]);
                        });
                    });
                }
            );
    }

    /**
     * @param $jurusan_id
     * @return mixed
     */
    public static function getYangBelumMemilihHmjViaRelation($jurusan_id)
    {
        return Jurusan::find($jurusan_id)
            ->getMahasiswa()
            ->where('status', Mahasiswa::AKTIF)
            ->whereNotIn('id', self::getYangTelahMemilihHmjViaRelation($jurusan_id)->pluck('id'));
    }

    /**
     * @param $jurusan_id
     * @return mixed
     */
    public static function getYangBelumMemilihDpmViaRelation($jurusan_id)
    {
        return Jurusan::find($jurusan_id)
            ->getMahasiswa()
            ->where('status', Mahasiswa::AKTIF)
            ->whereNotIn('id', self::getYangTelahMemilihDpmViaRelation($jurusan_id)->pluck('id'));
    }

    /**
     * @return mixed
     */
    public static function getYangBelumMemilihBemViaRelation()
    {
        return Mahasiswa::where('status', Mahasiswa::AKTIF)
            ->whereNotIn('id', self::getYangTelahMemilihBemViaRelation()->pluck('id'));
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
     * mendapatkan mahasiswa yang abstain dalam pemilihan bem via relation
     * @return mixed
     */
    public static function getAbstainBemViaRelation()
    {
        return self::getYangBelumMemilihBemViaRelation()->where('telah_login', true);
    }

    /**
     * mendapatkan mahasiswa yang abstain dalam pemilihan dpm via relation
     * @param $jurusan_id
     * @return mixed
     */
    public static function getAbstainDpmViaRelation($jurusan_id)
    {
        return self::getYangBelumMemilihDpmViaRelation($jurusan_id)->where('telah_login', true);
    }

    /**
     * mendapatkan mahasiswa yang abstain dalam pemilihan hmj via relation
     * @param $jurusan_id
     * @return mixed
     */
    public static function getAbstainHmjViaRelation($jurusan_id)
    {
        return self::getYangBelumMemilihHmjViaRelation($jurusan_id)->where('telah_login', true);
    }

    /**
     * mendapatkan mhs yang mager
     * @param null $jurusan_id
     * @return mixed
     */
    public static function getMager($queryReturn = true, $jurusan_id = null)
    {
        $data = Mahasiswa::where('login', false)->where('telah_login', false)
            ->where('hmj', false)
            ->where('dpm', false)
            ->where('bem', false)
            ->where('status', static::AKTIF)
            ->when($jurusan_id, function ($query) use ($jurusan_id) {
                $query->whereHas('getProdi.getJurusan', function ($query) use ($jurusan_id) {
                    $query->where('id', $jurusan_id);
                });
            });

        return $queryReturn ? $data : $data->get();
    }

    public function getHMJYangDipilih($query=true)
    {
       $relation = $this->belongsToMany(CalonHMJ::class,'pemilihan_hmj','mahasiswa_id','calon_hmj_id');

       return ($query ? $relation : $relation->first());
    }

    public function getDPMYangDipilih($query=true)
    {
        $relation = $this->belongsToMany(CalonDPM::class,'pemilihan_dpm','mahasiswa_id','calon_dpm_id');

        return ($query ? $relation : $relation->first());
    }

    public function getBEMYangDipilih($query=true)
    {
        $relation = $this->belongsToMany(CalonBEM::class,'pemilihan_bem','mahasiswa_id','calon_bem_id');

        return ($query ? $relation : $relation->first());
    }
}