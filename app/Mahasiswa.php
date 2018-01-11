<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mockery\Exception;

class Mahasiswa extends Authenticatable
{

    use Notifiable;

    protected $table = 'mahasiswa';

    public $timestamps = false;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'prodi_id', 'nama', 'bisa_memilih'
    ];

    /**
     * Mendapatkan data prodi dari salah satu mahasiswa
     * @return Model|null|static
     */
    public function prodi()
    {
        return $this->belongsTo('Voting\Prodi', 'prodi_id')->first();
    }

    /**
     * Mengeset remember_token
     * Tapi karena pada tabel tidak terdapat kolom remember_token,
     * maaka tidak perlu mengupdate field tersebut
     *
     * @param string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        // karena pada tabel tidak ada field remember_token
        // maka buat saja accessornya menjadi kosong
    }
}