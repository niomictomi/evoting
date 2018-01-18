@extends('layouts.global')
@section('activity','Buka Kotak Suara')
@section('content')
    <div class="row sameheight-container">
            <div class="col-4">
                <div class="card">
                    <div class="card-block">
                        <div class="title-block">
                            <div class="header-block">
                                <h3 class="title">{{ \Illuminate\Support\Facades\Auth::user()->nama }}  ({{ strtoupper(\Illuminate\Support\Facades\Auth::user()->role) }})</h3>
                            </div>
                        </div>
                        <form action="{{ url('dosen/buka/'.\Illuminate\Support\Facades\Auth::user()->id.'/save') }}"
                              method="post">

                            {{ csrf_field() }}


                                <div class="form-group row">
                                    <label class="col-md-4" for="id">Password</label>
                                    <div class="col-md-8">
                                        <input type="password" class="form-control" name="helper"/>
                                    </div>
                                </div>

                            <div class="form-group row">
                                <label class="col-md-4"></label>
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
    </div>
@endsection
@push('js')
    @if(session()->has('message'))
        <script>
            swal({
                title: 'Berhasil ! ',
                icon: "success",
                text: "{{ session()->get('message') }}"
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