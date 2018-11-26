<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Mahasiswa;
use App\Prodi;
use App\Jurusan;

class MahasiswaController extends Controller
{

    private $excelColumnName = [
        'nim' => 'nipd',
        'nama' => 'nm_pd',
        'prodi' => 'prodi',
        'jurusan' => 'jurusan',
        'status' => 'status'
    ];
    
    public function __construct()
    {
        $this->middleware('hakakses:root')->only('tambahDariFile');
        $this->middleware('ajax')->only('daftar');
    }
   // 38941
    /**
     * Menambah mahasiswa baru dari file excel atau csv
     * nama route : root.tambah.mahasiswa
     * @return void
     */
    public function tambahDariFile(Request $request)
    {
        $this->validate($request, [
            'berkas' => 'required|file'
        ]);

        $berkas = fopen($request->file('berkas')->getRealPath(), 'r');

        $jumlahDitambah = 0;

        $daftarJurusan = Jurusan::all()->pluck('nama')->toArray();
        
        while(!feof($berkas)) {
            $line = fgetcsv($berkas, 0, ';');

            // Mengecek apakah jurusan sudah ada di dalam array
            // jika tidak ada, maka ditambah ke database
            $jurusan = null;
            if(Jurusan::where('nama', str_replace('Jurusan ', '', $line[4]))->count() == 0) {
                $jurusan = Jurusan::create([
                    'nama' => str_replace('Jurusan ', '', $line[4])
                ]);
            }
            else {
                $jurusan = Jurusan::where('nama', str_replace('Jurusan ', '', $line[4]))->first();
            }

            $prodi = null;
            if(Prodi::where('nama', $line[3])->count() == 0) {
                $prodi = Prodi::create([
                    'nama' => $line[3],
                    'jurusan_id' => $jurusan->id
                ]);
            }
            else {
                $prodi = Prodi::where('nama', $line[3])->first();
            }

            try {
                $mahasiswa = Mahasiswa::findOrFail($line[0]);
            }
            catch(ModelNotFoundException $e) {
                Mahasiswa::create([
                    'id' => $line[0],
                    'nama' => $line[1],
                    'status' => $line[2],
                    'prodi_id' => $prodi->id,
                ]);
                $jumlahDitambah++;
            }
        }

        fclose($berkas);

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
                    return $mahasiswa->getProdi(false->nama;
                })->make(true);
    }

}
