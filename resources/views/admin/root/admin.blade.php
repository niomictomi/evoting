@extends('layouts.global')

@section('title', 'Kelola Admin')

@section('activity', 'Kelola Admin - Root')

@section('content')

<div class="row">
    
    <div class="col-md-5">
        <div class="card">
            <div class="card-block">
                <div class="title-block">
                    <h4 class="title">Tambah Admin</h4>
                </div>
                
                <form action="{{ route('root.tambah.admin') }}" method="post">
                    
                    {{ csrf_field() }}
                    
                    {{ method_field('put') }}
                    
                    <div class="form-group">
                        <label for="id" class="form-control-label">NIP</label>
                            <input type="number" class="form-control" name="id" id="id" value="{{ old('id') }}" placeholder="NIP"/>
                            @if($errors->has('id'))
                            <p class="alert alert-danger">{{ $errors->first('id') }}</p>
                            @endif
                    </div>
                    
                    <div class="form-group">
                        <label for="nama" class="form-control-label">Nama</label>
                            <input type="text" class="form-control" value="{{ old('nama') }}" name="nama" id="nama" placeholder="Nama"/>
                            @if($errors->has('nama'))
                            <p class="alert alert-danger">{{ $errors->first('nama') }}</p>
                            @endif
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-control-label">Kata sandi</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Kata sandi"/>
                            @if($errors->has('password'))
                            <p class="alert alert-danger">{{ $errors->first('password') }}</p>
                            @endif
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation" class="form-control-label">Konfirmasi Kata sandi</label>
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Ketikkan ulang kata sandi"/>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-7">
        <div class="card">
            <div class="card-block">
                <div class="title-block">
                    <h4 class="title">Daftar Admin</h4>
                </div>
                
                <table id="daftar-admin" class="table" style="width: 100%">
                    <thead>
                        <th>NIP</th>
                        <th>Nama</th>
                    </thead>
                    <tbody>
                        @foreach ($daftarAdmin as $admin)   
                        <tr>
                            <td>{{ $admin->id }}</td>
                            <td>{{ $admin->nama }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <th>NIP</th>
                        <th>Nama</th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
</div>





@endsection

@push('js')
<script>
    $('#daftar-admin').DataTable({
        
    })
    @if(Session::has('success'))
    swal({
        title: 'Berhasil',
        text: '{{ Session::get('success') }}',
        icon: 'success'
    })
    @endif
</script>
@endpush