@extends('layouts.global')

@section('title', 'Voting BEM')

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

    <div class="row">
        @foreach(\App\CalonBEM::all() as $calon)
            <div class="col">
                <div class="card">
                    <div class="card-header bordered">
                        <div class="header-block">
                            <h3 class="title">Paslon nomor {{ $calon->nomor }}</h3>
                        </div>
                    </div>
                    <img src="{{ asset('storage/'.$calon->dir) }}" class="img-fluid">
                    <div class="card-block">
                        <div style="max-height: 200px; overflow: auto">
                            <label>Ketua</label>
                            <p>{{ $calon->getKetua()->id }}<br>{{ $calon->getKetua()->nama }}</p>
                            <label>Wakil</label>
                            <p>{{ $calon->getWakil()->id }}<br>{{ $calon->getWakil()->nama }}</p>
                            <label>Visi</label>
                            <p>{!! $calon->visi !!}</p>
                            <label>Misi</label>
                            <p>{!! $calon->misi !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card">
        <div class="card-header bordered">
            <div class="header-block ">
                <h3 class="title">Daftar pemilih/mahasiswa</h3>
            </div>
            <div class="header-block pull-right">
                <div class="btn-group">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm btn-pill-left dropdown-toggle"
                                data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">{{ $tipe }}
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item"
                               href="{{ route('admin.voting.bem', ['tipe' => 'Memiliki hak suara']) }}">Memiliki hak
                                suara</a>
                            <a class="dropdown-item"
                               href="{{ route('admin.voting.bem', ['tipe' => 'Telah memberikan hak suara']) }}">Telah
                                memberikan hak suara</a>
                            <a class="dropdown-item"
                               href="{{ route('admin.voting.bem', ['tipe' => 'Belum memberikan hak suara']) }}">Belum
                                memberikan hak suara</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-block">
            @if($cek)
            <table class="table" id="bem-{{ str_replace(' ', '_', $tipe) }}">
                <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Prodi</th>
                    @if ($tipe == 'Telah memberikan hak suara')
                        <th>Waktu</th>
                    @endif
                </tr>
                </thead>
            </table>
            @else
                <div class="alert alert-info">
                    Daftar mahasiswa yang telah voting atau belum hanya ditampilkan saat voting sedang berlangsung.
                </div>
            @endif
        </div>
    </div>
@endsection

@push('js')
    <script>
        $("#bem-{{ str_replace(' ', '_', $tipe) }}").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            language: {
                searchPlaceholder: "Ketik NIM atau nama..."
            },
            "lengthMenu": [[5, 10, 20, 40, 80, 100, -1], [5, 10, 20, 40, 80, 100, "Semua data"]],
            ajax: {
                url: '{{ route('bem.data.hakpilih', ['status' => md5($tipe)]) }}'
            },
            columns: [
                {
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: 'id', name: 'id'},
                {data: 'nama', name: 'nama'},
                {data: 'prodi', name: 'prodi'},
                    @if ($tipe == 'Telah memberikan hak suara')
                {
                    data: 'created_at', name: 'created_at', searchable: false
                }
                @endif
            ]
        });
    </script>
@endpush