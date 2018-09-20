<template>
     <div :class="colClass">
        <div class="nomor-urut">{{ noUrut }}</div>
        <img class="card-img-top" :src="foto" :alt="nama">
        <div class="card-body">
            <h6>Calon Anggota DPM</h6>
            <h4>{{ nama }}</h4>
            <div class="row justify-content-sm-center">
                <div class="col-auto">
                    <button @click.prevent="submit" type="submit" class="btn btn-primary">Pilih</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'nama', 'foto', 'id', 'href', 'no-urut'
    ],
    data() {
        return {
            csrf: document.head.querySelector('meta[name="csrf-token"]').content,
            colClass: null
        }
    },
    mounted() {
        this.colClass = this.$root.colClass        
    },
    methods: {
        submit() {
            let that = this

            swal({
                title: 'Apa anda yakin ?',
                buttons: {
                    confirm: {
                        text: 'Yakin',
                        closeModal: false
                    },
                    cancel: {
                        visible: true,
                        text: 'batal'
                    }
                },
                closeOnClickOutside: false
            }).then(confirm => {
                if (!confirm)
                    return
                $('.swal-button--cancel').remove()

                $.ajax({
                    url: that.href,
                    method: 'post',
                    data: 'terpilih=' + that.id,
                    success: function (response) {
                        if(response.error === false)
                            dpm.voted = true
                            
                        // menampilkan pesan
                        swal({
                            title: response.error ? 'Gagal !' : 'Berhasil !',
                            icon: response.error ? 'error' : 'success',
                            text: response.message
                        }).then((response) => {
                            if(that.isVotedAll()) {
                                swal({
                                    title: 'Terima kasih telah mengikuti pemilihan', 
                                    text: 'Anda akan keluar secara otomatis',
                                    button: false,
                                    icon: 'info',
                                    closeOnClickOutside: false
                                })
                                setTimeout(function () {
                                    $('#keluar').submit()
                                }, 1500)
                            }
                        })
                    },
                    error: function(error) {
                        console.log(error)
                    }
                })

            })
        },
        isVotedAll() {
            return (hmj.voted && bem.voted && dpm.voted)
        }
    }
}
</script>

