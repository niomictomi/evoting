@extends('layouts.global')

@section('title', 'Dashboard')

@section('content')
    <div class="card stats" data-exclude="xs">
        <div class="card-block">
            <div class="row" style="margin-bottom: 5px">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="stat">
                        <div class="value"> {{ $mhs }}</div>
                        <div class="name"> Semua mahasiswa</div>
                    </div>
                    <div class="progress stat-progress">
                        <div class="progress-bar" style="width: 100%;"></div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="stat">
                        <div class="value"> {{ $mhsaktif }}</div>
                        <div class="name"> Mahasiswa yang aktif</div>
                    </div>
                    <div class="progress stat-progress">
                        <div class="progress-bar" style="width: {{ $mhsaktif / $mhs * 100 }}%;"></div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="stat">
                        <div class="value"> {{ $mhscuti }}</div>
                        <div class="name"> Mahasiswa yang cuti</div>
                    </div>
                    <div class="progress stat-progress">
                        <div class="progress-bar" style="width: {{ $mhscuti / $mhs * 100 }}%;"></div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="stat">
                        <div class="value"> {{ $mhsnonaktif }}</div>
                        <div class="name"> Mahasiswa yang nonaktif</div>
                    </div>
                    <div class="progress stat-progress">
                        <div class="progress-bar" style="width: {{ $mhsnonaktif / $mhs * 100 }}%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection