@extends('layouts.global')

@section('content')
    <div class="title-block">
        <h3 class="title"> Form Paslon DPM
            <span class="sparkline bar" data-type="bar"></span>
        </h3>
    </div>
    <form role="form" method="post" action="{{route('dpm.save')}}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <section class="section ">
            <div class="row sameheight-container">
                <div class="col-md-6">
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="header-block">
                                <p class="title"> Data Calon Anggota </p>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="row form-group">
                                <div class="col-12">
                                    <label class="control-label">NIM Calon Anggota DPM</label>
                                    <input type="text" class="form-control underlined" name="anggota_id" maxlength="11" required>
                                    <label class="control-label">Foto</label>
                                    <input type="file" class="form-control" name="dir" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer"> *Pastikan data yang diinputkan telah <strong>benar</strong></div>
                    </div>


                </div>
                <div class="col-md-6">
                    <div class="card card-block">
                        <div class="title-block">
                            <h3 class="title"> Visi & Misi </h3>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Visi</label>
                            <textarea rows="3" class="form-control" name="visi" required></textarea>
                            <label class="control-label">Misi</label>
                            <textarea rows="3" class="form-control" name="misi" required> </textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn rounded btn-info">Tambah</button>
                </div>
            </div>
        </section>
    </form>
@endsection
@push('js')
    @if(session()->has('error'))
        <script>
            swal({
                title: "Oops !",
                icon: "error",
                text: "{{ session()->get('error') }}"
            });
        </script>

    @endif
@endpush