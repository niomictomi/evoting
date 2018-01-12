<template>
     <div class="card col-sm">
        <img class="card-img-top" :src="foto" alt="Card image cap">
        <div class="card-body">
            <h6>Calon Anggota DPM</h6>
            <h4>{{ nama }}</h4>
            <button @click.prevent="submit" type="submit" class="btn btn-primary">Pilih</button>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'nama', 'foto'
    ],
    data() {
        return {
            csrf: document.head.querySelector('meta[name="csrf-token"]').content,
        }
    },
    methods: {
        submit() {
            
        }
    }
}
</script>

