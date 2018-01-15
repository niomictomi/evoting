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
                <table class="table table-hover" id="mahasiswa">
                    <thead>
                    <tr>
                        <td><b>NIM</b></td>
                        <td><b>Nama</b></td>
                        <td><b>Prodi</b></td>
                        <td><b>Status</b></td>
                    </tr>
                    </thead>
                    <tbody>

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
    <script>
        $('#mahasiswa').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('api.resepsionis')}}",
            columns: [
                {data: 'id', name:'id'},
                {data: 'nama', name:'nama'},
                {data: 'prodi_id', name:'prodi_id'},
                {data: 'login', name:'login', orderable:false , searchable:true}
            ]
        });
    </script>
@endpush
