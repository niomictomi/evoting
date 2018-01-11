<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'key', 'value'
    ];
}
