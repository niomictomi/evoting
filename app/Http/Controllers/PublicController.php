<?php

namespace App\Http\Controllers;

use App\Jurusan;
use App\Mahasiswa;
use App\Pengaturan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Yajra\DataTables\DataTables;

class PublicController extends Controller
{
    public function votingHmjDpm(Request $request)
    {
        if (!Jurusan::checkByName($request->jurusan))
            return back()->withErrors([
                'Jurusan '.$request->jurusan.' tidak ada!',
                'Coba klik lagi menu yang anda inginkan'
            ]);
        if (!in_array($request->tipe, ['Memiliki hak suara', 'Telah memberikan hak suara', 'Belum memberikan hak suara']))
            $request->tipe = 'Memiliki hak suara';
        $cek = Pengaturan::isVotingSedangBerlangsung() || Pengaturan::isVotingTelahBerlangsung();
        $blade = (\Route::currentRouteName() == 'admin.voting.hmj') ? 'admin.public.votinghmj' : 'admin.public.votingdpm';
        return view($blade, [
            'cek' => $cek,
            'jurusanobject' => Jurusan::findByName($request->jurusan),
            'jurusans' => Jurusan::all(),
            'jurusan' => $request->jurusan,
            'tipe' => $request->tipe
        ]);
    }

    public function getDataPemilihHmjDpm(Request $request)
    {
        $data = null;
        $jurusan = Jurusan::findByMd5Id($request->id);
        if ($request->status == md5('Telah memberikan hak suara'))
            $data = Mahasiswa::getYangTelahMemilihHmjViaFlag($jurusan->id);
        elseif ($request->status == md5('Belum memberikan hak suara'))
            $data = Mahasiswa::getYangBelumMemilihHmjViaFlag($jurusan->id);
        else
            $data = $jurusan->getMahasiswa()->where('status', 'A');

        return DataTables::of($data)->addColumn('prodi', function (Mahasiswa $mahasiswa){
            return $mahasiswa->getProdi()->nama;
        })->make(true);
    }
}
