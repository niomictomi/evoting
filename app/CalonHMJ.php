<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalonHMJ extends Model
{
    protected $table = 'calon_hmj';

    public $timestamps = false;

    protected $fillable = [
        'ketua_id', 'wakil_id', 'dir', 'visi', 'misi'
    ];

    /**
     * mengambil data mahasiswa yang memilih
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getMahasiswa()
    {
        return $this->belongsToMany('App\Mahasiswa','pemilihan_hmj','mahasiswa_id', 'calon_hmj_id')->withTimestamps();
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
}
