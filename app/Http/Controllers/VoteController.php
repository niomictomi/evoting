<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Controller ini akan melakukan proses voting dari pemilih
 * sesuai jenis voting
 * 
 * @author BagasMuharom <bagashidayat@mhs.unesa.ac.id|bagashidayat45@gmail.com>
 * @package Voting\Http\Controllers\Page
 */
class VoteController extends Controller
{
   
    public function __construct()
    {
        // memastikan bahwa seluruh proses voting menggunakan
        // ajax
        //$this->middleware('ajax');
    }

    /**
     * Melakukan voting untuk HMJ
     * route : mahasiswa.vote.hmj
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function voteHMJ(Request $request)
    {
        $pemilih = Auth::guard('mhs')->user();
        $terpilih = $request->terpilih;

        if($pemilih->doPilihHmj($terpilih)) {
            return response()->json([
                'message' => 'Berhasil melakukan voting !',
                'error' => false
            ]);
        };

        return response()->json([
            'message' => 'Gagal melakukan voting !',
            'error' => true
        ]);
    }

    /**
     * Melakukan voting untuk BEM
     * route : mahasiswa.vote.bem
     *
     * @param Request $request
     * @return void
     */
    public function voteBEM(Request $request)
    {
        $pemilih = Auth::guard('mhs')->user();
        $terpilih = $request->terpilih;

        if($pemilih->doPilihBem($terpilih)) {
            return response()->json([
                'message' => 'Berhasil melakukan voting !',
                'error' => false
            ]);
        };

        return response()->json([
            'message' => 'Gagal melakukan voting !',
            'error' => true
        ]);
    }

    /**
     * Melakukan voting untuk DPM
     * route : mahasiswa.vote.dpm
     *
     * @param Request $request
     * @return void
     */
    public function voteDPM(Request $request)
    {
        $pemilih = Auth::guard('mhs')->user();
        $terpilih = $request->terpilih;

        if($pemilih->doPilihDpm($terpilih)) {
            return response()->json([
                'message' => 'Berhasil melakukan voting !',
                'error' => false
            ]);
        };

        return response()->json([
            'message' => 'Gagal melakukan voting !',
            'error' => true
        ]);
    }

}
