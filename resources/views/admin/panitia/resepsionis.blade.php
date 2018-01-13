@extends('layouts.global')
@section('activity')
    @endsection

@section('content')

    <div class="card">
        <div class="card-header bordered">
            <div class="header-block">
                <h2 >Daftar Mahasiswa </h2>
            </div>
            <div class="header-block pull-right">
                <div class="modal fade" id="tambah" tabindex="-1" role="dialog"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="card">
                            <div class="card-header bordered">
                                <div class="header-block">
                                    <h3 class="title">Tambah Panitia</h3>
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
                        <td><b>NIM</b></td>
                        <td><b>Nama</b></td>
                        <td><b>Prodi</b></td>
                        <td><b>Status</b></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($result as $result)
                        <tr>
                            <td>{{ $result->id }}</td>
                            <td>{{ $result->nama }}</td>
                            <td>
                                @if($result->prodi_id==1)
                                    S1 Pendidikan Ekonomi
                                @elseif($result->prodi_id==2)
                                    S1 Pendidikan Administrasi Perkantoran
                                @elseif($result->prodi_id==3)
                                    S1 Pendidikan Akutansi
                                @elseif($result->prodi_id==4)
                                    S1 Pendidikan Tata Niaga
                                @elseif($result->prodi_id==5)
                                    S1 Manajemen
                                @elseif($result->prodi_id==6)
                                    S1 Akutansi
                                @elseif($result->prodi_id==7)
                                    D3 Akutansi
                                @elseif($result->prodi_id==8)
                                    S1 Ekonomi Islam
                                @elseif($result->prodi_id==9)
                                    S1 Ilmu Ekonomi
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    @if($result->login == false)
                                        <form action="{{url('panitia/resepsionis/'.$result->id.'/update')}}"
                                              method="post">
                                            {{csrf_field()}}
                                            <button type="submit" class="btn btn-danger btn-sm btn-pill-right">Belum Aktif
                                            </button>
                                            <input hidden="" value="1" name="login">
                                        </form>
                                    @else
                                        <button type="button" class="btn btn-primary btn-sm btn-pill-right">Aktif</button>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
