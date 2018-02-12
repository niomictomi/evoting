<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> @yield('activity') </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <!-- Place favicon.ico in the root directory -->
    <!-- Theme initialization -->
    <link rel="stylesheet" href="{{ asset('modular/css/vendor.css') }}">
    {{--<link rel="stylesheet" href="{{ asset('modular/css/app-red.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/dataTables.responsive.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/tempusdominus-bootstrap-4.css') }}" rel="stylesheet">

</head>
<body>

<br><br><br><br><br><br>
<div>
    <div>
        <center>
            <img src="{{asset('images/logo.jpg')}}">
        </center>
    </div>
    <br><br>

    <div>
        @if($hasil=='BEM'||$hasil=='HMJ')
            <center><h2>HASIL PEROLEHAN SUARA UNTUK TIAP
                    PASANGAN KANDIDAT </h2>
                <h2> KETUA DAN WAKIL KETUA {{$hasil}}
                    FAKULTAS EKONOMI UNESA
                    DI TEMPAT PEMUNGUTAN SUARA</h2>
                @elseif($hasil=='DPM')
                    <center>
                        <h2>
                            SERTIFIKAT HASIL PEROLEHAN SUARA UNTUK TIAP
                            KANDIDAT ANGGOTA DPM
                            FAKULTAS EKONOMI UNESA
                            DI TEMPAT PEMUNGUTAN SUARA
                        </h2>
                    </center>
                @endif
            </center>
    </div>
    <br><br><br>
    <div>
        <center>
            @if($hasil=='BEM')
                <table class="table col-md-9" style="text-align: center">
                    <tr>
                        <td>No. Urut</td>
                        <td>Nama Kandidat</td>
                        <td>Jumlah Suara</td>
                        <td>Presentase (%)</td>
                    </tr>
                    @foreach (\App\CalonBEM::all() as $calon)
                        <tr>
                            <td>{{$calon->nomor}}</td>
                            <td>{{ $calon->getKetua()->nama }}
                                <br/> {{ $calon->getWakil()->nama }}</td>
                            <td>{{ $calon->getPemilih()->count() }}</td>
                            <td>{{ ($calon->getPemilih()->count())*100}}%</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2">Tidak Memilih</td>
                        <td>{{ \App\Mahasiswa::getAbstainBemViaRelation()->count() }}</td>
                        <td>%</td>
                    </tr>
                    <tr>
                        <td colspan="2">Total Suara dan Presentase</td>
                        <td>}</td>
                        <td>100%</td>
                    </tr>
                </table>
                <br><br><br><br>


            @elseif($hasil=='HMJ')
                @foreach(\App\Jurusan::all() as $jurusan)
                    <center><h3>Hasil Pemilihan Jurusan {{$jurusan->nama}}</h3></center>
                    <table class="table col-md-9" style="text-align: center">
                        <tr>
                            <td><strong>No. Urut</strong></td>
                            <td><strong>Nama Kandidat</strong></td>
                            <td><strong>Jumlah Suara</strong></td>
                            <td><strong>Presentase (%)</strong></td>
                        </tr>

                        @foreach (\App\CalonHMJ::getDaftarCalon($jurusan->id)->get() as $calon)
                            <tr>
                                <td>{{$calon->nomor}}</td>
                                <td>{{ $calon->getKetua()->nama }}
                                    <br/> {{ $calon->getWakil()->nama }}</td>
                                <td>{{ $calon->getPemilih()->count() }}</td>
                                <td>{{ ($calon->getPemilih()->count()/\App\Jurusan::find($jurusan->id)->getMahasiswa()->where('status','A')->count())*100 }}
                                    %
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2">Tidak Memilih</td>
                            <td>{{ \App\Mahasiswa::getAbstainHmjViaRelation($jurusan->id)->count() }}</td>
                            <td>{{ (\App\Mahasiswa::getAbstainHmjViaRelation($jurusan->id)->count()/\App\Jurusan::find($jurusan->id)->getMahasiswa()->where('status','A')->count())*100}}
                                %
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Total Suara dan Presentase</td>
                            <td>{{\App\Jurusan::find($jurusan->id)->getMahasiswa()->where('status','A')->count()}}</td>
                            <td></td>
                        </tr>
                    </table>
                    <br><br><br><br><br><br>
                @endforeach



            @elseif($hasil=='DPM')
                @foreach(\App\Jurusan::all() as $jurusan)
                    <center><h3>Hasil Pemilihan Jurusan {{$jurusan->nama}}</h3></center>
                    <table class="table col-md-9" style="text-align: center">
                        <tr>
                            <td><strong>No. Urut</strong></td>
                            <td><strong>Nama Kandidat</strong></td>
                            <td><strong>Jumlah Suara</strong></td>
                            <td><strong>Presentase (%)</strong></td>
                        </tr>

                        @foreach (\App\CalonDPM::getDaftarCalon($jurusan->id)->get() as $calon)
                            <tr>
                                <td>{{$calon->nomor}}</td>
                                <td>{{ $calon->getAnggota()->nama }}</td>
                                <td>{{ $calon->getPemilih()->count() }}</td>
                                <td>{{ ($calon->getPemilih()->count()/\App\Jurusan::find($jurusan->id)->getMahasiswa()->where('status','A')->count())*100 }}
                                    %
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2">Tidak Memilih</td>
                            <td>{{ \App\Mahasiswa::getAbstainDpmViaRelation($jurusan->id)->count() }}</td>
                            <td>{{ (\App\Mahasiswa::getAbstainDpmViaRelation($jurusan->id)->count()/\App\Jurusan::find($jurusan->id)->getMahasiswa()->where('status','A')->count())*100}}
                                %
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">Total Suara dan Presentase</td>
                            <td>{{\App\Jurusan::find($jurusan->id)->getMahasiswa()->where('telah_login',true)->count()}}</td>
                            <td></td>
                        </tr>
                    </table>
                    <br><br><br><br><br><br>
                @endforeach
            @endif
        </center>
    </div>
</div>

</body>
</html>