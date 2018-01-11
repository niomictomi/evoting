<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KakpuController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Menampilkan halaman dashboard Ketua KPU
     * nama routes : kakpu.dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.kakpu.dashboard');
    }

}
