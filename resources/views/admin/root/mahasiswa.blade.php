@extends('layouts.global')

@section('activity', 'Daftar Mahasiswa')

@section('title', 'Daftar Mahasiswa')

@section('content')

<div class="card">
    <div class="card-block">
        <div class="title-block">
            <h4 class="title">Tambah Mahasiswa</h4>
            <p class="title-description">Tambah data mahasiswa dari file excel/csv</p>
        </div>

        <form action="{{ route('root.tambah.mahasiswa') }}" method="post" enctype="multipart/form-data">
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

@endsection

@push('js')
<script>
    $('#tombolpilihfile').click(function (e) {
        e.preventDefault()
        $('#pilihfile').click()
    })
</script>
@endpush