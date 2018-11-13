@foreach(\App\Jurusan::all() as $jurusan)

            <h3 class="title-divider">Hasil Perhitungan Suara Pemilihan jurusan {{ $jurusan->nama }}</h3>

        @include('charts.bar', [
            'data' => collect(\App\CalonHMJ::getHasilUntukDiagram($jurusan->id)),
            'id' => 'hasilhmj_'.$jurusan->id
        ])
        
        @include('charts.pie', [
            'data' => Chart::parse(collect(\App\CalonHMJ::getHasilUntukDiagram($jurusan->id))),
            'id' => 'pie_' . $jurusan->id
        ])

        <div class="row hasil">
            @foreach (\App\CalonHMJ::getDaftarCalon($jurusan->id)->get() as $calon)
            <div class="col">
                <h5>{{ $calon->getPemilih()->count() }}
                    <span>suara</span>
                </h5>
                <p class="nama">
                    {{ $calon->getKetua(false)->nama }}
                    <br/> {{ $calon->getWakil(false)->nama }}
                </p>
            </div>
            @endforeach
            <div class="col">
                <h5>{{ \App\Mahasiswa::getAbstainHmjViaRelation($jurusan->id)->count() }}
                    <span>suara</span>
                </h5>
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


@endforeach