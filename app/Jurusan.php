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
    public function getProdi()
    {
        return $this->hasMany('App\Prodi', 'jurusan_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getMahasiswa()
    {
        return Mahasiswa::query()
            ->whereHas('getProdi.getJurusan', function ($query) {
                $query->where('id', $this->id);
            });
    }

    /**
     * mengecek apakah jurusan dengan nama tersebut ada atau tidak
     * @param $nama
     * @return bool
     */
    public static function checkByName($name)
    {
        if (Jurusan::where('nama', $name)->count() > 0)
            return true;
        return false;
    }

    /**
     * mendapatkan jurusan dengan nama
     * @param $name
     * @return mixed
     */
    public static function findByName($name)
    {
        return Jurusan::where('nama', $name)->first();
    }

    /**
     * mendapatkan data jurusan dengan md5(id)
     * @param $jurusan_id_md5
     * @return \___PHPSTORM_HELPERS\static|mixed|null
     */
    public static function findByMd5Id($jurusan_id_md5)
    {
        foreach (Jurusan::all() as $item)
            if (md5($item->id) == $jurusan_id_md5)
                return $item;
        return null;
    }
}
