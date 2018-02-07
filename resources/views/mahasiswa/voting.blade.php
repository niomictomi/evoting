@extends('layouts.global')

@section('activity', 'Voting')

@section('title', 'Mahasiswa')

@section('content')

<div class="container-fluid">

    <div class="card" id="card-vote">

        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="card-title-block">
                        <h3>Pilih Jenis Pemilihan</h3>
                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills">
                        <li class="nav-item" style="cursor: pointer">
                            <a class="nav-link nav-hmj active" data-target="#daftar-calon-hmj" aria-controls="home-pills" data-toggle="tab" role="tab">Hima <span class="desc">{{ $calonHMJ->count() }} calon</span></a>
                        </li>
                        <li class="nav-item" style="cursor: pointer">
                            <a class="nav-link nav-dpm" data-target="#daftar-calon-dpm" aria-controls="messages-pills" data-toggle="tab" role="tab">DPM <span class="desc">{{ $calonDPM->count() }} calon</span></a>
                        </li>
                        <li class="nav-item" style="cursor: pointer">
                            <a class="nav-link nav-bem" data-target="#daftar-calon-bem" aria-controls="profile-pills" data-toggle="tab" role="tab">BEM <span class="desc">{{ $calonBEM->count() }} calon</span></a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-auto" id="timer">
                    <timer
                    :waktu="queue"
                    :use-hari="useHari"
                    :use-jam="useJam"
                    header="Waktu Anda"
                    ></timer>
                </div>
            </div>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="daftar-calon-hmj">
                    <div id="paslonhmj">
                        <div v-if="voted" class="mask">
                            <h4>Anda telah melakukan pemilihan calon ketua dan wakil ketua HMJ</h4>
                        </div>
                        <div :class="{row: true, blur: voted}" style="justify-content: center">
                            <card-paslon 
                            v-for="paslon in daftarPaslon" 
                            :key="paslon.id"
                            :no-urut="paslon.nomor" 
                            :id="paslon.id"
                            :foto="paslon.dir" 
                            :nama-ketua="paslon.nama_ketua" 
                            :nama-wakil="paslon.nama_wakil"
                            jenis="hmj"
                            :href="href"></card-paslon>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="daftar-calon-dpm">
                    <div id="paslondpm">
                        <div v-if="voted" class="mask">
                            <h4>Anda telah melakukan pemilihan anggota DPM</h4>
                        </div>
                        <div :class="{row: true, blur: voted}">
                            <card-calon-dpm 
                            v-for="paslon in daftarPaslon" 
                            :key="paslon.id" 
                            ref="satu" 
                            :id="paslon.id" 
                            :no-urut="paslon.nomor"                             
                            :foto="paslon.dir" 
                            :nama="paslon.nama"
                            :href="href"></card-calon-dpm>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="daftar-calon-bem">
                    <div id="paslonbem">
                        <div v-if="voted" class="mask">
                            <h4>Anda telah melakukan pemilihan calon ketua dan wakil ketua BEM</h4>
                        </div>
                        <div :class="{row: true, blur: voted}" style="justify-content: center">
                            <card-paslon 
                            v-for="paslon in daftarPaslon" 
                            :key="paslon.id" 
                            jenis="bem"
                            :id="paslon.id"
                            :no-urut="paslon.nomor"                             
                            :foto="paslon.dir" 
                            :nama-ketua="paslon.nama_ketua" 
                            :nama-wakil="paslon.nama_wakil"
                            :href="href"></card-paslon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-block -->
</div>

</div>

@endsection

@push('js')
<script>
    
    let hmj = new Vue({
        el: '#paslonhmj',
        data: {
            daftarPaslon: {!! $calonHMJ !!},
            href: '{{ route('mahasiswa.vote.hmj') }}',
            voted: {{ Auth::guard('mhs')->user()->telahMemilihHmj() ? 'true' : 'false' }},
            colClass: 'card col-sm card-calon'
        },
        created() {
            if(this.daftarPaslon.length == 1) {
                this.colClass = 'card col-lg-3 card-calon'
            }
            else if(this.daftarPaslon.length == 2) {
                this.colClass = 'card col-lg-4 card-calon'
            }
        }
    })
    
    let bem = new Vue({
        el: '#paslonbem',
        data: {
            daftarPaslon: {!! $calonBEM !!},
            href: '{{ route('mahasiswa.vote.bem') }}',
            voted: {{ Auth::guard('mhs')->user()->telahMemilihBem() ? 'true' : 'false' }},
            colClass: 'card col-sm card-calon'
        },
        created() {
            if(this.daftarPaslon.length == 1) {
                this.colClass = 'card col-lg-3 card-calon'
            }
            else if(this.daftarPaslon.length == 2) {
                this.colClass = 'card col-lg-4 card-calon'
            }
        }
    })
    
    let dpm = new Vue({
        el: '#paslondpm',
        data: {
            daftarPaslon: {!! $calonDPM !!},
            href: '{{ route('mahasiswa.vote.dpm') }}',
            voted: {{ Auth::guard('mhs')->user()->telahMemilihDpm() ? 'true' : 'false' }},
            colClass: ''
        }
    })
    
    const timer = new Vue({
        el: '#timer',
        data: {
            queue: [
                '{{ $waktu }}',
                '{{ $tambahan }}'
            ],
            useHari: false,
            useJam: false,
            now: '{{ $sekarang }}'
        },
        methods: {
            timerCallback() {
                swal({
                    title: 'Peringatan !',
                    text: 'Waktu untuk pemilihan telah habis. Anda akan keluar secara otomatis',
                    button: false,
                    closeOnClickOutside: false,
                })
                setTimeout(function () {
                    $('#keluar').submit()
                }, 1000)
            }
        }
    })
</script>
@endpush