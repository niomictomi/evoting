@extends('layouts.global')
@section('activity')
    Daftar Paslon
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bordered">
                <div class="header-block">
                    <h3 class="title">Daftar Paslon HMJ</h3>
                </div>
                <div class="header-block pull-right">
                    {{--<a href="{{route('panitia.paslon.form')}}" class="btn btn-primary btn-sm rounded pull-right" >Tambah--}}
                    {{--Paslon</a>--}}
                    <div class="btn-group">
                        @if(\App\Pengaturan::isVotingAkanBerlangsung())
                            <button type="button" class="btn btn-primary btn-sm rounded pull-right"
                                    data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false"><i class="fa fa-plus"></i> Tambah Paslon
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{route('form.hmj')}}">HMJ</a>
                            </div>
                        @elseif(\App\Pengaturan::isVotingSedangBerlangsung()||\App\Pengaturan::isVotingTelahBerlangsung())
                            <button type="button" class="btn btn-primary btn-sm rounded pull-right"
                                    data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" disabled><i class="fa fa-plus"></i>
                                Tambah Paslon
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
                            <td width="100"><b>Nomor</b></td>
                            <td width="20"><b>Nama Ketua</b></td>
                            <td width="20"><b>Nama Wakil Ketua</b></td>
                            <td width="50"><b>Aksi</b></td>
                            <td width="50"><b>Jurusan</b></td>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($hmj as $hmj)
                            <tr>
                                <td>
                                    @if(\App\Pengaturan::isVotingAkanBerlangsung())
                                        @if($hmj->nomor== null || $hmj->nomor == '')
                                            <form action="{{route('no.hmj')}}" method="post">
                                                {{ csrf_field() }}
                                                <div class="input-group col-6">
                                                    <input type="text" class="form-control underlined" name="nomor"
                                                           maxlength="11" placeholder="isikan Nomor Paslon"
                                                           required>
                                                    <span class="input-group-btn">
                                                <button class="btn btn-danger rounded-s" type="submit">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                </span>
                                                </div>
                                                <input type="text" class="form-control underlined" name="id"
                                                       maxlength="11"
                                                       value="{{$hmj->id}}"
                                                       required hidden>
                                            </form>
                                        @else
                                            {{$hmj->nomor}}
                                        @endif
                                    @else
                                        {{$hmj->nomor}}
                                    @endif
                                </td>
                                <td><b>{{$hmj->ketua_id}}</b></td>
                                <td><b>{{$hmj->wakil_id}}</b></td>
                                <td>
                                    @if(\App\Pengaturan::isVotingAkanBerlangsung())
                                        <form method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <input type="hidden" name="id" value="{{ $hmj->id }}">
                                        </form>
                                        <div class="btn-group">
                                            <a href="{{url('panitia/paslon/'.$hmj->id.'/update')}}">
                                                <button class="btn btn-primary btn-sm btn-pill-left" data-toggle="modal"
                                                        data-target="#edit-{{ $hmj->id }}">Edit
                                                </button>
                                            </a>
                                            <form action="{{ route('paslon.delete') }}" method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{ $hmj->id }}">
                                                <button type="submit" class="btn btn-danger btn-sm btn-pill-right">Hapus</button>
                                            </form>

                                        </div>
                                    @elseif(\App\Pengaturan::isVotingSedangBerlangsung()||\App\Pengaturan::isVotingTelahBerlangsung())
                                        <button class="btn btn-primary btn-sm rounded" data-toggle="modal">Pemira Sedang
                                            Berlangsung
                                        </button>
                                    @endif
                                </td>
                                <td>
                               {{\App\Jurusan::find($hmj->getKetua()->getProdi()->jurusan_id)->nama}}
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
