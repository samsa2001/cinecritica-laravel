<template>
    <div class="flex space-x-3">
        <div class="w-1/3">
            <img :src="'https://image.tmdb.org/t/p/original' + persona.foto">
        </div>
        <div class="w-2/3">
            <h1>{{ persona.nombre }}</h1>
            <h2>{{ persona.year_1 }}</h2>
            <p>{{ persona.descripcion }}</p>
            <div class="flex flex-wrap">                
                <div v-for="(pelicula , id) in persona.peliculas" :key="id" class="w-28 mt-3 mr-3">
                    <img :src="'https://image.tmdb.org/t/p/original' + pelicula.imagen"/>
                    <router-link :to="{ name:'pelicula',params:{ 'slug': pelicula.slug } }">{{pelicula.titulo}}</router-link>
                </div>  
                <hr/>             
                <div v-for="(serie , id) in persona.series" :key="id" class="w-28 mt-3 mr-3">
                    <img :src="'https://image.tmdb.org/t/p/original' + serie.imagen"/>
                    <router-link :to="{ name:'serie',params:{ 'slug': serie.slug } }">{{serie.titulo}}</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            persona: []
        }
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
        }
    },
    async mounted() {
        this.listPage();
    },
}
</script>

<style>

</style>