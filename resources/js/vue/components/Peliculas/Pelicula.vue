<template>
    <div class="">
        <h1>{{ pelicula.titulo }}</h1>
        <h2>{{ pelicula.tagline }}</h2>
        <div class="float-left max-w-sm mr-4 mb-4">
            <img :src="'https://image.tmdb.org/t/p/original' + pelicula.imagen">
        </div>
        <div class="bg-green-50 p-4 mb-4 inline-block border border-green-900 text-lg">   
            <span class="inline">Director: </span>
            <div v-for="(director, id) in pelicula.directores" :key="id"  class="inline mr-4">
                <router-link :to="{ name: 'persona', params: { 'slug': director.slug } }">
                    {{ director.nombre }}
                </router-link>
            </div>
            <div class="">Nota: {{ pelicula.nota }}</div>
            <div class="">Número de votos: {{ pelicula.numero_votos }}</div>
            <div class="">Año: {{ pelicula.year }}</div>
            <div class="">Fecha estreno mundial: {{ pelicula.fecha }}</div>
            <div class="">Titulo Original: {{ pelicula.titulo_original }}</div>
            <div class="">Presupuesto: {{ new Intl.NumberFormat().format(pelicula.presupuesto) }}</div>
            <div class="">Recaudacion: {{ new Intl.NumberFormat().format(pelicula.recaudacion) }}</div>
            <div class="">Productora: {{ pelicula.productora }}</div>
            <div class="">Duracion: {{ pelicula.duracion }}</div>
            <div class="">Pais: {{ pelicula.pais }}</div>     
            <div v-if="pelicula.generos != ''">
                <span class="inline">Generos: </span>
                <span v-for="(genero, id) in pelicula.generos" :key="id" class="inline mr-4">
                        {{ genero.titulo }}
                </span>
            </div>  
            <div v-if="pelicula.guionistas != ''">
                <span class="inline">Guión: </span>
                <span v-for="(guionista, id) in pelicula.guionistas" :key="id" class="inline mr-4">
                    <router-link :to="{ name: 'persona', params: { 'slug': guionista.slug } }">
                        {{ guionista.nombre }}
                    </router-link>
                </span>
            </div>
            <div v-if="pelicula.escritores != ''">
                <span class="inline">Historia:</span>
                <span v-for="(escritor, id) in pelicula.escritores" :key="id" class="inline mr-4">
                    <router-link :to="{ name: 'persona', params: { 'slug': escritor.slug } }">
                        {{ escritor.nombre }}
                    </router-link>
                </span>
            </div>
        </div>
        <p>{{ pelicula.descripcion }}</p>
        <Grilla :posts="pelicula.actores" tipo="persona" />
        <img :src="'https://image.tmdb.org/t/p/original' + pelicula.imagen_principal">
    </div>
</template>

<script>
import Grilla from '../Grilla.vue'
export default {
    data() {
        return {
            pelicula: []
        }
    },
    components: {
        Grilla
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
            
        },
        formatFecha( strFecha){
            const trozoFecha = strFecha.split('/')
            trozoFecha.forEach(element => {
                console.log(element);
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