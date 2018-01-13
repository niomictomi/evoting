<template>
    <div>
        <h6>Waktu anda</h6>
        <div class="row">
            <div class="col">
                <span class="time">{{ menit | duaDigit }}</span>
                <span class="type">Menit</span>
            </div>
            <div class="col">
                <span class="time">:</span>
                <span class="type"></span>
            </div>
            <div class="col">
                <span class="time">{{ detik | duaDigit }}</span>
                <span class="type">Detik</span>
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
                        swal({
                            title: 'Peringatan !',
                            text: 'Waktu untuk pemilihan telah habis. Anda akan keluar secara otomatis',
                            button: false,
                            closeOnClickOutside: false,
                        })
                        setTimeout(function () {
                            $('#keluar').submit()
                        }, 1500)
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