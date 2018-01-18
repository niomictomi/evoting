<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalonDPM extends Model
{
    protected $table = 'calon_dpm';

    public $timestamps = false;

    protected $fillable = [
        'anggota_id', 'dir', 'visi', 'misi', 'nomor'
    ];

    /**
     * mengambil data mahasiswa yang memilih
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getPemilih()
    {
        return $this->belongsToMany('App\Mahasiswa','pemilihan_dpm','calon_dpm_id', 'mahasiswa_id')->withTimestamps();
    }

    /**
     * Mendapatkan relasi ke tabel mahasiswa berdasarkan
     * id anggota
     *
     * @return void
     */
    public function getRelasiAnggota()
    {
        return $this->belongsTo('App\Mahasiswa', 'anggota_id');
    }

    /**
     * mengambil data anggota
     * @return Model|null|static
     */
    public function getAnggota()
    {
        return $this->belongsTo('App\Mahasiswa', 'anggota_id')->first();
    }

    /**
     * mendapatkan id semua calon
     * @return array
     */
    public static function getAllIdAnggota($jurusan_id = null)
    {
        $id_mhs = Array();
        foreach (CalonDPM::all() as $calon){
            if (is_null($jurusan_id)){
                array_push($id_mhs, $calon->anggota_id);
            }
            else{
                if ($calon->getKetua()->getProdi()->jurusan_id == $jurusan_id){
                    array_push($id_mhs, $calon->anggota_id);
                }
            }
        }

        return $id_mhs;
    }

    /**
     * mendapatkan semua data calon
     * @return mixed
     */
    public static function getAllAnggota($jurusan_id = null)
    {
        if (is_null($jurusan_id))
            return Mahasiswa::whereIn('id', CalonDPM::getAllIdAnggota());
        return Mahasiswa::whereIn('id', CalonDPM::getAllIdAnggota($jurusan_id));
    }

    /**
     * Mendapatkan daftar calon anggota dpm pada jurusan tertentu
     *
     * @param int $jurusan_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getDaftarCalon($jurusan_id)
    {  
        $calonDPM = CalonDPM::whereHas('getRelasiAnggota', function ($query) use($jurusan_id) {
            $query->whereHas('getRelasiProdi', function ($query) use ($jurusan_id) {
                $query->where('jurusan_id', $jurusan_id);
            });
        });

        return $calonDPM;
    }

    /**
     * Mendapatkan hasil dalam bentuk array yang nantinya akan digunakan
     * untuk diagram
     *
     * @param int $jurusan_id
     * @return array
     */
    public static function getHasilUntukDiagram($jurusan_id)
    {
        $data = [];
        $daftar_calon = static::getDaftarCalon($jurusan_id)->get();

        foreach($daftar_calon as $calon) {
            $data['Nomor Paslon ' . $calon->nomor] = $calon->getPemilih()->count();
        }

        return $data;
    }

}
