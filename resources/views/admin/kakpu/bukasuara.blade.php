@extends('layouts.global')
@section('activity','Buka Kotak Suara')
@section('content')
    <div class="row sameheight-container">
        @if (\Illuminate\Support\Facades\Auth::user()->role=='ketua kpu')
        <div class="col">
            <div class="card">
                <div class="card-block">
                    <div class="title-block">
                        <h4 class="title">Wakil Dekan 3</h4>
                    </div>

                    <form action="{{ route('admin.pengaturan') }}" method="post">

                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label class="col-md-4" for="id">Password</label>
                            <div class="col-md-8">
                                <input type="text" name="helper" class="form-control" disabled=""/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4"></label>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary" disabled>Ubah</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-block">
                    <div class="title-block">
                        <h4 class="title">Dosen</h4>
                    </div>

                    <form action="{{ route('admin.ubah.password') }}" method="post">

                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label class="col-md-4" for="id">Password</label>
                            <div class="col-md-8">
                                <input type="password" class="form-control" name="passlama" disabled=""/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4"></label>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary" disabled="">Ubah</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-block">
                    <div class="title-block">
                        <h4 class="title">Ketua KPU</h4>
                    </div>

                    <form action="{{ route('kakpu.buka.save') }}" method="post">

                        {{ csrf_field() }}


                        <div class="form-group row">
                            <label class="col-md-4" for="id">Password</label>
                            <div class="col-md-8">
                                <input type="password" class="form-control" name="helper" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4"></label>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary" >Ubah</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        @endif
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