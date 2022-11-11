<template>
    <div class="flex space-x-3">
        <div class="w-1/3 mb-4">
            <img :src="'https://image.tmdb.org/t/p/original' + persona.foto">
        </div>
        <div class="w-2/3">
            <h1>{{ persona.nombre }}</h1>
            <h2>{{ persona.year_1 }}</h2>
            <p>{{ persona.descripcion }}</p>
            <div v-if="persona.es_director != ''">
                <h2>Como director</h2>
                <Grilla :posts="persona.es_director" tipo="pelicula"></Grilla>
            </div>
            <div v-if="persona.peliculas != ''">
                <h2>Como actor</h2>
                <Grilla :posts="persona.peliculas" tipo="pelicula"></Grilla>
            </div>
            <div v-if="persona.es_guionista != ''">
                <h2>Como guionista/ Creador historia</h2>
                <Grilla :posts="persona.es_guionista" tipo="pelicula"></Grilla>
            </div>
            <hr />
            <h2 v-if="persona.series != ''">Series</h2>
            <Grilla :posts="persona.series" tipo="serie"></Grilla>
        </div>
    </div>
</template>

<script>

import Grilla from '../Grilla.vue'

export default {
    data() {
        return {
            persona: []
        }
    },
    components:{
        Grilla
    },
    methods: {
        updatePage() {
            setTimeout(this.listPage, 100);
        },
        listPage() {
            this.isLoading = true;
            this.$axios
                .get("/api/persona/" + this.$route.params.slug)
                .then((res) => {
                    this.persona = res.data;
                });
        },
    },
    async mounted() {
        this.listPage();
    },
}
</script>

<style>

</style>