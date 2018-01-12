<template>
    <form :action="action" method="post">
        <input type="hidden" name="_token" :value="csrf"/>
        <input type="hidden" name="idterpilih" :value="terpilih"/>
    </form>
</template>

<script>
export default {
    props: [
        'terpilih', 'action'
    ],
    data() {
        return {
            csrf: document.head.querySelector('meta[name="csrf-token"]').content,
            voted: false
        }
    },
    methods: {
        submit() {
            axios.post(this.action).then((response) => {
                swal({
                    title: response.data.error ? 'Gagal !' : 'Berhasil !',
                    text: response.data.message,
                    icon: response.data.error ? 'error' : 'success',
                }).then(() => {
                        
                })
            }).catch((error) => {

            })
        },
        ubahTerpilih(id) {
            this.terpilih = id
            Vue.nextTick()
        }
    }
}
</script>
