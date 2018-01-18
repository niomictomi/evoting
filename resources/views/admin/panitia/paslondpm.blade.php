@extends('layouts.global')
@section('activity')
    Daftar Paslon
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bordered">
                <div class="header-block">
                    <h3 class="title">Daftar Paslon DPM</h3>
                </div>
                <div class="header-block pull-right">
                    {{--<a href="{{route('panitia.paslon.form')}}" class="btn btn-primary btn-sm rounded pull-right" >Tambah--}}
                    {{--Paslon</a>--}}
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm rounded pull-right" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="fa fa-plus"></i> Tambah Paslon
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{route('form.dpm')}}">DPM</a>
                        </div>
                    </div>
                    <div class="modal fade" id="tambah" tabindex="-1" role="dialog"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="card">
                                <div class="card-header bordered">
                                    <div class="header-block">
                                        <h3 class="title">Tambah Paslon</h3>
                                    </div>
                                    <div class="header-block pull-right">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-block">

                <div class="table-responsive">

                    <table class="table table-hover" id="panitia">
                        <thead>
                        <tr>
                            <td width="100"><b>Nomor</b></td>
                            <td width="20"><b>NIM</b></td>
                            <td width="20"><b>Nama Calon anggota</b></td>
                            <td width="50"><b>Foto</b></td>
                        </tr>
                        </thead>
                        <tbody>
                                @foreach($dpm as $dpm)
                                    <tr>
                                    <td></td>
                                    <td><b>{{$dpm->anggota_id}}</b></td>
                                    <td><b></b></td>
                                    <td><img src="{{asset('storage/'.$dpm->dir)}}" style="width: 80%;height: 30%;"></td>
                                    </tr>
                                @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
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
@endpush
