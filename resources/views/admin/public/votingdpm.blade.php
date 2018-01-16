@extends('layouts.global')

@section('title')
    Voting DPM
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
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-sm btn-pill-left dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">{{ $tipe }}
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('admin.voting.hmj', ['jurusan' => $jurusan, 'tipe' => 'Memiliki hak suara']) }}">Memiliki hak suara</a>
                                <a class="dropdown-item" href="{{ route('admin.voting.hmj', ['jurusan' => $jurusan, 'tipe' => 'Telah memberikan hak suara']) }}">Telah memberikan hak suara</a>
                                <a class="dropdown-item" href="{{ route('admin.voting.hmj', ['jurusan' => $jurusan, 'tipe' => 'Belum memberikan hak suara']) }}">Belum memberikan hak suara</a>
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning btn-sm btn-pill-right dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">Jurusan {{ $jurusan }}
                            </button>
                            <div class="dropdown-menu">
                                @foreach($jurusans as $item)
                                    <a class="dropdown-item" href="{{ route('admin.voting.hmj', ['jurusan' => $item->nama, 'tipe' => $tipe]) }}">Jurusan {{ $item->nama }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <table class="table" id="hmj-{{ str_replace(' ', '_', $tipe) }}-{{ $jurusanobject->id }}">
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
    @endif
@endsection

@push('js')
    <script>
        $("#hmj-{{ str_replace(' ', '_', $tipe) }}-{{ \App\Jurusan::findByName($jurusan)->id }}").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            language: {
                searchPlaceholder: "Ketik NIM atau nama..."
            },
            "lengthMenu": [[5, 10, 20, 40, 80, 100, -1], [5, 10, 20, 40, 80, 100, "Semua data"]],
            ajax: {
                url: '{{ route('hmjdpm.data.hakpilih', ['id' => md5(\App\Jurusan::findByName($jurusan)->id), 'status' => md5($tipe)]) }}'
            },
            columns: [
                {render: function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; }},
                {data: 'id', name: 'id'},
                {data: 'nama', name: 'nama'},
                {data: 'prodi', name: 'prodi'}
            ]
        });
    </script>
@endpush