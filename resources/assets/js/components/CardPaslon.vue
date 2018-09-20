<template>
    <div :class="colClass">
        <div class="nomor-urut">{{ noUrut }}</div>
        <img class="card-img-top" :src="foto" alt="Card image cap">
        <div class="card-body">
            <div class="row">
                <div class="col-sm">
                    <h6>Calon Ketua</h6>
                    <h4>{{ namaKetua }}</h4>
                </div>
                <div class="col-sm">
                    <h6>Calon Wakil Ketua</h6>
                    <h4>{{ namaWakil }}</h4>
                </div>
            </div>
            <div class="row justify-content-sm-center">
                <div class="col-sm-auto">
                    <button @click.prevent="submit" type="submit" class="btn btn-primary">Pilih</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'foto', 'nama-ketua', 'nama-wakil', 'id', 'href', 'jenis', 'no-urut'
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
                        if(response.error === false) {
                            if(that.jenis == 'bem')
                                bem.voted = true;
                            else if(that.jenis == 'hmj')
                                hmj.voted = true
                        }
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
