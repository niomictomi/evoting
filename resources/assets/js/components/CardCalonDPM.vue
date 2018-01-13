<template>
     <div class="card col-sm card-calon">
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
        'nama', 'foto', 'id', 'href'
    ],
    data() {
        return {
            csrf: document.head.querySelector('meta[name="csrf-token"]').content,
        }
    },
    methods: {
        submit() {
            let that = this
            $.ajax({
                url: that.href,
                method: 'post',
                data: 'terpilih=' + that.id,
                success: function (response) {
                    dpm.voted = true
                    // menampilkan pesan
                    swal({
                        title: response.error ? 'Gagal !' : 'Berhasil !',
                        icon: response.error ? 'error' : 'success',
                        text: response.message
                    }).then((response) => {
                        if(that.isVotedAll()) {
                            swal('Peringatan', 'Anda akan keluar secara otomatis')
                            setTimeout(function () {
                                $('#keluar').submit()
                            }, 1000)
                        }
                    })
                },
                error: function(error) {
                    console.log(error)
                }
            })
        },
        isVotedAll() {
            return (hmj.voted && bem.voted && dpm.voted)
        }
    }
}
</script>

