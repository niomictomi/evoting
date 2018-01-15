@extends('layouts.global')

@section('activity', 'Daftar Mahasiswa')

@section('title', 'Daftar Mahasiswa')

@section('content')

<div class="row sameheight-container">
    <div class="col">
        <div class="card sameheight-item">
            <div class="card-block">
                <div class="title-block">
                    <h4 class="title">Tambah Mahasiswa</h4>
                    <p class="title-description">Tambah data mahasiswa dari file excel/csv</p>
                </div>

                <div class="alert alert-warning">
                    Pastikan format kolom sebagai berikut :
                    <ol>
                        <li>Kolom pertama adalah nim</li>
                        <li>Kolom kedua adalah nama lengkap</li>
                        <li>Kolom ketiga adalah status</li>
                        <li>Kolom keempat adalah prodi</li>
                        <li>Kolom kelima adalah jurusan</li>
                    </ol>
                    <b>Catatan : </b> baris pertama adalah judul
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
        <div class="card sameheight-item">
            <div class="card-block">
                <div class="title-block">
                    <h4 class="title">Tambah Mahasiswa Baru</h4>
                    <p class="title-description">Tambah data mahasiswa baru</p>
                </div>

                <form action="{{ route('root.tambah.mahasiswa.individu') }}" method="post">
                    {{ csrf_field() }}

                    {{ method_field('put') }}

                    <div class="form-group row">
                        <label for="nim" class="col-sm-4 form-control-label">NIM</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="nim" id="nim" placeholder="NIM"> </div>
                    </div>

                    <div class="form-group row">
                        <label for="nama" class="col-sm-4 form-control-label">Nama</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Lengkap"> </div>
                    </div>

                    <div class="form-group row">
                        <label for="jurusan" class="col-sm-4 form-control-label">Jurusan</label>
                        <div class="col-sm-8">
                            <select @change="ubahDaftarProdi" id="jurusan-option" name="jurusan" class="form-control form-control-sm">
                                <option v-for="jurusan in daftarjurusan" :value="jurusan.id" >@{{ jurusan.nama }}</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="prodi" class="col-sm-4 form-control-label">Prodi</label>
                        <div class="col-sm-8">
                            <select id="prodi-option" name="prodi" class="form-control form-control-sm">
                                <option v-for="prodi in daftarprodi" :value="prodi.id">@{{ prodi.nama }}</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="status" class="col-sm-4 form-control-label">Status</label>
                        <div class="col-sm-8">
                            <label>
                                <input name="status" value="A" class="radio" type="radio">
                                <span>Aktif</span>
                            </label>
                            <label>
                                <input name="status" value="C" class="radio" type="radio">
                                <span>Cuti</span>
                            </label>
                            <label>
                                <input name="status" value="N" class="radio" type="radio">
                                <span>Nonaktif</span>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">Tambahkan</button>
                        </div>
                    </div>
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

        <table style="width: 100%" id="daftar-mahasiswa" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Prodi</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Prodi</th>
                </tr>
            </tfoot>
        </table>
        
    </div>
</div>

@endsection

@push('js')
<script>
    $('#daftar-mahasiswa').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('daftar.mahasiswa') }}',
            type: 'post',
            beforeSend: function(request) {
                request.setRequestHeader('X-CSRF-TOKEN',  $('meta[name="csrf-token"]').attr('content'))
            }
        },
        responsive: true,
        columns : [
            {data: 'id', name: 'id'},
            {data: 'nama', name: 'nama'},
            {data: 'status', name: 'status'},
            {data: 'prodi_id', name: 'prodi_id'}
        ]
    })

    $('#tombolpilihfile').click(function (e) {
        e.preventDefault()
        $('#pilihfile').click()
    })

    let jurOption = new Vue({
        el: '#jurusan-option',
        data: {
            daftarjurusan: {!! $daftarJurusanProdi !!}
        },
        methods: {
            ubahDaftarProdi(e) {
                let that = this
                Vue.nextTick(function() {
                    let id = e.target.value
                    for(i in that.daftarjurusan) {
                        if(that.daftarjurusan[i].id == id) {
                            prodiOption.daftarprodi = that.daftarjurusan[i].daftarProdi
                            break;
                        }
                    }
                })
            }
        }
    })

    let prodiOption = new Vue({
        el: '#prodi-option',
        data: {
            daftarprodi: []
        },
        mounted() {
            this.daftarprodi = jurOption.daftarjurusan[0].daftarProdi
        }
    })

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