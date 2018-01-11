<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Wd3dosenController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Menampilkan halaman dashboard DOsen dan Wd 3
     * nama routes : dosen.dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
      return view('admin.wd3dosen.dashboard');
    }
}
