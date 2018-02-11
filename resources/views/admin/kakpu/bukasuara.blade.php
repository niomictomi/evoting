@extends('layouts.global')

@section('activity','Buka Kotak Suara')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/bukasuara.css') }}">
@endpush

@section('content')
    @if(\App\Pengaturan::isVotingSedangBerlangsung()||\App\Pengaturan::isVotingAkanBerlangsung())

        <div class="alert alert-warning">
            <center>
                <b>Pemira Sedang berlansung</b>
            </center>
        </div>
        @elseif(\App\Pengaturan::isVotingTelahBerlangsung())
        @if(!\App\Pengaturan::checkJikaSemuaPasswordBukaHasilTelahDiisiKetuaKpu())
            <div class="row">
                @foreach($users as $user)
                    <div class="col-4">
                        <div class="card">
                            <div class="card-header">
                                <div class="header-block">
                                    <h3 class="title">{{ $user->nama }}</h3>
                                </div>
                                <div class="header-block pull-right">
                                    <h3 class="title">{{ strtoupper($user->role) }}</h3>
                                </div>
                            </div>

                            <div class="card-block">
                                @if($user->helper == null || $user->helper == '')
                                    <input name="id" value="{{ $user->id }}" type="hidden" disabled>
                                    <div class="form-group">
                                        <label class="control-label">Password</label>
                                        <input type="password" placeholder="{{$user->name}} Belum Mengeset Password"
                                               name="password" class="form-control" disabled>
                                    </div>
                                    <input type="submit" value="Kirim" class="btn btn-info" disabled>
                                @else
                                    @if($user->helper == 'secret')
                                        <div class="form-group">
                                            <label class="control-label">Password</label>
                                            <div class="alert alert-info">
                                                Password dari {{ strtoupper($user->role) }} telah dikonfirmasi
                                            </div>
                                        </div>
                                    @else
                                        <form action="{{ route('kakpu.simpan') }}" method="post">
                                            {{ csrf_field() }}
                                            <input name="id" value="{{ $user->id }}" type="hidden">
                                            <div class="form-group">
                                                <label class="control-label">Password</label>
                                                <input type="password" name="password" class="form-control">
                                            </div>
                                            <input type="submit" value="Kirim" class="btn btn-info">
                                        </form>
                                    @endif
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="alert alert-info">
                            Data Pemilihan bersifat rahasia
                        </div>
                        <div class="card-block">
                            @if(\App\Pengaturan::isVotingSedangBerlangsung())
                                <div class="alert alert-info">
                                    Pemira Sedang berlansung
                                </div>
                            @elseif(\App\Pengaturan::isVotingTelahBerlangsung())
                                @if(\App\Pengaturan::checkJikaSemuaPasswordBukaHasilTelahDiisiKetuaKpu())
                                    <div class="header-block">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{ strtoupper($hasil) }}
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                   href="{{ route('kakpu.buka', ['hasil' => 'bem']) }}">BEM</a>
                                                <a class="dropdown-item"
                                                   href="{{ route('kakpu.buka', ['hasil' => 'dpm']) }}">DPM</a>
                                                <a class="dropdown-item"
                                                   href="{{ route('kakpu.buka', ['hasil' => 'hmj']) }}">HMJ</a>
                                            </div>
                                        </div>
                                    </div>
                                    @if($hasil == 'bem')
                                        @include('admin.kakpu.include.bem')
                                    @elseif($hasil == 'dpm')
                                        @include('admin.kakpu.include.dpm')
                                    @elseif($hasil == 'hmj')
                                        @include('admin.kakpu.include.hmj')
                                    @endif


                                @else
                                    <a href="{{route('kakpu.buka')}}">
                                        <button class="btn btn-primary">Buka Kotak Suara</button>
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif

@endsection

@push('js')
    @if(session()->has('message'))
        <script>
            swal({
                icon: "success",
                title: "{{ session()->get('message') }}"
            });

        </script>

    @endif
    @if (session()->has('error'))
        <script>
            swal({
                icon: "error",
                title: "{{ session()->get('error') }}"
            });

        </script>
    @endif
@endpush