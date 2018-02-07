<template>
    <div>
        <h6>{{ header }}</h6>
        <div class="row">
            <div v-if="useHari" class="col">
                <span class="time">{{ hari | duaDigit }}</span>
                <span class="type">Hari</span>
            </div>
            <div v-if="useHari" class="col">
                <span class="time">:</span>
                <span class="type"></span>
            </div>
            <div v-if="useJam" class="col">
                <span class="time">{{ jam | duaDigit }}</span>
                <span class="type">Jam</span>
            </div>
            <div v-if="useJam" class="col">
                <span class="time">:</span>
                <span class="type"></span>
            </div>
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
        props: {
            waktu: {
                type: Array
            }, 
            useHari: {
                type: Boolean
            },
            useJam: {
                type: Boolean
            },
            header: {
                type: String
            }
        },
        data() {
            return {
                queueWaktu: this.waktu,
                datawaktu: Math.trunc(Date.parse(this.waktu[0]) / 1000),
                now: Math.trunc(Date.parse(this.$root.now) / 1000)
            }
        },
        mounted() {
            this.checkQueue()
            let interval = window.setInterval(() => {
                if (this.datawaktu - this.now == 0) {
                    // Jika array, maka index pertama akan dimasukkan ke datawaktu
                    if(this.queueWaktu.length > 1) {
                        this.removeFirstElement()
                        this.datawaktu = Math.trunc(Date.parse(this.queueWaktu[0]) / 1000)
                        this.now = Math.trunc((new Date()).getTime() / 1000)
                    } else {
                        clearInterval(interval)
                        // menjalankan callback dari root
                        this.$root.timerCallback()
                    }
                } else {
                    this.datawaktu = --this.datawaktu
                }
            }, 1000)
        },
        methods: {
            removeFirstElement() {
                this.queueWaktu = this.queueWaktu.slice(1, this.queueWaktu.length)
            },
            checkQueue() {
                while(this.datawaktu - this.now <= 0 && this.queueWaktu.length > 0) {
                    this.removeFirstElement()
                    this.datawaktu = Math.trunc(Date.parse(this.queueWaktu[0]) / 1000)
                }

                if(this.queueWaktu.length == 0)
                    this.$root.timerCallback()
            }
        },
        computed: {
            detik() {
                return (this.datawaktu - this.now) % 60;
            },
            menit() {
                return Math.trunc((this.datawaktu - this.now) / 60) % 60;
            },

            jam() {
                return Math.trunc((this.datawaktu - this.now) / 60 / 60) % 24;
            },
            hari() {
                return Math.trunc((this.datawaktu - this.now) / 60 / 60 / 24);
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