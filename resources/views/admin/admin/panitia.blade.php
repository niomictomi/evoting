@extends('layouts.global')

@section('title', 'Panitia')

@section('content')
    @if ($errors->any())
        <div class="alert alert-warning">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session()->has('message'))
        <div class="alert alert-info">
            {{ session()->get('message') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header bordered">
            <div class="header-block">
                <h3 class="title">Daftar panitia</h3>
            </div>
            <div class="header-block pull-right">
                <button data-target="#tambah" class="btn btn-primary btn-sm rounded pull-right" data-toggle="modal">Tambah Panitia</button>
                <div class="modal fade" id="tambah" tabindex="-1" role="dialog"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="card">
                            <div class="card-header bordered">
                                <div class="header-block">
                                    <h3 class="title">Tambah Panitia</h3>
                                </div>
                                <div class="header-block pull-right">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <div class="card-block">
                                <form action="{{ route('admin.tambah.panitia') }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('put') }}
                                    <fieldset class="form-group">
                                        <label class="control-label">NIM/NIP/NIDN</label>
                                        <input type="number" name="id" class="form-control underlined" minlength="11" maxlength="11" required>
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label class="control-label">Nama</label>
                                        <input type="text" name="nama" class="form-control underlined" required>
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label class="control-label">Hak Akses</label>
                                        <select name="role" class="form-control underlined" required>
                                            @foreach(\App\Support\Role::ALL as $role)
                                                @if($role == \App\Support\Role::PANITIA)
                                                    @foreach(\App\Support\Role::PANITIA_ALL as $p)
                                                        <option value="{{ $role.';'.$p }}">
                                                            {{ strtoupper($role.' - '.$p) }}
                                                        </option>
                                                    @endforeach
                                                @elseif($role != \App\Support\Role::ADMIN && $role != \App\Support\Role::ROOT)
                                                    <option value="{{ $role }}">
                                                        {{ strtoupper($role) }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </fieldset>
                                    <button type="submit" class="btn btn-success" style="color: white">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-block">
            <div class="table-responsive">
                <table class="table table-hover" id="panitia">
                    <thead>
                    <tr>
                        <td><b>NIM</b></td>
                        <td><b>Nama</b></td>
                        <td><b>Hak Akses</b></td>
                        <td><b>Aksi</b></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->nama }}</td>
                            <td>
                                {{ strtoupper($user->role) }}
                                @if($user->role == \App\Support\Role::PANITIA)
                                    - {{ strtoupper($user->helper) }}
                                @endif
                            </td>
                            <td>
                                <form id="hapus-{{ $user->id }}" action="{{ route('admin.hapus.panitia') }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                </form>
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm btn-pill-left" data-toggle="modal"
                                            data-target="#edit-{{ $user->id }}">Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm btn-pill-right" onclick="$('#hapus-{{ $user->id }}').submit()">Hapus</button>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="edit-{{ $user->id }}" tabindex="-1" role="dialog"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="card">
                                    <div class="card-header bordered">
                                        <div class="header-block">
                                            <h3 class="title">{{ $user->nama }}</h3>
                                        </div>
                                        <div class="header-block pull-right">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <form action="{{ route('admin.edit.panitia') }}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('patch') }}
                                            <input type="hidden" name="id_lama" value="{{ $user->id }}">
                                            <fieldset class="form-group">
                                                <label class="control-label">NIM</label>
                                                <input name="id" type="number" value="{{ $user->id }}" class="form-control underlined" minlength="11" maxlength="11" required>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label class="control-label">Nama</label>
                                                <input type="text" value="{{ $user->nama }}" name="nama"
                                                       class="form-control underlined" required>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label class="control-label">Hak Akses</label>
                                                <select name="role" class="form-control underlined" required>
                                                    @if($user->role == \App\Support\Role::PANITIA)
                                                        <option value="{{ $userrole = $user->role.';'.$user->helper }}">
                                                            {{ strtoupper($user->role.' - '.$user->helper) }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $userrole = $user->role }}">
                                                            {{ strtoupper($user->role) }}
                                                        </option>
                                                    @endif
                                                    @foreach(\App\Support\Role::ALL as $role)
                                                        @if($role == \App\Support\Role::PANITIA)
                                                            @foreach(\App\Support\Role::PANITIA_ALL as $p)
                                                                @if($userrole != $role.';'.$p)
                                                                    <option value="{{ $role.';'.$p }}">
                                                                        {{ strtoupper($role.' - '.$p) }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        @elseif($role != \App\Support\Role::ADMIN && $role != \App\Support\Role::ROOT)
                                                            @if($userrole != $role)
                                                                <option value="{{ $role }}">
                                                                    {{ strtoupper($role) }}
                                                                </option>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label class="control-label">Password (kosongi jika password tidak diubah)</label>
                                                <input type="password" name="password" class="form-control underlined">
                                            </fieldset>
                                            <button type="submit" class="btn btn-success" style="color: white">Simpan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection