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

    public function votingBem(Request $request)
    {
        if (!in_array($request->tipe, ['Memiliki hak suara', 'Telah memberikan hak suara', 'Belum memberikan hak suara']))
            $request->tipe = 'Memiliki hak suara';
        $cek = Pengaturan::isVotingSedangBerlangsung() || Pengaturan::isVotingTelahBerlangsung();
        return view('admin.public.votingbem', [
            'cek' => $cek,
            'tipe' => $request->tipe
        ]);
    }

    public function getDataPemilihHmj(Request $request)
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

    public function getDataPemilihDpm(Request $request)
    {
        $data = null;
        $jurusan = Jurusan::findByMd5Id($request->id);
        if ($request->status == md5('Telah memberikan hak suara'))
            $data = Mahasiswa::getYangTelahMemilihDpmViaFlag($jurusan->id);
        elseif ($request->status == md5('Belum memberikan hak suara'))
            $data = Mahasiswa::getYangBelumMemilihDpmViaFlag($jurusan->id);
        else
            $data = $jurusan->getMahasiswa()->where('status', 'A');

        return DataTables::of($data)->addColumn('prodi', function (Mahasiswa $mahasiswa){
            return $mahasiswa->getProdi()->nama;
        })->make(true);
    }

    public function getDataPemilihBem(Request $request)
    {
        $data = null;
        if ($request->status == md5('Telah memberikan hak suara'))
            $data = Mahasiswa::getYangTelahMemilihBemViaFlag();
        elseif ($request->status == md5('Belum memberikan hak suara'))
            $data = Mahasiswa::getYangBelumMemilihBemViaFlag();
        else
            $data = Mahasiswa::getByStatus();

        return DataTables::of($data)->addColumn('prodi', function (Mahasiswa $mahasiswa){
            return $mahasiswa->getProdi()->nama;
        })->make(true);
    }

    public function pengaturanVoting()
    {
        $mulai = Carbon::parse(Pengaturan::getWaktuMulai())->toDateTimeString();
        $selesai = Carbon::parse(Pengaturan::getWaktuSelesai())->toDateTimeString();
        if ($mulai == $selesai){
            $mulai = null;
            $selesai = null;
        }
        return view('admin.public.pengaturanvoting', [
            'mulai' => $mulai,
            'selesai' => $selesai
        ]);
    }

    public function updatePengaturanVoting(Request $request)
    {
        $this->validate($request, [
            'mulai' => 'required',
            'selesai' => 'required'
        ]);

        if ($request->mulai == $request->selesai)
            return back()->withErrors(['Waktu mulai dan waktu selesai tidak boleh sama!']);
        $mulai = Carbon::parse($request->mulai);
        $selesai = Carbon::parse($request->selesai);
        if (!$mulai->lessThan($selesai))
            return back()->withErrors(['Waktu mulai harus sebelum waktu selesai!']);
        Pengaturan::find('mulai')->update([
            'value' => $mulai
        ]);
        Pengaturan::find('selesai')->update([
            'value' => $selesai
        ]);

        return back()->with('message', 'Waktu mulai dan selesai telah berhasil diatur.');
    }
}
