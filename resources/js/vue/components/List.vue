<template>
    <div>  
      <h1>Lo más popular ahora</h1>
        <Carrousel :posts="posts"></Carrousel>
    </div>
  </template>

<script>
import Carrousel from './Carrousel.vue'
export default  {
  data() {
    return {
      posts: [],
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
        // .get("/api/peliculas?page=" + this.currentPage, config)
        .get("/api/buscar/popular")
        .then((res) => { 
          this.posts = res.data;      
          this.isLoading = false;
        });
    }
  },
  async mounted() {
    this.listPage();
  },
};
</script>
