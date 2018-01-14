<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function mahasiswa()
    {
        return view('admin.root.mahasiswa');
    }

    public function reset()
    {
        return view('admin.root.reset');
    }

}
