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
}
