<?php

namespace App\Http\Controllers;

use App\Support\Role;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.admin.dashboard');
    }

    public function panitia()
    {
        $users = User::whereNotIn('role', [Role::ROOT, Role::ADMIN])->orderBy('id')->get();

        return view('admin.admin.panitia', [
            'users' => $users
        ]);
    }
}
