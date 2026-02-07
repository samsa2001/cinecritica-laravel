<template>
  <div>
    <div class="flex justify-between">
      <h1>Cine Español</h1>
      <div class="block">
        <o-radio v-model="orden" name="name" native-value="fecha" @update:modelValue="listPage()">
          Ordenar por fecha estreno
        </o-radio>
        <o-radio v-model="orden" name="name" native-value="numVotos" @update:modelValue="listPage()">
          Ordenar por número votos
        </o-radio>
      </div>
    </div>
    <Grilla :posts="posts.data" tipo="pelicula" columnas="5" gap="12"/>
    <br />
    <o-pagination v-if="posts.current_page && posts.data.length > 0" @change="updatePage" :total="posts.total"
      v-model:current="currentPage" :range-before="2" :range-after="3" order="centered" size="medium" :simple="false"
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
import Grilla from '../shared/Grilla.vue'
export default {
  data() {
    return {
      posts: [],
      orden: 'fecha',
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
      window.scrollTo(0, 0);
      setTimeout(() => { this.listPage() }, 100)
    },
    listPage() {
      this.isLoading = true;
      const apiQuery = (this.orden == 'fecha') 
        ? "/api/peliculas/soloEspana?page=" + this.currentPage 
        : "/api/peliculas/votos?page=" + this.currentPage
      this.$axios
        // .get("/api/peliculas?page=" + this.currentPage, config)
        .get(apiQuery)
        .then((res) => {
          this.posts = res.data;
          this.isLoading = false;
          this.byDate = true
        });
      if (this.currentPage > 1)
        this.$route.query.page = this.currentPage
    }
  },
  async mounted() {
    this.currentPage = (this.$route.query.page) ? this.$route.query.page : 1;
    this.listPage()
  },
};
</script>
