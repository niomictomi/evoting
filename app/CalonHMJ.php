<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
