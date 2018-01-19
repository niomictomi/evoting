@extends('layouts.global')

@section('title', 'Dashboard')

@section('content')
    @if(\App\Pengaturan::isVotingSedangBerlangsung())
        @include('layouts.countdown', [
            'header' => 'Voting akan diakhiri dalam',
            'waktu' => \App\Pengaturan::getWaktuSelesai()
        ])
    @elseif(\App\Pengaturan::isVotingAkanBerlangsung())
        @include('layouts.countdown', [
            'header' => 'Voting akan dimulai dalam',
            'waktu' => \App\Pengaturan::getWaktuMulai()
        ])
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card stats" data-exclude="xs">
                <div class="card-block">
                    <div class="alert alert-info">
                        Data mahasiswa langsung diambil dari Pusat Pengembangan Teknologi Informasi
                    </div>
                    <div class="row" style="margin-bottom: 5px">
                        <div class="col-md-12">
                            <div class="stat-icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="stat">
                                <div class="value"> {{ $mhs }} <small>mahasiswa</small></div>
                                <div class="name"> Semua mahasiswa</div>
                            </div>
                            <div class="progress stat-progress">
                                <div class="progress-bar" style="width: 100%;"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="stat-icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="stat">
                                <div class="value"> {{ $mhsaktif }} <small>mahasiswa</small></div>
                                <div class="name"> Mahasiswa yang aktif</div>
                            </div>
                            <div class="progress stat-progress">
                                <div class="progress-bar" style="width: {{ $mhsaktif / $mhs * 100 }}%;"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="stat-icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="stat">
                                <div class="value"> {{ $mhscuti }} <small>mahasiswa</small></div>
                                <div class="name"> Mahasiswa yang cuti</div>
                            </div>
                            <div class="progress stat-progress">
                                <div class="progress-bar" style="width: {{ $mhscuti / $mhs * 100 }}%;"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="stat-icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="stat">
                                <div class="value"> {{ $mhsnonaktif }} <small>mahasiswa</small></div>
                                <div class="name"> Mahasiswa yang nonaktif</div>
                            </div>
                            <div class="progress stat-progress">
                                <div class="progress-bar" style="width: {{ $mhsnonaktif / $mhs * 100 }}%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-block">
                    @include('charts.pie', [
                        'data' => Chart::parse([
                            'Aktif' => \App\Mahasiswa::aktif()->count(),
                            'Non aktif' => \App\Mahasiswa::nonAktif()->count(),
                            'Cuti' => \App\Mahasiswa::cuti()->count()
                         ]),
                         'id' => 'qwerty'
                    ])
                </div>
            </div>
        </div>
    </div>

    @if(\App\Pengaturan::isVotingTelahBerlangsung() || \App\Pengaturan::isVotingSedangBerlangsung())
        <div class="card sameheight-item">
            <div class="card-block">
                <div class="card-title-block">
                    <h3 class="title">Jumlah pemilih dari waktu ke waktu</h3>
                </div>
                <!-- Nav tabs -->
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a href="" class="nav-link active" data-target="#home-pills" aria-controls="home-pills" data-toggle="tab" role="tab">HMJ</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link" data-target="#profile-pills" aria-controls="profile-pills" data-toggle="tab" role="tab">DPM</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link" data-target="#messages-pills" aria-controls="messages-pills" data-toggle="tab" role="tab">BEM</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="home-pills">
                        @foreach(\App\Jurusan::all() as $jurusan)
                            <div class="card">
                                <div class="card-header">
                                    <div class="header-block">
                                        <h3 class="title">Jumlah pemilih dari jurusan {{ $jurusan->nama }}</h3>
                                    </div>
                                </div>
                                <div class="card-block">
                                    @include('charts.bar', [
                                        'data' => \App\CalonHMJ::getJumlahVotingBarChart($jurusan->id),
                                        'id' => 'hmj_'.$jurusan->id
                                    ])
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="tab-pane fade" id="profile-pills">
                        @foreach(\App\Jurusan::all() as $jurusan)
                            <div class="card">
                                <div class="card-header">
                                    <div class="header-block">
                                        <h3 class="title">Jumlah pemilih dari jurusan {{ $jurusan->nama }}</h3>
                                    </div>
                                </div>
                                <div class="card-block">
                                    @include('charts.bar', [
                                        'data' => \App\CalonDPM::getJumlahVotingBarChart($jurusan->id),
                                        'id' => 'dpm_'.$jurusan->id
                                    ])
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="tab-pane fade" id="messages-pills">
                        {{--@foreach(\App\Jurusan::all() as $jurusan)--}}
                            {{--<div class="card">--}}
                                {{--<div class="card-header">--}}
                                    {{--<div class="header-block">--}}
                                        {{--<h3 class="title">Jumlah pemilih dari jurusan {{ $jurusan->nama }}</h3>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="card-block">--}}
                                    {{--@include('charts.bar', [--}}
                                        {{--'data' => \App\CalonBEM::getJumlahVotingBarChart($jurusan->id),--}}
                                        {{--'id' => 'bem_'.$jurusan->id--}}
                                    {{--])--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--@endforeach--}}
                    </div>
                </div>
            </div>
            <!-- /.card-block -->
        </div>
    @endif

    {{--@include('charts.bar', [--}}
    {{--'data' => Chart::parse(\App\CalonHMJ::getHasilUntukDiagram(5)),--}}
    {{--'id' => 'hasil'--}}
    {{--])--}}
    {{----}}
    {{--@include('charts.pie', [--}}
    {{--'data' => Chart::parse(\App\CalonHMJ::getHasilUntukDiagram(5)),--}}
    {{--'id' => 'asdfg'--}}
    {{--])--}}
    {{----}}
    {{--@include('charts.pie', [--}}
    {{--'data' => Chart::parse(\App\CalonDPM::getHasilUntukDiagram(5)),--}}
    {{--'id' => 'iuyt'--}}
    {{--])--}}
    {{----}}
    {{--@include('charts.pie', [--}}
    {{--'data' => Chart::parse(\App\CalonBEM::getHasilUntukDiagram()),--}}
    {{--'id' => 'hgf'--}}
    {{--])--}}
    {{----}}
@endsection