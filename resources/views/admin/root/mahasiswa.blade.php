@extends('layouts.global')

@section('activity', 'Daftar Mahasiswa')

@section('title', 'Daftar Mahasiswa')

@section('content')

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-block">
                <div class="title-block">
                    <h4 class="title">Tambah Mahasiswa</h4>
                    <p class="title-description">Tambah data mahasiswa dari file excel/csv</p>
                </div>

                <form action="{{ route('root.tambah.mahasiswa.file') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <input id="pilihfile" style="display: none" type="file" name="berkas"/>
                    @if($errors->has('berkas'))
                        <p class="alert alert-danger">
                            {{ $errors->first('berkas') }}
                        </p>
                    @endif
                    <button id="tombolpilihfile" class="btn btn-primary">Pilih Berkas</button>
                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-block">
                <div class="title-block">
                    <h4 class="title">Tambah Mahasiswa Baru</h4>
                    <p class="title-description">Tambah data mahasiswa baru</p>
                </div>

                <form action="{{ route('root.tambah.mahasiswa.individu') }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-block">
        <div class="title-block">
            <h4 class="title">Daftar Mahasiswa</h4>
        </div>

        <table style="width: 100%" id="daftar-mahasiswa">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Status</th>
                </tr>
            </tfoot>
        </table>
        
    </div>
</div>

@endsection

@push('js')
<script>
    $('#daftar-mahasiswa').DataTable({
        'processing': true,
        'serverSide': true,
        'ajax': {
            'url': '{{ route('daftar.mahasiswa') }}',
            'type': 'post',
            'beforeSend': function(request) {
                request.setRequestHeader('X-CSRF-TOKEN',  $('meta[name="csrf-token"]').attr('content'))
            }
        },
        'responsive': true
    })

    $('#tombolpilihfile').click(function (e) {
        e.preventDefault()
        $('#pilihfile').click()
    })
</script>
@endpush