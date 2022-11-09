<template>
    <div class="flex space-x-3">
        <div class="w-1/3">
            <img :src="'https://image.tmdb.org/t/p/original' + pelicula.imagen">
        </div>
        <div class="w-2/3">
            <h1>{{ pelicula.titulo }}</h1>
            <h2>{{ pelicula.tagline }}</h2>
            <div class="flex space-x-3 space-y-3 flex-wrap">
                <div class="bg-slate-200 px-2">Nota: {{ pelicula.nota }}</div>
                <div class="bg-slate-200 px-2">numero_votos: {{ pelicula.numero_votos }}</div>
                <div class="bg-slate-200 px-2">Año: {{ pelicula.year }}</div>
                <div class="bg-slate-200 px-2">titulo_original: {{ pelicula.titulo_original }}</div>
                <div class="bg-slate-200 px-2">presupuesto: {{ pelicula.presupuesto }}</div>
                <div class="bg-slate-200 px-2">recaudacion: {{ pelicula.recaudacion }}</div>
                <div class="bg-slate-200 px-2">fecha: {{ pelicula.fecha }}</div>
                <div class="bg-slate-200 px-2">productora: {{ pelicula.productora }}</div>
                <div class="bg-slate-200 px-2">duracion: {{ pelicula.duracion }}</div>
                <div class="bg-slate-200 px-2">pais: {{ pelicula.pais }}</div>
                <div v-for="(director, id) in pelicula.directores" :key="id" class="bg-slate-200 px-2">
                    <router-link :to="{ name: 'persona', params: { 'slug': director.slug } }">
                        Director: {{ director.nombre }}
                    </router-link>
                </div>
            </div>
            <p>{{ pelicula.descripcion }}</p>
            <div class="flex flex-wrap">
                <div v-for="(actor, id) in pelicula.actores" :key="id" class="w-40 mt-3 mr-3">
                    <img :src="'https://image.tmdb.org/t/p/original' + actor.foto">
                    <router-link :to="{ name:'persona',params:{ 'slug': actor.slug } }">{{actor.nombre}}</router-link>
                    <span class="block">{{ actor.pivot.personaje }}</span>
                </div>
            </div>
            <img :src="'https://image.tmdb.org/t/p/original' + pelicula.imagen_principal">
        </div>
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