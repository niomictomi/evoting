@extends('layouts.global')
@section('activity')
@endsection

@section('content')

    <div class="card">
        <div class="card-header bordered">
            <div class="header-block">
                <h2>Daftar Mahasiswa </h2>
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
            <center>
                <form action="{{route('cari')}}" method="get">
                    <div class="input-group col-6">
                        <input type="text" class="form-control boxed rounded-s" placeholder="NIM Mahasiswa..."
                               name="id">
                        <span class="input-group-btn">
                            <button class="btn btn-danger rounded-s" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </center>
        </div>
    </div>
    <div class="card-block">
        <center>
            @if(is_null($result))
            @else
                <div class="col-xl-4">
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="header-block">
                                <p class="title"> {{$result->nama}} </p>
                            </div>
                        </div>
                        <div class="card-block">
                            <p>{{$result->id}}</p>
                            <p>{{ $result->getProdi()->nama }}</p>
                        </div>
                        <div class="card-footer">
                            @if ($result->login == 0 && $result->telah_login == 0)
                                <form action="{{url('panitia/resepsionis/'.$result->id.'/update')}}" method="post">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm rounded">Belum Aktif
                                    </button>
                                    <input hidden="" value="1" name="login">'.
                                </form>
                            @elseif($result->login == 0 && $result->telah_login == 1)
                                <button type="button" class="btn btn-primary btn-sm rounded">Telah Login</button>
                            @elseif ($result->login == 1 && $result->telah_login == 1)
                                <button type="button" class="btn btn-primary btn-sm rounded">Aktif</button>
                            @elseif ($result->login == 1 && $result->telah_login == 0)
                                <button type="button" class="btn btn-primary btn-sm rounded">Aktif</button>

                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </center>
    </div>

@endsection

@push('js')
    @if(session()->has('message'))
        <script>
            swal({
                title:"Berhasil !",
                icon: "success",
                text: "{{ session()->get('message') }}"
            });
        </script>

    @endif
    <script type="text/javascript">
        {{--$('#mahasiswa').DataTable({--}}
        {{--processing: true,--}}
        {{--serverSide: true,--}}
        {{--ajax: "{{route('api.resepsionis')}}",--}}
        {{--columns: [--}}
        {{--{data: 'id', name: 'id'},--}}
        {{--{data: 'nama', name: 'nama'},--}}
        {{--{data: 'prodi', name: 'prodi_id'},--}}
        {{--{data: 'action', name: 'action', orderable: false, searchable: false},--}}
        {{--],--}}
        {{--columnDefs: [--}}
        {{--{"visible": false, "targets": 0}--}}
        {{--]--}}

        {{--});--}}

        function addForm() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Add Contact');
        }

        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();
            $.ajax({
                url: "{{ url('contact') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Edit Contact');
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                },
                error: function () {
                    alert("Nothing Data");
                }
            });
        }

        function deleteData(id) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then(function () {
                $.ajax({
                    url: "{{ url('contact') }}" + '/' + id,
                    type: "POST",
                    data: {'_method': 'DELETE', '_token': csrf_token},
                    success: function (data) {
                        table.ajax.reload();
                        swal({
                            title: 'Success!',
                            text: data.message,
                            type: 'success',
                            timer: '1500'
                        })
                    },
                    error: function () {
                        swal({
                            title: 'Oops...',
                            text: data.message,
                            type: 'error',
                            timer: '1500'
                        })
                    }
                });
            });
        }

        $(function () {
            $('#modal-form form').validator().on('submit', function (e) {
                if (!e.isDefaultPrevented()) {
                    var id = $('#id').val();
                    if (save_method == 'add') url = "{{ url('contact') }}";
                    else url = "{{ url('contact') . '/' }}" + id;
                    $.ajax({
                        url: url,
                        type: "POST",
//                        data : $('#modal-form form').serialize(),
                        data: new FormData($("#modal-form form")[0]),
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                            swal({
                                title: 'Success!',
                                text: data.message,
                                type: 'success',
                                timer: '1500'
                            })
                        },
                        error: function (data) {
                            swal({
                                title: 'Oops...',
                                text: data.message,
                                type: 'error',
                                timer: '1500'
                            })
                        }
                    });
                    return false;
                }
            });
        });
    </script>

@endpush
