<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusan';

    public $timestamps = false;

    protected $fillable = [
        'nama'
    ];

    /**
     * Mendapatkan, memasukkan dan menghapus data prodi
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prodi()
    {
        return $this->hasMany('App\Prodi', 'jurusan_id');
    }

    /**
     * mendapatkan data mahasiswa dari jurusan tertentu
     * @return mixed
     */
    public function getMahasiswa()
    {
        $id_mhs = Array();
        foreach ($this->prodi()->get() as $prodi){
            $id_mhs = array_merge($id_mhs, array_flatten($prodi->mahasiswa()->get()->map(function ($mhs){
                return collect($mhs->toArray())->only(['id'])->all();
            })));
        }

        return Mahasiswa::whereIn('id', $id_mhs);
    }
}
