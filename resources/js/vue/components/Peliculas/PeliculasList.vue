<template>
  <div>
    <div class="flex">
      <o-button icon-left="upload" @click="listPage"> Ordenar por fecha </o-button>
      <o-button icon-left="upload" @click="orderByPopularity"> Ordenar por num.votos </o-button>
    </div>
    <Grilla :posts="posts" :tipo="pelicula"/>
    <!-- <h1>Listado de Peliculas por fecha</h1>
    <div v-if="posts" class="grid lg:grid-cols-5 md:grid-cols-3 grid-cols-2 gap-4">
      <div v-for="post in posts.data" :key="id" class=" bg-slate-300 relative">
        <router-link :to="{ name: 'pelicula', params: { 'slug': post.slug } }">
          <img :src="'https://image.tmdb.org/t/p/original' + post.imagen" :title="post.titulo" />
          <div class="absolute bottom-1 w-full text-center bg-lime-800 text-white min-h-42">{{ post.titulo }}</div>
        </router-link>
      </div>
    </div> -->
    <br />
    <o-pagination v-if="posts.current_page && posts.data.length > 0" @change="updatePage" :total="posts.total"
      v-model:current="currentPage" :range-before="2" :range-after="2" order="centered" size="small" :simple="false"
      :rounded="true" :per-page="posts.per_page">
    </o-pagination>
  </div>
  <o-modal v-model:active="confirmDeleteActive">
    <div class="p-4">
      <p>¿Seguro que quieres eliminar el registro selecionado?</p>
    </div>

    <div class="flex flex-row-reverse gap-2 bg-gray-100 p-3">
      <o-button variant="danger" @click="deletePost()">Eliminar</o-button>
      <o-button @click="confirmDeleteActive = false">Cancelar</o-button>
    </div>
  </o-modal>
</template>

<script>
import Grilla from '../grilla.vue'
export default {
  data() {
    return {
      posts: [],
      byDate: true,
      isLoading: true,
      currentPage: 1,
      confirmDeleteActive: false,
      deletePostRow: "",
    };
  },
  components: {
    Grilla
  },
  methods: {
    updatePage() {
      if (this.byDate)
        setTimeout(() => { this.listPage() }, 100)
      else
        setTimeout(() => { this.orderByPopularity() }, 100)
    },
    listPage() {
      // const config = {
      //   headers: { Authorization: `Bearer ${this.$cookies.get('auth').token}` }
      // };
      this.isLoading = true;
      console.log("/api/peliculas/?page=" + this.currentPage);
      this.$axios
        // .get("/api/peliculas?page=" + this.currentPage, config)
        .get("/api/peliculas?page=" + this.currentPage)
        .then((res) => {
          this.posts = res.data;
          this.isLoading = false;
          this.byDate = true
        });
      if (this.currentPage > 1)
        this.$route.query.page = this.currentPage
    },
    orderByPopularity() {
      this.isLoading = true;
      console.log("/api/peliculas/votos?page=" + this.currentPage);
      this.$axios
        // .get("/api/peliculas?page=" + this.currentPage, config)
        .get("/api/peliculas/votos?page=" + this.currentPage)
        .then((res) => {
          this.posts = res.data;
          this.isLoading = false;
          this.byDate = false
        });
      if (this.currentPage > 1)
        this.$route.query.page = this.currentPage
    },
    deletePost() {
      this.confirmDeleteActive = false;
      this.posts.data.splice(this.deletePostRow.index, 1);
      this.$axios.delete("/api/post/" + this.deletePostRow.row.id, config);
      this.$oruga.notification.open({
        message: "Registro eliminado",
        position: "bottom-right",
        variant: "danger",
        duration: 4000,
        closable: true,
      });
    },
  },
  async mounted() {
    this.currentPage = (this.$route.query.page) ? this.$route.query.page : 1;
    this.listPage()
  },
};
</script>
