<?php

namespace App\Http\Controllers;

use App\CalonBEM;
use App\CalonDPM;
use App\CalonHMJ;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Mahasiswa;
use App\Pengaturan;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
//use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Yajra\DataTables\DataTables;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Illuminate\Support\Facades\Request as Walah;


class PanitiaController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Menampilkan halaman dashboard panitia
     * nama routes : panitia.dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {


        if (!in_array($request->tipe, ['bem', 'dpm', 'hmj']))
            if (!in_array($request->hasil, ['bem', 'dpm', 'hmj']))
                $request->tipe = 'bem';
        $request->hasil = 'bem';
        $mhs = Mahasiswa::all();
        $mhs_aktif = Mahasiswa::getByStatus();
        $mhs_cuti = Mahasiswa::getByStatus([Mahasiswa::CUTI]);
        $mhs_nonaktif = Mahasiswa::getByStatus([Mahasiswa::NONAKTIF]);
        return view('admin.panitia.dashboard', [
            'mhs' => $mhs->count(),
            'mhsaktif' => $mhs_aktif->count(),
            'mhscuti' => $mhs_cuti->count(),
            'mhsnonaktif' => $mhs_nonaktif->count(),
            'tipe' => $request->tipe,
            'hasil' => $request->hasil
        ]);

    }

    public function paslon()
    {
        $hmj = CalonHMJ::all();


        return view('admin.panitia.paslon', compact('hmj'));
    }

    public function paslondpm()
    {
        $dpm = CalonDPM::all();

        return view('admin.panitia.paslondpm', compact('dpm'));
    }

    public function paslonbemf()
    {
        $bem = CalonBEM::all();

        return view('admin.panitia.paslonbem', compact('bem'));
    }

    public function paslonedit(Request $request)
    {
        //hmj
        $edithmj = CalonHMJ::find($request->id);

        return view('admin.panitia.include.formedit', compact('edithmj'));
    }

    public function pasloneditsave(Request $request)
    {
        $request->validate([
            'ketua_id' => 'required',
            'wakil_id' => 'required',
            'visi' => 'required',
            'misi' => 'required',
        ]);

        if ($request->hasFile('dir')) {

            $fillnames2 = $request->dir->getClientOriginalName() . '' . str_random(4);
            $filename = 'upload/photo/hmj/'
                . str_slug($fillnames2, '-') . '.' . $request->dir->getClientOriginalExtension();
            $request->dir->storeAs('public', $filename);
            $berkas = new CalonHMJ();
            $berkas->dir = $filename;
            $berkas->ketua_id = $request->ketua_id;
            $berkas->wakil_id = $request->wakil_id;
            $berkas->visi = $request->visi;
            $berkas->misi = $request->misi;
            $berkas->save();
            $dir = $fillnames2;

        }

        return view('admin.panitia.include.formedit', compact('edithmj'));
    }

    public function hmjdelete(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $paslon = CalonHMJ::find($request->id);
        //dd($paslon);
        $paslon->delete();

        return back()->with('message', 'Berhasil menghapus ' . $paslon->id . '.');
    }


    public function paslondpmedit(Request $request)
    {
        //hmj
        $editdpm = CalonDPM::find($request->id);

        return view('admin.panitia.include.formdpmedit', compact('editdpm'));
    }

    public function dpmdelete(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $paslon = CalonDPM::find($request->id);
        //dd($paslon);
        $paslon->delete();

        return back()->with('message', 'Berhasil menghapus ' . $paslon->id . '.');
    }

    public function paslonbemedit(Request $request)
    {
        //hmj
        $editbem = CalonBEM::find($request->id);

        return view('admin.panitia.include.formbemedit', compact('editbem'));
    }

    public function bemdelete(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $paslon = CalonBEM::find($request->id);
        //dd($paslon);
        $paslon->delete();

        return back()->with('message', 'Berhasil menghapus ' . $paslon->id . '.');
    }

    public function formhmj()
    {
        return view('admin.panitia.form');
    }

    public function hmjsave(Request $request)
    {
        $request->validate([
            'ketua_id' => 'required',
            'wakil_id' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'dir' => 'required',
        ]);

        $id = CalonHMJ::count();
        $idnow = $id + 1;

        try {
            $mhs = Mahasiswa::findorfail($request->ketua_id);

            if ($request->hasFile('dir')) {

                $fillnames2 = $request->dir->getClientOriginalName() . '' . str_random(4);
                $filename = 'upload/photo/hmj/'
                    . str_slug($fillnames2, '-') . '.' . $request->dir->getClientOriginalExtension();
                $request->dir->storeAs('public', $filename);
                $berkas = new CalonHMJ();
                $berkas->dir = $filename;
                $berkas->ketua_id = $request->ketua_id;
                $berkas->wakil_id = $request->wakil_id;
                $berkas->visi = $request->visi;
                $berkas->misi = $request->misi;
                $berkas->save();
                $dir = $fillnames2;

            }

            return redirect('panitia/paslon')->with('message', 'Paslon Berhasil Ditambahkan');
        } catch (ModelNotFoundException $exception) {
            return back()->with('error', 'NIM ketua Atau wakil Tidak Terdaftar');
        }

    }

    public function formdpm()
    {
        return view('admin.panitia.formdpm');
    }

    public function dpmsave(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'dir' => 'required',
        ]);

        $id = CalonHMJ::count();
        $idnow = $id + 1;

        try {

            $mhs = Mahasiswa::findorfail($request->anggota_id);
            if ($request->hasFile('dir')) {

                $fillnames2 = $request->dir->getClientOriginalName() . '' . str_random(4);
                $filename = 'upload/photo/dpm/'
                    . str_slug($fillnames2, '-') . '.' . $request->dir->getClientOriginalExtension();
                $request->dir->storeAs('public', $filename);
                $berkas = new CalonDPM();
                $berkas->dir = $filename;
                $berkas->anggota_id = $request->anggota_id;
                $berkas->visi = $request->visi;
                $berkas->misi = $request->misi;
                $berkas->save();
                $dir = $fillnames2;

            }
            return redirect('panitia/paslon/dpm')->with('message', 'Paslon Berhasil Ditambahkan');
        } catch (ModelNotFoundException $exception) {
            return back()->with('error', 'NIM calon Anggota Tidak Terdaftar');
        }

    }

    public function formbem()
    {
        return view('admin.panitia.formbem');
    }

    public function bemsave(Request $request)
    {
        $request->validate([
            'ketua_id' => 'required',
            'wakil_id' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'dir' => 'required',
        ]);

        $id = CalonHMJ::count();
        $idnow = $id + 1;


        try {

            $mhs = Mahasiswa::findorfail($request->ketua_id);

            if ($request->hasFile('dir')) {

                $fillnames2 = $request->dir->getClientOriginalName() . '' . str_random(4);
                $filename = 'upload/photo/bem/'
                    . str_slug($fillnames2, '-') . '.' . $request->dir->getClientOriginalExtension();
                $request->dir->storeAs('public', $filename);
                $berkas = new CalonBEM();
                $berkas->dir = $filename;
                $berkas->ketua_id = $request->ketua_id;
                $berkas->wakil_id = $request->wakil_id;
                $berkas->visi = $request->visi;
                $berkas->misi = $request->misi;
                $berkas->save();
                $dir = $fillnames2;

            }

            return redirect('panitia/paslon/bem')->with('message', 'Paslon Berhasil Ditambahkan');
        } catch (ModelNotFoundException $exception) {
            return back()->with('error', 'NIM calon Anggota Tidak Terdaftar');
        }

    }

    public function api()
    {

        //$result = Mahasiswa::orderBy('id', 'DESC')->get();
//        return view('admin.panitia.resepsionis', compact('result'));
        $mhs = Mahasiswa::all();

        return DataTables::of($mhs)->escapeColumns([])
            ->addcolumn('prodi', function ($mhs) {
                if ($mhs->prodi_id == 1) {
                    return 'S1 Pendidikan Ekonomi';
                } elseif ($mhs->prodi_id == 2) {
                    return 'S1 Pendidikan Administrasi Perkantoran';
                } elseif ($mhs->prodi_id == 3) {
                    return 'S1 Pendidikan Akutansi';
                } elseif ($mhs->prodi_id == 4) {
                    return 'S1 Pendidikan Tata Niaga';
                } elseif ($mhs->prodi_id == 5) {
                    return 'S1 Manajemen';
                } elseif ($mhs->prodi_id == 6) {
                    return 'S1 Akutansi';
                } elseif ($mhs->prodi_id == 7) {
                    return 'D3 Akutansi';
                } elseif ($mhs->prodi_id == 8) {
                    return 'S1 Ekonomi Islam';
                } elseif ($mhs->prodi_id == 9) {
                    return 'S1 Ilmu Ekonomi';
                }
            })
            ->addcolumn('action', function ($mhs) {
                if ($mhs->login == 0 && $mhs->telah_login == 0) {
                    $r = '<form method="post" action="' . url('panitia/resepsionis/' . $mhs->id . '/update') . '"><input type="hidden" name="_token" value="' . csrf_token() . '"/>';
                    return $r . '<button type="submit" class="btn btn-danger btn-sm btn-pill-right">Belum Aktif</button>' .
                        '<input hidden="" value="1" name="login">' . '</form>';
                } elseif ($mhs->login == 0 && $mhs->telah_login == 1) {
                    return '<button type="button" class="btn btn-primary btn-sm btn-pill-right">Telah Login</button>';
                } elseif ($mhs->login == 1 && $mhs->telah_login == 1) {
                    return '<button type="button" class="btn btn-primary btn-sm btn-pill-right">Aktif</button>';
                } elseif ($mhs->login == 1 && $mhs->telah_login == 0) {
                    return '<button type="button" class="btn btn-primary btn-sm btn-pill-right">Aktif</button>';
                }
            })->make(true);

    }

    public function resepsionis()
    {
        $result = null;

        return view('admin.panitia.resepsionis', compact('result'));

    }

    public function carimhs(Request $request)
    {

        if ($request->has('id')) {
            $key = $request->id;
            $result = Mahasiswa::whereRaw('("id" LIKE \'%' . $key . '%\')')->first();
        }
        if ($result == null) {
            return back()->with('error', 'NIM' . $key . ' tidak ditemukan');
        } else {
            return view('admin.panitia.resepsionis', compact('result'));
        }
    }

    public function edit($id)
    {
        $mhs = Mahasiswa::find($id);
        return $mhs;
    }

    public function updatestatus(Request $request)
    {

        $result = 0;
        $this->validate($request, [
            'login' => 'required',
        ]);
        $mahasiswa = Mahasiswa::find($request->id);
        if ($mahasiswa->status == 'A') {
            $mahasiswa->update([
                'login' => $request->login,
                //'password' =>$password,
            ]);

            // set printer
            $date = Carbon::now();
            try {
                // Enter the share name for your USB printer here
                $connector = null;
                //$connector = new NetworkPrintConnector("114.5.35.242",9100);
                $connector = new WindowsPrintConnector("POS-58");
                /* Print a "Hello world" receipt" */
                $printer = new Printer($connector);
                $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
                $printer->text("E-Voting Pemira!\n");
                $printer->selectPrintMode();
                $printer->text("Fakultas Ekonomi");
                $printer->text("\n");
                $printer->text("\n");
                $printer->text("UserName : " . $mahasiswa->id . "\n");
                $printer->text("Password : ");
                $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
                $printer->text($pass);
                $printer->selectPrintMode();
                $printer->text("\n");
                $printer->text("\n");
                $printer->text("\n");
                $printer->text($date);
                $printer->text("\n");
                $printer->text("\n");
                $printer->text("\n");
                $printer->text("\n");
                $printer->text("\n.");
                $printer->cut();

                /* Close printer */
                $printer->close();
            } catch (\Exception $e) {
                echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
            }
            return back()->with('message', 'Silahkan Klik Tombol Print');
        } else {
            return back()->with('error', 'Mahasiswa Berstatus Cuti / Non-aktir');
        }


    }

    public function printnim(Request $request)
    {
        $faker = Factory::create();
        $hmm = 'mhs_max_password';
        $maxpass = Pengaturan::find($hmm);
        $maxpass = $maxpass->value;
        $etc = '';

        for($i=1;$i<=$maxpass;$i++)
        {
            $i++;
        }

        $pass = $faker->unique()->numerify('########'
        );
        dd($pass);
        $password = bcrypt($pass);
        $mahasiswa = Mahasiswa::find($request->id);
        $mahasiswa->update([
            'password' => $password,
        ]);

        return view('admin.panitia.print', compact('pass', 'mahasiswa'));
    }

    public function nomorbem(Request $request)
    {

        $request->validate([
            'id' => 'required',
            'nomor' => 'required',
        ]);
        $paslon = CalonBEM::find($request->id);
        $paslon->update([
           'nomor'=>$request->nomor,
        ]);
        return back()->with('message', 'Nomor Paslon Berhasil Diberikan');
    }

    public function nomordpm(Request $request)
    {

        $request->validate([
            'id' => 'required',
            'nomor' => 'required',
        ]);
        $paslon = CalonDPM::find($request->id);
        $paslon->update([
            'nomor'=>$request->nomor,
        ]);
        return back()->with('message', 'Nomor Paslon Berhasil Diberikan');
    }

    public function nomorhmj(Request $request)
    {

        $request->validate([
            'id' => 'required',
            'nomor' => 'required',
        ]);
        $paslon = CalonHMJ::find($request->id);
        $paslon->update([
            'nomor'=>$request->nomor,
        ]);
        return back()->with('message', 'Nomor Paslon Berhasil Diberikan');
    }
}
