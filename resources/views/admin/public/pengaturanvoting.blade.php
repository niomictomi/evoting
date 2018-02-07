@extends('layouts.global')

@section('title', 'Pengaturan voting')

@section('content')
    @if ($errors->any())
        <div class="alert alert-warning">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="alert alert-info">
        <b>{{ \App\Pengaturan::getStatusVoting() }}</b>
        @if(session()->has('message'))
            <br><br>
            {{ session()->get('message') }}
        @endif
    </div>

    <div class="card">
        <div class="card-header bordered">
            <div class="header-block">
                <h3 class="title">Atur voting</h3>
            </div>
        </div>
        <div class="card-block">
            <form action="{{ route('admin.voting.pengaturan.update') }}" method="post">
                {{ csrf_field() }}
                {{ method_field('patch') }}
                <div class="form-group">
                    <label class="control-label">Mulai</label>
                    <div class="card-block" style="background-color: #e9ecef">
                        <input class="form-control" type="hidden" id="mulai" name="mulai" value="{{ $mulai }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Selesai</label>
                    <div class="card-block" style="background-color: #e9ecef">
                        <input class="form-control" type="hidden" id="selesai" name="selesai" value="{{ $selesai }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Panjang password untuk mahasiswa</label>
                    <input class="form-control" name="panjang_password" value="{{ $max_password }}" type="number" min="5">
                </div>
                <input type="submit" class="btn btn-success" value="Simpan" style="color: white">
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        @if($errors->any())
            swal({
                icon: "error",
                text: "{!! implode('\n', $errors->all()) !!}",
                html: true
            });
        @endif
        @if(session()->has('message'))
            swal({
                icon: "success",
                title: "{{ session()->get('message') }}"
            });
        @endif
        $('#mulai').datetimepicker({
            inline: true,
            locale: 'id',
            sideBySide: true,
            useCurrent: false,
            format: 'YYYY-MM-DD HH:mm'
        });
        $('#selesai').datetimepicker({
            inline: true,
            locale: 'id',
            sideBySide: true,
            useCurrent: false,
            format: 'YYYY-MM-DD HH:mm'
        });
        $("#mulai").on("change.datetimepicker", function (e) {
            $('#selesai').datetimepicker('minDate', e.date);
        });
        $('#selesai').datetimepicker('minDate', $('#mulai').val());
    </script>
@endpush