<div id="bar-{{ $id }}">
    <column-chart :data="arr" :colors="['#b00']" xtitle="Waktu" ytitle="Jumlah Pemilih" :stacked="true"></column-chart>
</div>

@push('js')
<script>
    let bar_{{ $id }} = new Vue({
        el: '#bar-{{ $id }}',
        data: {
            arr: {!! $data !!}
        }
    })
</script>
@endpush