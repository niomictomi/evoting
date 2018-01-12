<template>
    <div class="card col-sm">
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
            <button @click.prevent="submit" type="submit" class="btn btn-primary">Pilih</button>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'foto', 'nama-ketua', 'nama-wakil', 'id', 'href', 'jenis'
    ],
    data() {
        return {
            csrf: document.head.querySelector('meta[name="csrf-token"]').content,
        }
    },
    methods: {
        submit() {
            if(this.jenis === 'hmj') {
                voteHmj.$refs.form.submit(this.id)
            }
            else if(this.jenis === 'bem') {
                voteBem.$refs.form.submit(this.id)
            }
        }
    }
}
</script>
