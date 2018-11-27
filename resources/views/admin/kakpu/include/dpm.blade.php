@php
    $jurusan = App\Jurusan::find($jur);
@endphp

<h3 class="title-divider">Hasil Perhitungan Suara Pemilihan jurusan {{ $jurusan->nama }}</h3>

@include('charts.bar', [
    'data' => collect(\App\CalonDPM::getHasilUntukDiagram($jurusan->id)),
    'id' => 'hasildpm_'.$jurusan->id
])

@include('charts.pie', [
    'data' => Chart::parse(collect(\App\CalonDPM::getHasilUntukDiagram($jurusan->id))),
    'id' => 'hasildpm_'.$jurusan->id
])

<div class="row hasil">
    @foreach (\App\CalonDPM::getDaftarCalon($jurusan->id)->get() as $calon)
        <div class="col">
            <h5>{{ $calon->getPemilihUnique()->count() }}
                <span>suara</span></h5>
            <p class="nama">
                {{ $calon->getAnggota(false)->nama }}
            </p>
        </div>
    @endforeach
    <div class="col">
        <h5>{{ \App\Mahasiswa::getAbstainDpmViaRelation($jurusan->id)->count() }}<span>suara</span></h5>
        <p class="nama">
            Abstain
        </p>
    </div>
    <div class="col">
        <h5>{{ $jurusan->getMahasiswaHanyaAktivasi()->count() }}
            <span>suara</span>
        </h5>
        <p class="nama">
            Aktivasi Tidak Login
        </p>
    </div>
</div>
