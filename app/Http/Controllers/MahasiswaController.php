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

}
