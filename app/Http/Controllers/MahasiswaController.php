<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Mahasiswa;
use App\Prodi;

class MahasiswaController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('hakakses:root')->only('tambahDariFile');
        $this->middleware('ajax')->only('daftar');
    }

    /**
     * Menambah mahasiswa baru dari file excel atau csv
     * nama route : root.tambah.mahasiswa
     * @return void
     */
    public function tambahDariFile(Request $request)
    {
        $this->validate($request, [
            'berkas' => 'required|file|mimes:csv,xls,xlsx'
        ]);

        $excel = App::make('excel');
        $files = null;

        try {
            $files = $excel->load($request->file('berkas')->getRealPath())->get();
        } catch(\Exception $e) {
            return 'Tidak dapat membaca file !';
        }

        foreach($files as $row) {
            Mahasiswa::create([
                'id' => $row['nim'],
                'nama' => $row['nama'],
                'status' => $row['status'],
                'prodi_id' => Prodi::where('nama', $row['prodi'])->first()->id,
            ]);
        }

        return 'Berhasil menambah data !';
    }

    public function tambah(Request $request)
    {
        $this->validate($request, [
            'nim' => 'required|numeric|digits:11|unique:mahasiswa',
            'nama' => 'required|unique:mahasiswa',
            'status' => 'required|in:A,C,N',
            'prodi' => [
                'required',
                'numeric',
                Rule::in(Prodi::all()->pluck('id')->toArray())]
        ]);

        Mahasiswa::create([
            'id' => $request->nim,
            'nama' => $request->nama,
            'status' => $request->status,
            'prodi_id' => $request->prodi
        ]);

        return back()->with([
            'success' => 'Berhasil menambahkan data baru !'
        ]);
    }

    public function daftar(Request $request)
    {
        return dataTables()->eloquent(Mahasiswa::query())
                ->editColumn('prodi_id', function (Mahasiswa $mahasiswa) {
                    return $mahasiswa->getProdi()->nama;
                })->make(true);
    }

}
