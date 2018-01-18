@extends('layouts.global')

@section('activity','Buka Kotak Suara')

@section('content')
    <div class="row">
        @foreach($users as $user)
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <div class="header-block">
                            <h3 class="title">{{ $user->nama }}</h3>
                        </div>
                        <div class="header-block pull-right">
                            <h3 class="title">{{ strtoupper($user->role) }}</h3>
                        </div>
                    </div>

                    <div class="card-block">
                        @if($user->helper == null || $user->helper == '')
                            <input name="id" value="{{ $user->id }}" type="hidden" disabled>
                            <div class="form-group">
                                <label class="control-label">Password</label>
                                <input type="password" placeholder="{{$user->name}} Belum Mengeset Password"
                                       name="password" class="form-control" disabled>
                            </div>
                            <input type="submit" value="Kirim" class="btn btn-info" disabled>
                        @else
                            @if($user->helper == 'secret')
                                <div class="form-group">
                                    <label class="control-label">Password</label>
                                    <div class="alert alert-info">
                                        Password dari {{ strtoupper($user->role) }} telah dikonfirmasi
                                    </div>
                                </div>
                            @else
                                <form action="{{ route('kakpu.simpan') }}" method="post">
                                    {{ csrf_field() }}
                                    <input name="id" value="{{ $user->id }}" type="hidden">
                                    <div class="form-group">
                                        <label class="control-label">Password</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                    <input type="submit" value="Kirim" class="btn btn-info">
                                </form>
                            @endif
                        @endif
                    </div>

                </div>
            </div>
        @endforeach
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
    @if (session()->has('error'))
        <script>
            swal({
                icon: "error",
                title: "{{ session()->get('error') }}"
            });

        </script>
    @endif
@endpush