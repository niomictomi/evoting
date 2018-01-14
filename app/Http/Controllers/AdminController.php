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

    public function tambahPanitia(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'nim' => 'required|regex:/[0-9]{11}/',
            'role' => 'required'
        ]);

        if ((count(explode(';', $request->role)) > 1) ? Role::check($request->role, ';') : Role::check($request->role)) {
            $role = explode(';', $request->role);
            if ($role[0] == Role::WD3 || $role[0] == Role::KETUA_KPU){
                if (Role::checkIfKetuaKpuExists() || Role::checkIfWd3Exists())
                    return back()->withErrors(['WD3 dan Ketua KPU tidak boleh lebih dari satu!']);
            }
            if (count($role) > 1) {
                User::create([
                    'id' => $request->nim,
                    'nama' => $request->nama,
                    'role' => $role[0],
                    'helper' => $role[1],
                    'password' => bcrypt($request->nim)
                ]);
            } else {
                User::create([
                    'id' => $request->nim,
                    'nama' => $request->nama,
                    'role' => $role[0],
                    'password' => bcrypt($request->nim)
                ]);
            }

            return back()->with('message', 'Berhasil menambahkan panitia.');
        }

        $request->role = str_replace(';', ' - ', $request->role);
        return back()->withErrors(['Hak akses "' . strtoupper($request->role) . '" tidak tersedia!']);
    }
}
