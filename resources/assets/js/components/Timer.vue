<template>
    <div class="card">
        <div class="card-body">
            <h6>Waktu anda</h6>
            <div class="row">
                <div class="col">
                    <span class="time">{{ menit | duaDigit }}</span>
                    Menit
                </div>
                <div class="col">
                    <span class="time">{{ detik | duaDigit }}</span>
                    Detik
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'waktu', 'tambahan'
        ],
        data() {
            return {
                datawaktu: this.waktu,
                datatambahan: this.tambahan
            }
        },
        mounted() {
            let interval = window.setInterval(() => {
                if (this.datawaktu == 0) {
                    if (this.datatambahan > 0) {
                        this.datawaktu = this.datatambahan
                        this.datatambahan = 0
                    } else {
                        clearInterval(interval)
                        $('#keluar').submit()
                    }
                } else {
                    this.datawaktu = --this.datawaktu
                }
            }, 1000)
        },
        computed: {
            menit() {
                return Math.floor(this.datawaktu / 60)
            },
            detik() {
                return this.datawaktu - (Math.floor(this.datawaktu / 60) * 60)
            }
        },
        filters: {
            duaDigit(value) {
                if (value < 10)
                    return 0 + '' + value

                return value
            }
        }
    }
</script>