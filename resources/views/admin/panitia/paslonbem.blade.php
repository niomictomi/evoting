@extends('layouts.global')
@section('activity')
    Daftar Paslon
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bordered">
                <div class="header-block">
                    <h3 class="title">Daftar Paslon</h3>
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
                            <a class="dropdown-item" href="{{route('form.bem')}}">BEMF</a>
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
                            <td width="100"><b>Nomor</b></td>
                            <td width="20"><b>Nama Ketua</b></td>
                            <td width="20"><b>Nama Wakil Ketua</b></td>
                            <td width="50"><b>aksi</b></td>
                        </tr>
                        </thead>
                        <tbody>
                                @foreach($bem as $bem)
                                    <tr>
                                    <td></td>
                                    <td><b>{{$bem->ketua_id}}</b></td>
                                    <td><b>{{$bem->wakil_id}}</b></td>
                                    <td>
                                        @if(\App\Pengaturan::isVotingAkanBerlangsung())
                                        <form method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <input type="hidden" name="id" value="{{ $bem->id }}">
                                        </form>
                                        <div class="btn-group">
                                            <a href="{{url('panitia/paslon/'.$bem->id.'/bem/update')}}">
                                                <button class="btn btn-primary btn-sm btn-pill-left" data-toggle="modal"
                                                        data-target="#edit-{{ $bem->id }}">Edit
                                                </button>
                                            </a>
                                            <a><button class="btn btn-danger btn-sm btn-pill-right">Hapus</button></a>
                                        </div>
                                        @elseif(\App\Pengaturan::isVotingSedangBerlangsung()||\App\Pengaturan::isVotingTelahBerlangsung())
                                            <button class="btn btn-primary btn-sm rounded" data-toggle="modal">Pemira Sedang Berlangsung
                                            </button>
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
