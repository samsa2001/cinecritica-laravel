<template>
    <div class="flex space-x-3">
        <div class="w-1/3">
            <img :src="'https://image.tmdb.org/t/p/original' + serie.imagen">
        </div>
        <div class="w-2/3">
            <h1>{{ serie.titulo }}</h1>
            <h2>{{ serie.tagline }}</h2>
            <p>{{ serie.descripcion }}</p>
            <div class="flex flex-wrap">
                <div v-for="(actor, id) in serie.actores" :key="id" class="w-40 mt-3 mr-3">
                    <img :src="'https://image.tmdb.org/t/p/original' + actor.foto">
                    <router-link :to="{ name:'persona',params:{ 'slug': actor.slug } }">{{actor.nombre}}</router-link>
                    <span class="block">{{ actor.pivot.personaje }}</span>
                </div>
            </div>
            <img :src="'https://image.tmdb.org/t/p/original' + serie.imagen_principal">
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            serie: []
        }
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