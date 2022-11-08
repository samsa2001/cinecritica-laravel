<template>
    <div class="flex space-x-3">
        <div class="w-1/3">
            <img :src="'https://image.tmdb.org/t/p/original' + persona.foto">
        </div>
        <div class="w-2/3">
            <h1>{{ persona.nombre }}</h1>
            <h2>{{ persona.year_1 }}</h2>
            <p>{{ persona.descripcion }}</p>
            <div v-if="persona.es_director != ''">
                <h2>Como director</h2>
                <div class="flex flex-wrap">
                    <div v-for="(directorDe, id) in persona.es_director" :key="id" class="w-28 mt-3 mr-3">
                        <router-link :to="{ name: 'pelicula', params: { 'slug': directorDe.slug } }">
                            <img :src="'https://image.tmdb.org/t/p/original' + directorDe.imagen" />
                            {{ directorDe.titulo }}
                        </router-link>
                    </div>
                </div>
            </div>
            <div v-if="persona.peliculas != ''">
                <h2>Como actor</h2>
                <div class="flex flex-wrap">
                    <div v-for="(pelicula, id) in persona.peliculas" :key="id" class="w-28 mt-3 mr-3">
                        <router-link :to="{ name: 'pelicula', params: { 'slug': pelicula.slug } }">
                            <img :src="'https://image.tmdb.org/t/p/original' + pelicula.imagen" />
                            {{ pelicula.titulo }}
                        </router-link>
                    </div>
                </div>
            </div>
            <div v-if="persona.es_guionista != ''">
                <h2>Como guionista/ Creador historia</h2>
                <div class="flex flex-wrap">
                    <div v-for="(guionistaDe, id) in persona.es_guionista" :key="id" class="w-28 mt-3 mr-3">
                        <router-link :to="{ name: 'pelicula', params: { 'slug': guionistaDe.slug } }">
                            <img :src="'https://image.tmdb.org/t/p/original' + guionistaDe.imagen" />
                            {{ guionistaDe.titulo }} - {{ guionistaDe.pivot.role}}
                        </router-link>
                    </div>
                </div>
            </div>
            <hr />
            <h2 v-if="persona.series != ''">Series</h2>
            <div class="flex flex-wrap">
                <div v-for="(serie, id) in persona.series" :key="id" class="w-28 mt-3 mr-3">
                    <img :src="'https://image.tmdb.org/t/p/original' + serie.imagen" />
                    <router-link :to="{ name: 'serie', params: { 'slug': serie.slug } }">{{ serie.titulo }}
                    </router-link>
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
        },
    },
    async mounted() {
        this.listPage();
    },
}
</script>

<style>

</style>