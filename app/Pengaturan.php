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

    /**
     * mengecek apakah voting sedang berlangsung atau tidak
     * @return bool
     */
    public static function isVotingSedangBerlangsung()
    {
        $sekarang = Carbon::now();
        return $sekarang->greaterThanOrEqualTo(self::getWaktuMulai()) && $sekarang->lessThanOrEqualTo(self::getWaktuSelesai());
    }

    /**
     * mengecek apakah voting telah berlangsung atau tidak
     * @return bool
     */
    public static function isVotingTelahBerlangsung()
    {
        return Carbon::now()->greaterThan(self::getWaktuSelesai());
    }

    /**
     * mengecek apakah voting akan berlangsung atau tidak
     * @return bool
     */
    public static function isVotingAkanBerlangsung()
    {
        return Carbon::now()->lessThan(self::getWaktuMulai());
    }

    /**
     * mendapatkan status voting
     * @return string
     */
    public static function getStatusVoting()
    {
        if (Pengaturan::find('mulai')->value == '' || Pengaturan::find('selesai')->value == '')
            return 'Anda belum mengatur waktu voting.';
        if (self::isVotingSedangBerlangsung())
            return 'Voting sedang berlangsung.';
        if (self::isVotingAkanBerlangsung())
            return 'Voting akan dimulai '.self::getWaktuMulai()->diffForHumans().'.';
        return 'Voting telah berlangsung '.self::getWaktuSelesai()->diffForHumans().'.';
    }
}
