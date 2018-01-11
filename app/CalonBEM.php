<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalonBEM extends Model
{
    protected $table = 'calon_bem';

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
        return $this->belongsToMany('App\Mahasiswa','pemilihan_bem','mahasiswa_id', 'calon_bem_id')->withTimestamps();
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
