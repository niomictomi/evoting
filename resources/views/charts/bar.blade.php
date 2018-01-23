<div id="bar_{{ $id }}">
    <column-chart :data="arr" :colors="['#b00']" xtitle="Waktu" ytitle="Jumlah Pemilih"></column-chart>
</div>

@push('js')
<script>
    var bar_{{ $id }} = new Vue({
        el: '#bar_{{ $id }}',
        data: {
            arr: {!! $data !!}
        }
    })
</script>
@endpush