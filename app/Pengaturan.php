<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';

    protected $keyType = 'string';

    protected $primaryKey = 'key';

    public $timestamps = false;

    protected $fillable = [
        'key', 'value'
    ];

    /**
     * mendapatkan waktu mulai voting
     * @return static
     */
    public static function getWaktuMulai()
    {
        return Carbon::parse(Pengaturan::find('mulai')->value);
    }

    /**
     * mendapatkan waktu selesai voting
     * @return static
     */
    public static function getWaktuSelesai()
    {
        return Carbon::parse(Pengaturan::find('selesai')->value);
    }
}
