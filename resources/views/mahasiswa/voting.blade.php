@extends('layouts.global')

@section('content')

<div class="container">

<div class="card">
    
    @if(Session::has('message'))
    <p class="alert alert-{{ Session::get('error') ? 'danger' : 'success'}}">
        {{ Session::get('message') }}
    </p>
    @endif
    
    <div class="card-block">
        <div class="card-title-block">
            <h3 class="title"> Pilih Jenis Pemilihan </h3>
        </div>
        <!-- Nav tabs -->
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a href="" class="nav-link active" data-target="#home-pills" aria-controls="home-pills" data-toggle="tab" role="tab">Hima</a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link" data-target="#profile-pills" aria-controls="profile-pills" data-toggle="tab" role="tab">BEM</a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link" data-target="#messages-pills" aria-controls="messages-pills" data-toggle="tab" role="tab">DPM</a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="home-pills">
                @if(!Auth::guard('mahasiswa')->user()->telahMemilih($idpemilihanhmj))
                <h4>Daftar Pasangan Calon</h4>
                <div id="paslonhmj" class="row">
                    <card-paslon v-for="paslon in daftarPaslon" :key="paslon.id" ref="satu" :id="paslon.nama" :foto="paslon.dir" :nama-ketua="paslon.nama_ketua" :nama-wakil="paslon.nama_wakil" :idpaslon="paslon.id" :href="href"></card-paslon>
                </div>
                @else
                <h5>Anda tidak bisa melakukan pemilihan Ketua dan Wakil Ketua Himpunan Jurusan</h5>
                @endif
            </div>
            <div class="tab-pane fade" id="profile-pills">
                @if(!Auth::guard('mahasiswa')->user()->telahMemilih($idpemilihanbem))
                <h4>Daftar Pasangan Calon</h4>
                <div id="paslonbem" class="row">
                    <card-paslon v-for="paslon in daftarPaslon" :key="paslon.id" ref="satu" :id="paslon.nama" :foto="paslon.dir" :nama-ketua="paslon.nama_ketua" :nama-wakil="paslon.nama_wakil" :idpaslon="paslon.id" :href="href"></card-paslon>
                </div>
                @else
                <h5>Anda tidak bisa melakukan pemilihan Ketua dan Wakil Ketua BEM</h5>
                @endif
            </div>
            <div class="tab-pane fade" id="messages-pills">
                @if(!Auth::guard('mahasiswa')->user()->telahMemilih($idpemilihandpm))
                <h4>Daftar Pasangan Calon</h4>
                    <div id="paslondpm" class="row">
                        <card-paslon v-for="paslon in daftarPaslon" :key="paslon.id" ref="satu" :id="paslon.nama" :foto="paslon.dir" :nama-ketua="paslon.nama_ketua" :nama-wakil="paslon.nama_wakil" :idpaslon="paslon.id" :href="href"></card-paslon>
                    </div>
                    @else
                    <h5>Anda tidak bisa melakukan pemilihan Ketua dan Wakil Ketua DPM</h5>
                    @endif
            </div>
        </div>
    </div>
            <!-- /.card-block -->
</div>
        
</div>
        {{--  <form id="vote-hmj" action="{{ route('mahasiswa.vote.hmj') }}" method="post">
            <input type="text" name="terpilih" :value="terpilih"/>
            {{ csrf_field() }}
            <button type="submit">Vote</button>
        </form>  --}}
        
        @endsection
        
        @push('js')
        <script>

            @if(Session::has('message'))
            swal({
                title: "{{ Session::get('error') ? 'Gagal !' : 'Berhasil !' }}",
                text: "{{ Session::get('message') }}",
                icon: "{{ Session::get('error') ? 'error' : 'success' }}",
            }).then(function() {
                $('#keluar').submit();
            })
            @endif

            @unless(Auth::guard('mahasiswa')->user()->telahMemilih($idpemilihanhmj))
            let hmj = new Vue({
                el: '#paslonhmj',
                data: {
                    daftarPaslon: {!! $paslonHMJ !!},
                    href: '{{ route('mahasiswa.vote.hmj') }}'
                }
            });
            @endunless
            
            @unless(Auth::guard('mahasiswa')->user()->telahMemilih($idpemilihanbem))
            let bem = new Vue({
                el: '#paslonbem',
                data: {
                    daftarPaslon: {!! $paslonBEM !!},
                    href: '{{ route('mahasiswa.vote.bem') }}'
                }
            });
            @endunless
            
            @unless(Auth::guard('mahasiswa')->user()->telahMemilih($idpemilihandpm))
            let dpm = new Vue({
                el: '#paslondpm',
                data: {
                    daftarPaslon: {!! $paslonDPM !!},
                    href: '{{ route('mahasiswa.vote.dpm') }}'
                }
            });
            @endunless
        </script>
        @endpush