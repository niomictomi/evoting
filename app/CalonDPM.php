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
        return $this->belongsToMany('App\Mahasiswa','pemilihan_dpm','mahasiswa_id', 'calon_dpm_id')->withTimestamps();
    }

    /**
     * mengambil data anggota
     * @return Model|null|static
     */
    public function getAnggota()
    {
        return $this->belongsTo('App\Mahasiswa','ketua_id')->first();
    }
}
