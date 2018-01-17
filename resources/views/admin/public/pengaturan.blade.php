@extends('layouts.global')

@section('title', 'Pengaturan')
@section('activity', 'Pengaturan')

@section('content')

<div class="row sameheight-container">
    <div class="col">
        <div class="card">
            <div class="card-block">
                <div class="title-block">
                    <h4 class="title">Pengaturan</h4>
                </div>
                
                <form action="{{ route('admin.pengaturan') }}" method="post">
                    
                    {{ csrf_field() }}
                    
                    <div class="form-group row">
                        <label class="col-md-4" for="id">NIP</label>
                        <div class="col-md-8">
                            <input type="number" name="id" class="form-control" value="{{ $errors->has('id') ? old('id') : Auth::user()->id }}" {{ Auth::user()->isRoot() ? '' : 'disabled' }}/>
                            @if($errors->has('id'))
                            <p class="alert alert-danger">
                                {{ $errors->first('id') }}
                            </p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-4" for="id">Nama</label>
                        <div class="col-md-8">
                            <input type="text" name="nama" class="form-control" value="{{ $errors->has('nama') ? old('id') : Auth::user()->nama }}"/>
                            @if($errors->has('nama'))
                            <p class="alert alert-danger">
                                {{ $errors->first('nama') }}
                            </p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-4"></label>
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-primary">Ubah</button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
    
    <div class="col">
        <div class="card">
            <div class="card-block">
                <div class="title-block">
                    <h4 class="title">Ubah Kata Sandi</h4>
                </div>
                
                <form action="{{ route('admin.ubah.password') }}" method="post">
                    
                    {{ csrf_field() }}
                    
                    <div class="form-group row">
                        <label class="col-md-4" for="id">Kata sandi lama</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" name="passlama"/>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-4" for="id">Kata sandi baru</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" name="passbaru"/>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-4" for="id">Konfirmasi kata sandi baru</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" name="passbaru_confirmation"/>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-4"></label>
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-primary">Ubah</button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
@if(Session::has('success'))
swal({
    title: 'Berhasil !',
    icon: 'success',
    text: '{{ Session::get('success') }}'
})
@endif

@if(Session::has('error'))
swal({
    title: 'Ups !',
    icon: 'error',
    text: '{{ Session::get('error') }}'
})
@endif
</script>
@endpush