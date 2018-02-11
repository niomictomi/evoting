<div class="card">
    <div class="card-block">
        <div id="timer">
            <timer
            :waktu="waktu"
            :use-hari="useHari"
            :use-jam="useJam"
            header="{{ $header }}"
            ></timer>
        </div>
    </div>
</div>

@push('js')
<script>
let timer = new Vue({  
    el: '#timer',
    data: {
        waktu: ['{{ $waktu }}'],
        useHari: true,
        useJam: true,
        now: '{{ Carbon\Carbon::now() }}'
    },
    methods: {
        timerCallback() {
            // noting to do
        }
    }
})
</script>
@endpush