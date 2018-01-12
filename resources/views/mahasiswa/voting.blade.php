@extends('layouts.global')

@section('content')

<div class="container">

    <div class="row justify-content-md-center">
        <div class="col-md-auto" id="timer">
            <timer></timer>
        </div>
    </div>

    <div class="card">
        
        @if(Session::has('message'))
        <p class="alert alert-{{ Session::get('error') ? 'danger' : 'success'}}">
            {{ Session::get('message') }}
        </p>
        @endif
        
        <div class="card-block">
            {{ Auth::guard('mhs')->user()->id }}
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
                    @if(!Auth::guard('mhs')->user()->telahMemilihHmj())
                    <h4>Daftar Pasangan Calon</h4>
                    <div id="paslonhmj" class="row">
                        <card-paslon 
                        v-for="paslon in daftarPaslon" 
                        :key="paslon.id" 
                        :id="paslon.id"
                        :foto="paslon.dir" 
                        :nama-ketua="paslon.nama_ketua" 
                        :nama-wakil="paslon.nama_wakil"
                        jenis="hmj"
                        :href="href"></card-paslon>
                    </div>
                    @else
                    <h5>Anda tidak bisa melakukan pemilihan Ketua dan Wakil Ketua Himpunan Jurusan</h5>
                    @endif
                </div>
                <div class="tab-pane fade" id="profile-pills">
                    @if(!Auth::guard('mhs')->user()->telahMemilihBem())
                    <h4>Daftar Pasangan Calon</h4>
                    <div id="paslonbem" class="row">
                        <card-paslon 
                        v-for="paslon in daftarPaslon" 
                        :key="paslon.id" 
                        jenis="bem"
                        :id="paslon.id"
                        :foto="paslon.dir" 
                        :nama-ketua="paslon.nama_ketua" 
                        :nama-wakil="paslon.nama_wakil"
                        :href="href"></card-paslon>
                    </div>
                    @else
                    <h5>Anda tidak bisa melakukan pemilihan Ketua dan Wakil Ketua BEM</h5>
                    @endif
                </div>
                <div class="tab-pane fade" id="messages-pills">
                    @if(!Auth::guard('mhs')->user()->telahMemilihDpm())
                    <h4>Daftar Pasangan Calon</h4>
                    <div id="paslondpm" class="row">
                        <card-calon-dpm 
                        v-for="paslon in daftarPaslon" 
                        :key="paslon.id" 
                        ref="satu" 
                        :id="paslon.id" 
                        :foto="paslon.dir" 
                        :nama="paslon.nama"
                        :href="href"></card-calon-dpm>
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

<div id="vote-hmj">
    <form-vote ref="form" action="{{ route('mahasiswa.vote.hmj') }}"></form-vote>
</div>

<div id="vote-bem">
    <form-vote ref="form" action="{{ route('mahasiswa.vote.bem') }}"></form-vote>
</div>

<div id="vote-dpm">
    <form-vote ref="form" action="{{ route('mahasiswa.vote.dpm') }}"></form-vote>
</div>

@endsection

@push('js')
<script>
    
    let hmj = new Vue({
        el: '#paslonhmj',
        data: {
            daftarPaslon: {!! $calonHMJ !!},
            href: '{{ route('mahasiswa.vote.hmj') }}'
        }
    })
    
    let bem = new Vue({
        el: '#paslonbem',
        data: {
            daftarPaslon: {!! $calonBEM !!},
            href: '{{ route('mahasiswa.vote.bem') }}'
        }
    })
    
    let dpm = new Vue({
        el: '#paslondpm',
        data: {
            daftarPaslon: {!! $calonDPM !!},
            href: '{{ route('mahasiswa.vote.dpm') }}'
        }
    })
    
    let voteHmj = new Vue({
        el: '#vote-hmj'
    })
    
    let voteBem = new Vue({
        el: '#vote-bem'
    })
    
    let voteDpm = new Vue({
        el: '#vote-dpm'
    })

    const timer = new Vue({
        el: '#timer'
    })
</script>
@endpush