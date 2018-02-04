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
                        @if(\App\Pengaturan::isVotingAkanBerlangsung())
                        <button type="button" class="btn btn-primary btn-sm rounded pull-right" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="fa fa-plus"></i> Tambah Paslon
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{route('form.dpm')}}">DPM</a>
                        </div>
                        @elseif(\App\Pengaturan::isVotingSedangBerlangsung()||\App\Pengaturan::isVotingTelahBerlangsung())
                            <button type="button" class="btn btn-primary btn-sm rounded pull-right" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" disabled><i class="fa fa-plus"></i> Tambah Paslon
                            </button>
                        @endif
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
                            <td><b>Nomor</b></td>
                            <td><b>NIM</b></td>
                            <td><b>Nama Calon anggota</b></td>
                            <td><b>aksi</b></td>
                            <td><b>Jurusan</b></td>
                        </tr>
                        </thead>
                        <tbody>
                                @foreach($dpm as $dpm)
                                    <tr>
                                    <td></td>
                                    <td><b>{{$dpm->anggota_id}}</b></td>
                                    <td><b>{{$dpm->getAnggota()->nama }}</b></td>
                                    <td>
                                        @if(\App\Pengaturan::isVotingAkanBerlangsung())
                                        <form method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <input type="hidden" name="id" value="{{ $dpm->id }}">
                                        </form>
                                        <div class="btn-group">
                                            <a href="{{url('panitia/paslon/'.$dpm->id.'/dpm/update')}}">
                                                <button class="btn btn-primary btn-sm btn-pill-left" data-toggle="modal"
                                                        data-target="#edit-{{ $dpm->id }}">Edit
                                                </button>
                                            </a>
                                            <a><button class="btn btn-danger btn-sm btn-pill-right">Hapus</button></a>
                                        </div>

                                        @elseif(\App\Pengaturan::isVotingSedangBerlangsung()||\App\Pengaturan::isVotingTelahBerlangsung())
                                            <button class="btn btn-primary btn-sm rounded" data-toggle="modal">Pemira Sedang Berlangsung
                                            </button>
                                        @endif
                                    </td>

                                        <td>
                                            @if($dpm->getAnggota()->getProdi()->jurusan_id==1)
                                                Pendidikan Ekonomi
                                            @elseif($dpm->getAnggota()->getProdi()->jurusan_id==2)
                                                Manajemen
                                            @elseif($dpm->getAnggota()->getProdi()->jurusan_id==3)
                                                Akutansi
                                            @elseif($dpm->getAnggota()->getProdi()->jurusan_id==4)
                                                Ilmu Ekonomi
                                            @endif


                                        </td>

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
