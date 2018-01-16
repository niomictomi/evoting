<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jurusan;
use App\Support\Role;
use App\User;

class RootController extends Controller
{
    
    /**
     * Menampilkan halaman dashboard
     *
     * @return Illuminate\View\View
     */
    public function dashboard()
    {
        return view('admin.root.dashboard');
    }

    /**
     * Menampilkan halaman daftar dan penambahan mahasiswa
     *
     * @return Illuminate\View\View
     */
    public function mahasiswa()
    {
        $daftarJurusan = Jurusan::all();

        foreach($daftarJurusan as $jurusan) {
            $jurusan['daftarProdi'] = $jurusan->getProdi()->get()->toArray();
        }

        return view('admin.root.mahasiswa', [
            'daftarJurusanProdi' => $daftarJurusan
        ]);
    }

    /**
     * Menampilkan halaman untuk reset
     *
     * @return Illuminate\View\View
     */
    public function reset()
    {
        return view('admin.root.reset');
    }

    /**
     * Menampilkan halaman untuk mengelola admin
     *
     * @return Illuminate\View\View
     */
    public function admin()
    {
        $daftarAdmin = User::where('role', Role::ADMIN)->get();
        return view('admin.root.admin', [
            'daftarAdmin' => $daftarAdmin
        ]);
    }

}
