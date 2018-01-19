@extends('layouts.global')

@section('content')
    <div class="title-block">
        <h3 class="title"> Form Paslon HMJ
            <span class="sparkline bar" data-type="bar"></span>
        </h3>
    </div>
    <form role="form" method="post" action="{{route('update.hmj')}}" enctype="multipart/form-data">
        {{ csrf_field() }}

        <section class="section ">
            <div class="row sameheight-container">
                <div class="col-md-6">
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="header-block">
                                <p class="title"> Data Calon Ketua</p>

                            </div>
                        </div>
                        <div class="card-block">
                            <div class="row form-group">
                                <div class="col-3 form-group">
                                    <div class="images-container">
                                        <a href="#" class="add-image" data-toggle="modal"
                                           data-target="#modal-media">
                                            <div class="image-container new">
                                                <div class="image">
                                                    <i class="fa fa-plus"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <label class="control-label">NIM Calon Ketua Ketua </label>
                                    <input type="text" class="form-control underlined" name="ketua_id" maxlength="11" value="{{$edithmj->ketua_id}}" required>
                                    <input type="hidden" class="form-control underlined" name="id" maxlength="11" value="{{$edithmj->id}}" required>
                                    <input type="file" class="form-control underlined" name="dir">
                                    <label class="control-label">NIM Calon Ketua Wakil Ketua</label>
                                    <input type="text" class="form-control underlined" name="wakil_id" maxlength="11" value="{{$edithmj->wakil_id}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer"> *Pastikan data yang diinputkan telah <strong>benar</strong></div>
                    </div>


                </div>
                <div class="col-md-6">
                    <div class="card card-block sameheight-item">
                        <div class="title-block">
                            <h3 class="title"> Visi & Misi </h3>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Visi</label>
                            <textarea rows="3" class="form-control" name="visi" required>{{$edithmj->visi}}</textarea>
                            <label class="control-label">Misi</label>
                            <textarea rows="3" class="form-control" name="misi" required>{{$edithmj->misi}} </textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-oval btn-info">Submit</button>
                </div>
            </div>
        </section>
    </form>

@endsection
