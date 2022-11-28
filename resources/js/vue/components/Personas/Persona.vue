<template>
    <h1>{{ persona.nombre }}</h1>
    <div class="lg:flex block space-x-3">
        <div class="lg:w-1/3 w-full mb-4">
            <img :src="'https://image.tmdb.org/t/p/original' + persona.foto">
            <h2>{{ persona.year_1 }}<span v-if="persona.year_2 > 0"> - {{persona.year_2}}</span> </h2>
            <p>{{ persona.descripcion }}</p>
        </div>
        <div class="lg:w-2/3 w-full">
            <div class="ordenacion">
                <o-radio v-model="orden" name="name" native-value="fecha" @update:modelValue="orderYear()">
                Ordenar por fecha estreno
                </o-radio>
                <o-radio v-model="orden" name="name" native-value="numVotos" @update:modelValue="orderVotes()">
                Ordenar por número votos
                </o-radio>
            </div>
            <div id="tab" class="tabs">
                <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
                    <li v-if="es_actor" class="mr-2">
                        <a @click="f_es_actor()" href="#tab" class="tab-titulo" :class="{'active':tab_actor }">En cine</a>
                    </li>
                    <li v-if="en_series" class="mr-2">
                        <a @click="f_en_series()" href="#tab" class="tab-titulo" :class="{'active':tab_series }">En series</a>
                    </li>
                    <li v-if="es_director" class="mr-2">
                        <a @click="f_es_director()" href="#tab" class="tab-titulo" :class="{'active':tab_director }">Director</a>
                    </li>
                    <li v-if="es_guionista" class="mr-2">
                        <a @click="f_es_guionista()" href="#tab" class="tab-titulo" :class="{'active':tab_guionista }">Guionista/Creeador</a>
                    </li>
                </ul>
                <div class="tabs-contenido">
                    <div v-if="es_director && tab_director">
                        <Grilla :posts="persona.es_director" tipo="pelicula" columnas="5" gap="8"></Grilla>
                    </div>
                    <div v-if="es_actor && tab_actor">
                        <Grilla :posts="persona.peliculas" tipo="pelicula" columnas="5" gap="8"></Grilla>
                    </div>
                    <div v-if="es_guionista && tab_guionista">
                        <Grilla :posts="persona.es_guionista" tipo="pelicula" columnas="5" gap="8"></Grilla>
                    </div>
                    <div v-if="en_series && tab_series">
                        <Grilla :posts="persona.series" tipo="serie" columnas="5" gap="8"></Grilla>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import Grilla from '../shared/Grilla.vue'

export default {
    data() {
        return {
            persona: [],
            es_director: false,
            es_guionista: false,
            es_actor:true,
            en_series:false,
            tab_actor: true,
            tab_director:false,
            tab_guionista:false,
            tab_series:false
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
                    console.log(res.data);
                    this.persona = res.data;
                    this.es_director = (this.persona.es_director != '') ? true : false
                    this.es_actor = (this.persona.peliculas != '') ? true : false
                    this.es_guionista = (this.persona.es_guionista != '') ? true : false
                    this.en_series = (this.persona.series != '') ? true : false
                    if(!this.es_actor && this.en_series) {
                        this.tab_actor = false
                        this.tab_series = true
                    } else if (!this.es_actor && this.es_director){
                        this.tab_actor = false
                        this.tab_director = true
                    }

                });
        },
        f_es_actor(){
            this.tab_actor=true
            this.tab_director = this.tab_guionista = this.tab_series = false
        },
        f_en_series(){
            this.tab_series=true
            this.tab_director = this.tab_guionista = this.tab_actor = false
        },
        f_es_director(){
            this.tab_director=true
            this.tab_actor = this.tab_guionista = this.tab_series = false
        },
        f_es_guionista(){
            this.tab_guionista=true
            this.tab_actor = this.tab_director = this.tab_series = false
        },
        orderVotes() {
        this.persona.peliculas.sort(function(a, b){ console.log(a.year,b.year); return b.numero_votos-a.numero_votos});
        this.persona.series.sort(function(a, b){ console.log(a.year,b.year); return b.numero_votos-a.numero_votos});
        this.persona.es_director.sort(function(a, b){ console.log(a.year,b.year); return b.numero_votos-a.numero_votos});
        this.persona.es_guionista.sort(function(a, b){ console.log(a.year,b.year); return b.numero_votos-a.numero_votos});
        },
        orderYear() {      
        this.persona.peliculas.sort(function(a, b){ console.log(a.year,b.year); return b.year-a.year});
        this.persona.series.sort(function(a, b){ console.log(a.year,b.year); return b.year-a.year});
        this.persona.es_director.sort(function(a, b){ console.log(a.year,b.year); return b.year-a.year});
        this.persona.es_guionista.sort(function(a, b){ console.log(a.year,b.year); return b.year-a.year});
        }
    },
    async mounted() {
        this.listPage();
    },
}
</script>

<style>

</style>