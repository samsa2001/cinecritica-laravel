<template>
  <div>
    <h1>Películas de Estreno</h1>
    <Grilla :posts="estrenos" tipo="pelicula" columnas="5" gap="12" />
    <div class=" text-center py-4">
      <router-link :to="{ name: 'peliculaslist' }" class="btn w-40 relative"><span
          class="mdi mdi-movie-open absolute left-1"></span>Ver todos los estrenos</router-link>
    </div>

  </div>
  <div>
    <h2>Lo más popular ahora</h2>
    <Carrousel :peliculas="peliculas" :series="series" :personas="personas"></Carrousel>
  </div>
</template>

<script>
import Carrousel from './shared/Carrousel.vue'
import Grilla from './shared/Grilla.vue'
export default {
  data() {
    return {
      peliculas: [],
      series: [],
      personas: [],
      estrenos: [],
      isLoading: true,
    };
  },
  components: {
    Grilla,
    Carrousel
  },
  methods: {
    updatePage() {
      setTimeout(this.listPage, 100);
    },
    listPage() {
      this.isLoading = true;
      this.$axios
        .get("/api/peliculas/soloPeliculas")
        .then((res) => {
          this.peliculas = res.data.data;
          this.isLoading = false;
        });
      this.$axios
        .get("/api/series/soloSeries")
        .then((res) => {
          this.series = res.data.data;
          this.isLoading = false;
        });
      this.$axios
        .get("/api/personas/soloPersonas")
        .then((res) => {
          this.personas = res.data.data;
          this.isLoading = false;
        });/*
      this.$axios
        .get("/api/peliculas/index")
        .then((res) => {
          this.estrenos = res.data.data;
          this.isLoading = false;
        });*/
      this.$axios
        .get("/api/peliculas/index/?cantidad=10")
        .then((res) => {
          this.estrenos = res.data.data;
          this.isLoading = false;
          console.log(this.estrenos);
        });
    },

  },
  async mounted() {
    this.listPage();
    // set title to current URL for home/list
    document.title = window.location.href
  },
};
</script>
