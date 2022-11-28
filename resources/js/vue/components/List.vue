<template>
    <div>  
      <h1>Lo más popular ahora</h1>
        <Carrousel :peliculas="peliculas" :series="series" :personas="personas"></Carrousel>
    </div>
  </template>

<script>
import Carrousel from './shared/Carrousel.vue'
export default  {
  data() {
    return {
      peliculas:[],
      series:[],
      personas:[],
      isLoading: true,
    };
  },
  components:{
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
        });
    },

  },
  async mounted() {
    this.listPage();
  },
};
</script>
