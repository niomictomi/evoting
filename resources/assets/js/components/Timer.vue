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
        data() {
            return {
                waktu: 180,
                tambahan: 120
            }
        },
        mounted() {
            let interval = window.setInterval(() => {
                if (this.waktu == 0) {
                    if (this.tambahan > 0) {
                        this.waktu = this.tambahan
                        this.tambahan = 0
                    } else {
                        clearInterval(interval)
                        $('#keluar').submit()
                    }
                } else {
                    this.waktu = --this.waktu
                }
            }, 1000)
        },
        computed: {
            menit() {
                return Math.floor(this.waktu / 60)
            },
            detik() {
                return this.waktu - (Math.floor(this.waktu / 60) * 60)
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