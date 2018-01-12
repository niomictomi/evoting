@extends('layouts.global')

@section('title')
    Panitia
@endsection

@section('content')
    <div class="card">
        <div class="card-header bordered">
            <div class="header-block">
                <h3 class="title">Daftar panitia</h3>
            </div>
            <div class="header-block pull-right">
                <a href="" class="btn btn-primary btn-sm rounded pull-right"> Tambah Panitia </a>
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
                                {{ ucwords($user->role) }}
                                @if($user->role == \App\Support\Role::PANITIA)
                                    - {{ $user->helper }}
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm btn-pill-left">Edit</button>
                                    <button class="btn btn-danger btn-sm btn-pill-right">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection