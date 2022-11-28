<template>
  <div>
    <div class="flex">
      <h1>Listado de series</h1>
      <div class="ordenacion">
        <o-radio v-model="orden" name="name" native-value="fecha" @update:modelValue="listPage()">
          Ordenar por fecha estreno
        </o-radio>
        <o-radio v-model="orden" name="name" native-value="numVotos" @update:modelValue="listPage()">
          Ordenar por número votos
        </o-radio>
      </div>
    </div>
    <Grilla :posts="posts.data" tipo="serie" columnas="5" gap="8"></Grilla>
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
      isLoading: true,
      orden: 'fecha',
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
      setTimeout(() => { this.listPage() }, 100)
    },
    listPage() {
      // const config = {
      //   headers: { Authorization: `Bearer ${this.$cookies.get('auth').token}` }
      // };
      this.isLoading = true;
      const apiQuery = (this.orden == 'fecha') 
        ? "/api/series?page=" + this.currentPage 
        : "/api/series/votos?page=" + this.currentPage
      this.$axios
        // .get("/api/series?page=" + this.currentPage, config)
        .get(apiQuery)
        .then((res) => {
          this.posts = res.data;
          this.isLoading = false;
          this.byDate = true
        });
    }
  },
  async mounted() {
    this.listPage();
  },
};
</script>
