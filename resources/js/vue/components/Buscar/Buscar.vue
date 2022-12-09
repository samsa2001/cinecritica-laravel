<template>
    <div v-for="(objeto, id) in coleccion" :key="id">
        <div v-if="objeto.hasOwnProperty('nombre')" class="flex space-x-3 py-2">
            <router-link :to="{ name: 'persona', params: { 'slug': objeto.slug } }">
                <img v-if="objeto.foto != null" :src="'https://cdn1.cinecritica.com/media/personas' + objeto.foto" width="75">
                <img v-else src="https://cdn1.cinecritica.com/media/unknown.png" width="75">
                {{ objeto.nombre }}
            </router-link>
        </div>
        <div v-else class="flex space-x-3 py-2">
            <div v-if="objeto.hasOwnProperty('numero_episodios')">
                <router-link :to="{ name: 'serie', params: { 'slug': objeto.slug } }">
                    <img :src="'https://cdn1.cinecritica.com/media/series' + objeto.imagen" width="75">
                    {{ objeto.titulo }} (serie)
                </router-link>
            </div>
            <div v-else>
                <router-link :to="{ name: 'pelicula', params: { 'slug': objeto.slug } }">
                    <img :src="'https://cdn1.cinecritica.com/media/peliculas' + objeto.imagen" width="75">
                    {{ objeto.titulo }}
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
        }
    },
    props: {
        coleccion: {
            type: Object,
            required: true,
            default: null
        },
        textoBuscar: {
            type: String,
            required: true,
            default: ''
        }
    },
    async mounted() {
        // if(this.$route.query.q && this.coleccion==null){            
        //     this.textoBuscar = this.$route.query.q
        //     this.listPage();
        // }
    },
    // async updated() {
    //     this.textoBuscar = this.$route.query.q
    //     this.listPage();

    // },
}
</script>

<style>

</style>