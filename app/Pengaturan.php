<?php

namespace App;

use App\Support\Role;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

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

    /**
     * @return bool
     */
    public static function checkPasswordBukaHasil()
    {
        $users = User::whereIn('role', [Role::KETUA_KPU, Role::WD3, Role::DOSEN])->get();
        foreach ($users as $user){
            if ($user->helper == null || $user->helper != 'secret')
                return false;
        }

        return true;
    }

    /**
     * @param $user_id
     * @param $password
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function bukaHasil($user_id, $password)
    {
        if (self::checkPasswordBukaHasil()){
            $user = User::find($user_id);
            if (Hash::check($password, $user->helper)){
                $user->helper = 'secret';
                $user->save();
            }
            else{
                return back()->with('error', 'Kata sandi anda salah!');
            }
            if (self::checkPasswordBukaHasil()){
                Pengaturan::find('buka_hasil')->update(['value' => true]);
                return back()->with('message', 'Kotak suara telah dibuka!');
            }
            return back()->with('message', 'Password telah sesuai.');
        }
        return back()->with('message', 'Anda telah menginputkan semua password dan kotak suara bisa dibuka.');
    }
}
