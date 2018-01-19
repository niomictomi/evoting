<?php

namespace App\Http\Controllers\Page;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\CalonHMJ;
use App\CalonBEM;
use App\CalonDPM;

/**
 * Controller ini berfungsi untuk menampilkan halaman
 * yang bisa diakses oleh pemilih/mahasiswa
 * 
 * @author BagasMuharom <bagashidayat@mhs.unesa.ac.id|bagashidayat45@gmail.com>
 * @package App\Http\Controllers\Page
 */
class MahasiswaController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('guest:mhs')->only('login');
        $this->middleware('votingselesai');
        $this->middleware('votingbelummulai');
    }

    /**
     * Menampilkan halaman login
     * nama routes : pemilih.login
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        return view('mahasiswa.login');
    }

    /**
     * Menampilkan halaman voting
     * nama routes : mahasiswa.halaman.voting
     *
     * @return \Illuminate\View\View
     */
    public function vote()
    {
        $calonHMJ = CalonHMJ::getDaftarCalon(Auth::guard('mhs')->user()->getProdi()->jurusan_id)->orderBy('nomor')->get();

        foreach($calonHMJ as $item) {
            $item['nama_ketua'] = $item->getKetua()->nama;
            $item['nama_wakil'] = $item->getWakil()->nama;
            $item['dir'] = asset('storage/' . $item['dir']);
        }
        
        $calonBEM = CalonBEM::orderBy('nomor')->get();

        foreach($calonBEM as $item) {
            $item['nama_ketua'] = $item->getKetua()->nama;
            $item['nama_wakil'] = $item->getWakil()->nama;
            $item['dir'] = asset('storage/' . $item['dir']);            
        }

        $calonDPM = CalonDPM::getDaftarCalon(Auth::guard('mhs')->user()->getProdi()->jurusan_id)->orderBy('nomor')->get();

        foreach($calonDPM as $item) {
            $item['nama'] = $item->getAnggota()->nama;
            $item['dir'] = asset('storage/' . $item['dir']);            
        }

        return view('mahasiswa.voting', [
            'calonHMJ' => $calonHMJ,
            'calonBEM' => $calonBEM,
            'calonDPM' => $calonDPM,
            'waktu' => Carbon::parse(session()->get('timer-end'))->addMinutes(-2),
            'tambahan' => Carbon::parse(session()->get('timer-end'))
        ]);
    }

}
