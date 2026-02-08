<template>
  <div>
    <h1>Películas de Estreno</h1>
    <Grilla :posts="estrenos" tipo="pelicula" columnas="5" gap="12" />
    <div class=" text-center py-4">
      <router-link :to="{ name: 'peliculaslist' }" class="btn w-40 relative"><span
          class="mdi mdi-movie-open absolute left-1"></span>Ver todos los estrenos</router-link>
    </div>
  </div>
  <div class="bg-gray-100 py-8 px-4">
    <h2 class="text-dark">Series Más Populares</h2>
    <Grilla :posts="seriesPopulares" tipo="serie" columnas="5" gap="12" />
    <div class=" text-center py-4">
      <router-link :to="{ name: 'serieslist' }" class="btn w-40 relative"><span
          class="mdi mdi-television-box absolute left-1"></span>Todas las series</router-link>
    </div>
  </div>
</template>

<script>
import Grilla from './shared/Grilla.vue'
export default {
  data() {
    return {
      estrenos: [],
      seriesPopulares: [],
      isLoading: true,
    };
  },
  components: {
    Grilla
  },
  methods: {
    listPage() {
      this.isLoading = true;
      this.$axios
        .get("/api/peliculas/index/?cantidad=15")
        .then((res) => {
          this.estrenos = res.data.data.sort((a, b) => b.popularidad - a.popularidad);
          this.isLoading = false;
        });
      this.$axios
        .get("/api/series/soloSeries?cantidad=10")
        .then((res) => {
          this.seriesPopulares = res.data.data.slice(0, 10).sort((a, b) => b.popularidad - a.popularidad);
          this.isLoading = false;
        });
    }
  },
  async mounted() {
    this.listPage();
    document.title = window.location.href
  },
};
</script>
