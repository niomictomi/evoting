<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CalonHMJ extends Model
{
    protected $table = 'calon_hmj';

    public $timestamps = false;

    protected $fillable = [
        'ketua_id', 'wakil_id', 'dir', 'visi', 'misi', 'nomor'
    ];

    /**
     * mengambil data mahasiswa yang memilih
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getPemilih()
    {
        return $this->belongsToMany('App\Mahasiswa','pemilihan_hmj','calon_hmj_id', 'mahasiswa_id')->withTimestamps();
    }

    /**
     * Mendapatkan relasi ke tabel Mahasiswa dilihat
     * dari id calon ketua
     *
     * @return BelongsTo
     */
    public function getRelasiKetua()
    {
        return $this->belongsTo('App\Mahasiswa','ketua_id');
    }

    /**
     * mengambil data ketua
     * @return Model|null|static
     */
    public function getKetua()
    {
        return $this->belongsTo('App\Mahasiswa','ketua_id')->first();
    }

    /**
     * mengambil data wakil
     * @return Model|null|static
     */
    public function getWakil()
    {
        return $this->belongsTo('App\Mahasiswa','wakil_id')->first();
    }

    /**
     * mendapatkan id semua calon
     * @return array
     */
    public static function getAllIdCalon($jurusan_id = null)
    {
        $id_mhs = Array();
        foreach (CalonHMJ::all() as $calon){
            if (is_null($jurusan_id)){
                array_push($id_mhs, $calon->ketua_id, $calon->wakil_id);
            }
            else{
                if ($calon->getKetua()->getProdi()->jurusan_id == $jurusan_id){
                    array_push($id_mhs, $calon->ketua_id, $calon->wakil_id);
                }
            }
        }

        return $id_mhs;
    }

    /**
     * mendapatkan semua data calon
     * @return mixed
     */
    public static function getAllCalon($jurusan_id = null)
    {
        if (is_null($jurusan_id))
            return Mahasiswa::whereIn('id', CalonHMJ::getAllIdCalon());
        return Mahasiswa::whereIn('id', CalonHMJ::getAllIdCalon($jurusan_id));
    }

    /**
     * Mendapatkan daftar calon pada jurusan tertentu
     *
     * @param int $jurusan_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getDaftarCalon($jurusan_id)
    {
        $calonHMJ = CalonHMJ::whereHas('getRelasiKetua', function ($query) use ($jurusan_id) {
            $query->whereHas('getRelasiProdi', function ($query) use ($jurusan_id) {
                $query->where('jurusan_id', $jurusan_id);
            });
        });

        return $calonHMJ;
    }

    /**
     * Mendapatkan data jumlah pemilih pada jam-jam tertentu
     * yang akan ditampilkan dalam bentuk diagram batang
     *
     * @param int $jurusan_id
     * @return array
     */
    public static function getJumlahVotingBarChart($jurusan_id)
    {
        $data = [];

        $waktuMulai = Pengaturan::getWaktuMulai()->minute == 0 ? Pengaturan::getWaktuMulai() : Pengaturan::getWaktuMulai()->addMinutes(-Pengaturan::getWaktuMulai()->minute);

        while($waktuMulai->lessThan(Pengaturan::getWaktuSelesai())) {
            // generate waktuSelesai
            $waktuSelesai = $waktuMulai->copy()->addMinutes(60);

            $jumlahVoting = Mahasiswa::getYangTelahMemilihHmjViaRelation($jurusan_id, $waktuMulai, $waktuSelesai)->count();

            array_push($data, [
                Carbon::parse($waktuMulai)->hour . ':00' . '-' . Carbon::parse($waktuSelesai)->hour . ':00',
                $jumlahVoting
            ]);

            $waktuMulai = $waktuSelesai;
        }

        return collect($data);
    }

}
