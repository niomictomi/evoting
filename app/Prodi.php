<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $table = 'prodi';

    public $timestamps = false;

    protected $fillable = [
        'nama', 'jurusan_id'
    ];

    /**
     * Mendapatkan data mahasiswa dengan prodi ini
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mahasiswa()
    {
        return $this->hasMany('Voting\Mahasiswa', 'prodi_id');
    }

    /**
     * Mendapatkan data jurusan dari prodi ini
     * @return Model|null|static
     */
    public function jurusan()
    {
        return $this->belongsTo('Voting\Jurusan', 'jurusan_id')->first();
    }

    /**
     * Mendapatkan data prodi dari nama
     * @param $nama
     * @return mixed
     */
    public static function getByName($nama)
    {
        return Prodi::where('nama', $nama)->first();
    }
}
