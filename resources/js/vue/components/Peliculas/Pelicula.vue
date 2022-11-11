<template>
    <div class="">
            <h1>{{ pelicula.titulo }}</h1>
            <h2>{{ pelicula.tagline }}</h2>
            <div class="float-left max-w-sm mr-4 mb-4">
                <img :src="'https://image.tmdb.org/t/p/original' + pelicula.imagen">
            </div>
            <div class="">
                <div class="bg-green-200 rounded border-green-900 border px-2 mb-3">Nota: {{ pelicula.nota }}</div>
                <div class="bg-green-200 rounded border-green-900 border px-2">numero_votos: {{ pelicula.numero_votos }}</div>
                <div class="bg-green-200 rounded border-green-900 border px-2">Año: {{ pelicula.year }}</div>
                <div class="bg-green-200 rounded border-green-900 border px-2">titulo_original: {{ pelicula.titulo_original }}</div>
                <div class="bg-green-200 rounded border-green-900 border px-2">presupuesto: {{ pelicula.presupuesto }}</div>
                <div class="bg-green-200 rounded border-green-900 border px-2">recaudacion: {{ pelicula.recaudacion }}</div>
                <div class="bg-green-200 rounded border-green-900 border px-2">fecha: {{ pelicula.fecha }}</div>
                <div class="bg-green-200 rounded border-green-900 border px-2">productora: {{ pelicula.productora }}</div>
                <div class="bg-green-200 rounded border-green-900 border px-2">duracion: {{ pelicula.duracion }}</div>
                <div class="bg-green-200 rounded border-green-900 border px-2">pais: {{ pelicula.pais }}</div>
                <div v-for="(director, id) in pelicula.directores" :key="id" class="bg-green-200 rounded border-green-900 border px-2">
                    <router-link :to="{ name: 'persona', params: { 'slug': director.slug } }">
                        Director: {{ director.nombre }}
                    </router-link>
                </div>
            </div>
            <p>{{ pelicula.descripcion }}</p>
            <div class="grid lg:grid-cols-5 md:grid-cols-4 grid-cols-3 lg:gap-4 gap-2">
                <div v-for="(actor, id) in pelicula.actores" :key="id" class="">
                    <img :src="'https://image.tmdb.org/t/p/original' + actor.foto">
                    <router-link :to="{ name:'persona',params:{ 'slug': actor.slug } }">{{actor.nombre}}</router-link>
                    <span class="block">{{ actor.pivot.personaje }}</span>
                </div>
            </div>
            <img :src="'https://image.tmdb.org/t/p/original' + pelicula.imagen_principal">
    </div>
</template>

<script>
export default {
    data() {
        return {
            pelicula: []
        }
    },
    methods: {
        updatePage() {
            setTimeout(this.listPage, 100);
        },
        listPage() {
            this.isLoading = true;
            this.$axios
                .get("/api/pelicula/" + this.$route.params.slug)
                .then((res) => {
                    this.pelicula = res.data;
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