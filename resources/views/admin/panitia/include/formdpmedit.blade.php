@extends('layouts.global')

@section('content')
    <div class="title-block">
        <h3 class="title"> Form Paslon DPM
            <span class="sparkline bar" data-type="bar"></span>
        </h3>
    </div>
    <form role="form" method="post" action="{{route('update.dpm')}}" enctype="multipart/form-data">
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
                                    <input type="text" class="form-control underlined" name="anggota_id" value="{{$editdpm->anggota_id}}" maxlength="11" required>
                                    <label class="control-label">Foto</label>
                                    <br>
                                    <img src="{{asset($editdpm->dir)}}" class="img image-container" style="width: 40%;height: 40%">
                                    <input type="file" class="form-control" name="newdir" >
                                    <input type="hidden" name="dir" value="{{$editdpm->dir}}">
                                    <input type="hidden" name="id" value="{{$editdpm->id}}">
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
                            <textarea rows="3" class="form-control use-tinymce" name="visi" required>{!! $editdpm->visi !!} </textarea>
                            <label class="control-label">Misi</label>
                            <textarea rows="3" class="form-control  use-tinymce" name="misi" required>{!! $editdpm->misi !!} </textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn rounded btn-info">Sunting</button>
                </div>
            </div>
        </section>
    </form>
@endsection

@push('js')
    @if(session()->has('error'))
        <script>
            swal({
                icon: "error",
                title: "{{ session()->get('error') }}"
            });
        </script>

    @endif
@endpush