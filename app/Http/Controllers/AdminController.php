<?php

namespace App\Http\Controllers;

use App\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Support\Role;
use App\User;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        if (!in_array($request->tipe, ['bem', 'dpm', 'hmj']))
            $request->tipe = 'bem';
        $mhs = Mahasiswa::all();
        $mhs_aktif = Mahasiswa::getByStatus();
        $mhs_cuti = Mahasiswa::getByStatus([Mahasiswa::CUTI]);
        $mhs_nonaktif = Mahasiswa::getByStatus([Mahasiswa::NONAKTIF]);
        return view('admin.admin.dashboard', [
            'mhs' => $mhs->count(),
            'mhsaktif' => $mhs_aktif->count(),
            'mhscuti' => $mhs_cuti->count(),
            'mhsnonaktif' => $mhs_nonaktif->count(),
            'tipe' => $request->tipe
        ]);
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
            'id' => 'required|regex:/[0-9]{11}/',
            'role' => 'required'
        ]);

        if ((count(explode(';', $request->role)) > 1) ? Role::check($request->role, ';') : Role::check($request->role)) {
            $role = explode(';', $request->role);
            if ($role[0] == Role::WD3){
                if (Role::checkIfWd3Exists())
                    return back()->withErrors(['WD3 tidak boleh lebih dari satu!']);
            }
            elseif ($role[0] == Role::KETUA_KPU){
                if (Role::checkIfKetuaKpuExists())
                    return back()->withErrors(['Ketua KPU tidak boleh lebih dari satu!']);
            }
            if (count($role) > 1) {
                User::create([
                    'id' => $request->id,
                    'nama' => $request->nama,
                    'role' => $role[0],
                    'helper' => $role[1],
                    'password' => bcrypt($request->id)
                ]);
            } else {
                if ($role[0] == Role::KETUA_KPU){
                    User::create([
                        'id' => $request->id,
                        'nama' => $request->nama,
                        'role' => $role[0],
                        'password' => bcrypt($request->id)
                    ]);
                }
                else{
                    User::create([
                        'id' => $request->id,
                        'nama' => $request->nama,
                        'role' => $role[0],
                        'password' => bcrypt($request->id),
                        'helper' => bcrypt($request->id)
                    ]);
                }
            }

            return back()->with('message', 'Berhasil menambahkan panitia.');
        }

        $request->role = str_replace(';', ' - ', $request->role);
        return back()->withErrors(['Hak akses "' . strtoupper($request->role) . '" tidak tersedia!']);
    }

    public function editPanitia(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'id' => 'required|regex:/[0-9]{11}/',
            'id_lama' => 'required|regex:/[0-9]{11}/',
            'role' => 'required'
        ]);

        if ($request->role != Role::WD3 && $request->role != Role::DOSEN && $request->role != Role::ROOT){
            if ((count(explode(';', $request->role)) > 1) ? Role::check($request->role, ';') : Role::check($request->role)) {
                $role = explode(';', $request->role);
                $user = User::find($request->id_lama);
                if (count($role) > 1) {
                    if (is_null($request->password)){
                        $user->update([
                            'nama' => $request->nama,
                            'id' => $request->id,
                            'role' => $role[0],
                            'helper' => $role[1]
                        ]);

                        return back()->with('message', 'Berhasil memperbarui data '.$user->nama.'.');
                    }
                    $user->update([
                        'nama' => $request->nama,
                        'id' => $request->id,
                        'role' => $role[0],
                        'helper' => $role[1],
                        'password' => bcrypt($request->password)
                    ]);

                    return back()->with('message', 'Berhasil memperbarui data '.$user->nama.' beserta password.');
                } else {
                    if (is_null($request->password)){
                        $user->update([
                            'nama' => $request->nama,
                            'id' => $request->id,
                            'role' => $role[0],
                            'helper' => $role[1]
                        ]);

                        return back()->with('message', 'Berhasil memperbarui data '.$user->nama.'.');
                    }
                    $user->update([
                        'nama' => $request->nama,
                        'id' => $request->id,
                        'role' => $role[0],
                        'helper' => $role[1],
                        'password' => bcrypt($request->password)
                    ]);

                    return back()->with('message', 'Berhasil memperbarui data '.$user->nama.' beserta password.');
                }
            }
        }

        return back()->withErrors(['Anda tidak bisa mengedit '.strtoupper($request->role)]);
    }

    public function hapusPanitia(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|regex:/[0-9]{11}/'
        ]);

        $user = User::find($request->id);
        $user->delete();

        return back()->with('message', 'Berhasil menghapus '.$user->nama.'.');
    }

    /**
     * Menambah admin
     *
     * @param Request $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function tambahAdmin(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric|unique:users',
            'nama' => 'required',
            'password' => 'required|confirmed'
        ]);

        User::create([
            'id' => $request->id,
            'nama' => $request->nama,
            'role' => Role::ADMIN,
            'password' => bcrypt($request->password)
        ]);

        return back()->with([
            'success' => 'Berhasil menambah admin'
        ]);
    }

}
