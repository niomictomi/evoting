<div id="pie-{{ $id }}">
    <pie-chart :data="arr" :legend="true"></pie-chart>
</div>

@push('js')
<script>
    let pie_{{ $id }} = new Vue({
        el: '#pie-{{ $id }}',
        data: {
            arr: {!! $data !!}
        }
    })
</script>
@endpush