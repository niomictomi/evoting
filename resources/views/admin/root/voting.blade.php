@extends('layouts.global')

@section('activity', 'Voting')

@section('title', 'Voting')

@section('content')

    <div class="card">
        <div class="card-block">

            @if(session()->has('success'))
                <p class="alert alert-success">{{ session('success') }}</p>
            @endif

            <form method="get">
                <label>Cari Mahasiswa</label>
                <div class="input-group">
                    <input type="text" value="{{ request()->has('q') ? request()->get('q') : '' }}" name="q" class="form-control">
                    <button class="btn btn-primary text-white">cari</button>
                </div>
            </form>

            <table class="table">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>BEMF</th>
                        <th>DPM</th>
                        <th>HIMA</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($daftarMahasiswa as $mahasiswa)
                        <tr>
                            <td>{{ $mahasiswa->id }}</td>
                            <td>
                                {{ $mahasiswa->nama }}<br>
                                @if($mahasiswa->telah_login)
                                    <span class="badge badge-primary">Telah login</span>
                                @else
                                    <span class="badge badge-warning">Belum login</span>
                                @endif
                            </td>
                            <td>
                                @if($mahasiswa->bem)
                                    <span class="badge badge-success">Sudah</span>
                                @else
                                    <span class="badge badge-danger">Belum</span>
                                @endif
                            </td>
                            <td>
                                @if($mahasiswa->dpm)
                                    <span class="badge badge-success">Sudah</span>
                                @else
                                    <span class="badge badge-danger">Belum</span>
                                @endif
                            </td>
                            <td>
                                @if($mahasiswa->hmj)
                                    <span class="badge badge-success">Sudah</span>
                                @else
                                    <span class="badge badge-danger">Belum</span>
                                @endif
                            </td>
                            <td>
                                @if($mahasiswa->telah_login)
                                <form action="{{ route('root.buka.akun') }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="nim" value="{{ $mahasiswa->id }}">
                                    <button class="btn btn-warning text-white buka-akun">Buka Akun</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                    @endforelse
                </tbody>
            </table>

            {{ $daftarMahasiswa->links() }}
        </div>
    </div>

@endsection

@push('js')
<script>
$('.buka-akun').click(function (e) {
    e.preventDefault()

    swal({
        icon: 'warning',
        title: 'Apa anda yakin',
        dangerMode: true,
        buttons: {
            confirm: {
                text: 'Yakin'
            },
            cancel: {
                visible: true,
                text: 'Batal'
            }
        }
    }).then(function (confirm) {
        if (!confirm)
            return

        e.target.parentElement.submit()
    })
})
</script>
@endpush