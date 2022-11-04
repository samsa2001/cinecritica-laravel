<template>
    <h1>Busqueda por {{$route.query.q}}</h1>
    <div v-for="(objeto, id) in coleccion" :key="id">
        <div v-if="objeto.hasOwnProperty('nombre')" class="flex space-x-3 py-2">
            <img :src="'https://image.tmdb.org/t/p/original' + objeto.foto" width="75">
            <router-link :to="{ name:'persona',params:{ 'slug': objeto.slug } }">{{objeto.nombre}}</router-link>
        </div>
        <div v-else  class="flex space-x-3 py-2">
            <img :src="'https://image.tmdb.org/t/p/original' + objeto.imagen" width="75">
            <div v-if="objeto.hasOwnProperty('numero_episodios')">
                <router-link :to="{ name:'serie',params:{ 'slug': objeto.slug } }">{{ objeto.titulo }} (serie)</router-link>
            </div>
            <div v-else>
                <router-link :to="{ name:'pelicula',params:{ 'slug': objeto.slug } }">{{ objeto.titulo }}</router-link>
            </div>
        </div>
        
        <hr/>
    </div>
</template>

<script>
export default {
    data() {
        return {
            coleccion: [],
            textoBuscar : ''
        }
    },
    methods: {
        updatePage() {
            setTimeout(this.listPage, 100);
        },
        listPage() {
            this.isLoading = true;
            this.$axios
                .get("/api/buscar/" + this.textoBuscar)
                .then((res) => {
                    this.coleccion = res.data;
                });
        }
    },
    async mounted() {
        this.textoBuscar = this.$route.query.q
        this.listPage();
        
    },
    async updated() {
        this.textoBuscar = this.$route.query.q
        this.listPage();
        
    },
}
</script>

<style>

</style>