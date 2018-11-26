<h3 class="title-divider">Hasil Perhitungan Suara Pemilihan BEM</h3>

@include('charts.bar', [ 'data' => collect(\App\CalonBEM::getHasilUntukDiagram()), 'id' => 'hasilbem' ])

@include('charts.pie',
[ 'data' => Chart::parse(collect(\App\CalonBEM::getHasilUntukDiagram())), 'id' => 'qwerty' ])

<?php
$jum = 0;
?>
<div class="row hasil">
    @foreach (\App\CalonBEM::all() as $calon)
        <div class="col">
            <h5>{{ $calon->getPemilih()->count() }}
                <span>suara</span>
            </h5>
            <p class="nama">
                {{ $calon->getKetua(false)->nama }}
                <br/> {{ $calon->getWakil(false)->nama }}
            </p>
            <?php
            $jum += $calon->getPemilih()->count();
            ?>
        </div>
    @endforeach
    <div class="col">
        <h5>{{\App\Mahasiswa::where('status','A')->where('telah_login',true)->count()-$jum}}
            <span>suara</span>
        </h5>
        <p class="nama">
            Abstain
        </p>
    </div>
    <div class="col">
        <h5>{{\App\Mahasiswa::getMager()->count()}}
            <span>orang</span>
        </h5>
        <p class="nama">
            Mahasiswa Yang Tidak Berbartisipasi
        </p>
    </div>
    <div class="col">
        <h5>{{App\Mahasiswa::where('login',true)->count()}}
            <span>orang</span>
        </h5>
        <p class="nama">
            Mahasiswa Yang Telah Aktifasi
        </p>
    </div>
</div>
