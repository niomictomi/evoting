@extends('layouts.global')
@section('activity')
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bordered">
                <div class="header-block">
                    <h3 class="title">Daftar Paslon</h3>
                </div>
                <div class="header-block pull-right">
                    <a href="{{route('panitia.paslon.form')}}" class="btn btn-primary btn-sm rounded pull-right" >Tambah
                        Panitia</a>
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
                                {{--<div class="card-block">--}}
                                {{--<form method="post">--}}
                                {{--{{ csrf_field() }}--}}
                                {{--<fieldset class="form-group">--}}
                                {{--<label class="control-label">NIM</label>--}}
                                {{--<input type="number" class="form-control underlined" minlength="11" maxlength="11" required>--}}
                                {{--</fieldset>--}}
                                {{--<fieldset class="form-group">--}}
                                {{--<label class="control-label">Nama</label>--}}
                                {{--<input type="text" class="form-control underlined" required>--}}
                                {{--</fieldset>--}}
                                {{--<fieldset class="form-group">--}}
                                {{--<label class="control-label">Hak Akses</label>--}}
                                {{--<select name="role" class="form-control underlined" required>--}}
                                {{--@foreach(\App\Support\Role::ALL as $role)--}}
                                {{--@if($role == \App\Support\Role::PANITIA)--}}
                                {{--@foreach(\App\Support\Role::PANITIA_ALL as $p)--}}
                                {{--<option value="{{ $role.';'.$p }}">--}}
                                {{--{{ strtoupper($role.' - '.$p) }}--}}
                                {{--</option>--}}
                                {{--@endforeach--}}
                                {{--@elseif($role != \App\Support\Role::ADMIN && $role != \App\Support\Role::ROOT)--}}
                                {{--<option value="{{ $role }}">--}}
                                {{--{{ strtoupper($role) }}--}}
                                {{--</option>--}}
                                {{--@endif--}}
                                {{--@endforeach--}}
                                {{--</select>--}}
                                {{--</fieldset>--}}
                                {{--<button type="submit" class="btn btn-success" style="color: white">Simpan</button>--}}
                                {{--</form>--}}
                                {{--</div>--}}
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
                            <td><b>Nama </b></td>
                            <td><b>Hak Akses</b></td>
                            <td><b>Aksi</b></td>
                            <td><b>Aksi</b></td>
                        </tr>
                        </thead>
                        <tbody>

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
