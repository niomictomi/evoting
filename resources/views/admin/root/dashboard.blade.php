@extends('layouts.global')

@section('activity', 'Dashboard Root')

@section('title', 'Dasbor')

@section('content')
<div class="row">
    <div class="col-sm-6">
        <div class="card stats">
            <div class="card-block">
                <div class="title-block">
                    <h4 class="title">Statistik Sementara</h4>
                </div>
                
                <div class="row stats-container">
                    <div class="col-sm-6 stat-col">
                        <div class="stat-icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="stat">
                            <div class="value">{{ \App\Mahasiswa::aktif()->count() }}</div>
                            <div class="name">Mahasiswa aktif</div>
                        </div>
                        <div class="progress stat-progress">
                            <div class="progress-bar" style="width: 75%;"></div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 stat-col">
                        <div class="stat-icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="stat">
                            <div class="value">{{ \App\Mahasiswa::nonAktif()->count() }}</div>
                            <div class="name">Mahasiswa non aktif</div>
                        </div>
                        <div class="progress stat-progress">
                            <div class="progress-bar" style="width: 75%;"></div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 stat-col">
                        <div class="stat-icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="stat">
                            <div class="value">{{ \App\Mahasiswa::cuti()->count() }}</div>
                            <div class="name">Mahasiswa cuti</div>
                        </div>
                        <div class="progress stat-progress">
                            <div class="progress-bar" style="width: 75%;"></div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        @if($useTimer)        
        <div class="card">
            <div class="card-block">
                <div class="title-block">
                    <h4 class="title">Sisa waktu pemilihan</h4>
                </div>

                <div id="timer">
                    <timer
                    :waktu="waktu"
                    :useHari="useHari"
                    :useJam="useJam"
                    :header="header"
                    ></timer>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@push('js')
@if($useTimer)
<script>
    let timer = new Vue({
        el: '#timer',
        header: '{{ $header }}',
        data: {
            waktu: [
               '{{ $waktu }}'
            ],
            useJam: true,
            useHari: true
        },
        methods: {
            timerCallback() {
                window.location.reload()
            }
        }
    })
</script>
@endif
@endpush