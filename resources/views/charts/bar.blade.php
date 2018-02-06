<div id="bar_{{ $id }}">
    <column-chart :data="arr" :colors="['#52BCD3']" ytitle="Jumlah Pemilih"></column-chart>
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