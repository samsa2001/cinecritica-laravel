<template>
    <div class="flex space-x-3">
        <div class="w-1/3">
            <img :src="'https://image.tmdb.org/t/p/original' + serie.imagen">
        </div>
        <div class="w-2/3">
            <h1>{{ serie.titulo }}</h1>
            <h2>{{ serie.tagline }}</h2>
            <p>{{ serie.descripcion }}</p>
            <Grilla :posts="serie.actores" tipo="persona" columnas="6" gap="8"/>
            <img :src="'https://image.tmdb.org/t/p/original' + serie.imagen_principal">
        </div>
    </div>
</template>

<script>

import Grilla from '../Grilla.vue'

export default {
    data() {
        return {
            serie: []
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
                .get("/api/serie/" + this.$route.params.slug)
                .then((res) => {
                    this.serie = res.data;
                });
        }
    },
    async mounted() {
        this.listPage();
    },
}
</script>

<style>

</style>