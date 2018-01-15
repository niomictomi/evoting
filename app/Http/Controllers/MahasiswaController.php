<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
            return back()->with('error', 'Tidak dapat membaca file !');
        }

        $jumlahDitambah = 0;

        foreach($files as $row) {
            try {
                $mahasiswa = Mahasiswa::findOrFail($row['nim']);
            }
            catch(ModelNotFoundException $e) {
                Mahasiswa::create([
                    'id' => $row['nim'],
                    'nama' => $row['nama'],
                    'status' => $row['status'],
                    'prodi_id' => Prodi::where('nama', $row['prodi'])->first()->id,
                ]);
                $jumlahDitambah++;
            }
        }

        if($jumlahDitambah > 0)
            return back()->with('success', 'Berhasil menambah ' . $jumlahDitambah . ' data !');
        else
            return back()->with('error', 'Tidak ada data yang ditambah !');
    }

    /**
     * Menambah satu data mahasiswa baru
     *
     * @param Request $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function tambah(Request $request)
    {
        $this->validate($request, [
            'nim' => 'required|numeric|digits:11|unique:mahasiswa,id',
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

    /**
     * Mendapatkan daftar mahasiswa untuk data table
     *
     * @param Request $request
     * @return mixed
     */
    public function daftar(Request $request)
    {
        return dataTables()->eloquent(Mahasiswa::query())
                ->editColumn('prodi_id', function (Mahasiswa $mahasiswa) {
                    return $mahasiswa->getProdi()->nama;
                })->make(true);
    }

}
