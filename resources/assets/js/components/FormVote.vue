<template>
    <form :action="action" method="post">
        <input type="hidden" name="terpilih" :value="terpilih"/>
    </form>
</template>

<script>
export default {
    props: [
        'action'
    ],
    data() {
        return {
            voted: false,
            terpilih: null
        }
    },
    methods: {
        submit(id) {
            this.terpilih = id
            let that = this
            $.ajax({
                url: that.action,
                method: 'post',
                data: 'terpilih=' + that.terpilih,
                success: function(response) {
                    if(!response.error) {
                        that.voted = true
                    }
                    // menampilkan pesan
                    swal({
                        title: response.error ? 'Gagal !' : 'Berhasil !',
                        icon: response.error ? 'error' : 'success',
                        message: response.message
                    })
                },
                error: function(error) {
                    console.log(error)
                }
            })
        }
    }
}
</script>
