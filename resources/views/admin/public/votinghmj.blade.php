@extends('layouts.global')

@section('title')
    Voting HMJ
@endsection

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

    <div class="alert alert-info">
        <b>{{ \App\Pengaturan::getStatusVoting() }}</b>
        @if(session()->has('message'))
            <br><br>
            {{ session()->get('message') }}
        @endif
    </div>

    @if($cek)
        <div class="card">
            <div class="card-header bordered">
                <div class="header-block ">
                    <h3 class="title">Daftar pemilih/mahasiswa</h3>
                </div>
                <div class="header-block pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Jurusan {{ $jurusan }}
                        </button>
                        <div class="dropdown-menu">
                            @foreach($jurusans as $item)
                                <a class="dropdown-item" href="{{ route('admin.voting.hmj', ['jurusan' => $item->nama]) }}">Jurusan {{ $item->nama }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a href="" class="nav-link active" data-target="#semua-{{ $jurusanobject->id }}" aria-controls="home-pilss" data-toggle="tab">Semua</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link" data-target="#telah-{{ $jurusanobject->id }}" aria-controls="home-pilss" data-toggle="tab">Telah voting</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link" data-target="#belum-{{ $jurusanobject->id }}" aria-controls="home-pilss" data-toggle="tab">Belum voting</a>
                    </li>
                </ul>
                <br>
                <div class="tab-content">
                    <div class="tab-pane active" id="semua-{{ $jurusanobject->id }}">
                        <table class="table" id="hmj-semua-{{ $jurusanobject->id }}">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Prodi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tab-pane" id="telah-{{ $jurusanobject->id }}">
                        <table class="table" id="hmj-telah-{{ $jurusanobject->id }}">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Prodi</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tab-pane" id="belum-{{ $jurusanobject->id }}">
                        <table class="table" id="hmj-belum-{{ $jurusanobject->id }}">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Prodi</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('js')
    <script>
        @foreach(\App\Jurusan::all() as $jurusan)
        $('#hmj-semua-{{ $jurusan->id }}').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            language: {
                searchPlaceholder: "Ketik NIM atau nama..."
            },
            "lengthMenu": [[5, 10, 20, 40, 80, 100, -1], [5, 10, 20, 40, 80, 100, "Semua data"]],
            ajax: {
                url: '{{ url("hmj/".md5($jurusan->id).'/'.md5('semua')) }}'
            },
            columns: [
                {render: function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; }},
                {data: 'id', name: 'id'},
                {data: 'nama', name: 'nama'},
                {data: 'prodi', name: 'prodi'}
            ]
        });
        $('#hmj-telah-{{ $jurusan->id }}').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            language: {
                searchPlaceholder: "Ketik NIM atau nama..."
            },
            "lengthMenu": [[5, 10, 20, 40, 80, 100, -1], [5, 10, 20, 40, 80, 100, "Semua data"]],
            ajax: {
                url: '{{ url("hmj/".md5($jurusan->id).'/'.md5('telah')) }}'
            },
            columns: [
                {render: function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; }, orderable: false, searchable: false},
                {data: 'id', name: 'id'},
                {data: 'nama', name: 'nama'},
                {data: 'prodi', name: 'prodi'}
            ]
        });
        $('#hmj-belum-{{ $jurusan->id }}').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            language: {
                searchPlaceholder: "Ketik NIM atau nama..."
            },
            "lengthMenu": [[5, 10, 20, 40, 80, 100, -1], [5, 10, 20, 40, 80, 100, "Semua data"]],
            ajax: {
                url: '{{ url("hmj/".md5($jurusan->id).'/'.md5('belum')) }}'
            },
            columns: [
                {render: function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; }},
                {data: 'id', name: 'id'},
                {data: 'nama', name: 'nama'},
                {data: 'prodi', name: 'prodi'}
            ]
        });
        @endforeach
    </script>
@endpush