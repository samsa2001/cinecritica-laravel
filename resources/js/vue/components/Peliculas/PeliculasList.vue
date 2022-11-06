<template>
  <div>
    <div class="flex">
      <o-button icon-left="upload" @click="listPage"> Ordenar por fecha </o-button>
      <o-button icon-left="upload" @click="orderByPopularity"> Ordenar por num.votos </o-button>
    </div>

    <h1>Listado de Peliculas por fecha</h1>
    <o-button iconLeft="plus" @click="$router.push({ name: 'save' })">Crear</o-button>

    <o-table :loading="isLoading" :data="posts.current_page && posts.data.length == 0 ? [] : posts.data">
      <o-table-column field="title" label="Título" v-slot="p">
        <router-link :to="{ name: 'pelicula', params: { 'slug': p.row.slug } }">{{ p.row.titulo }}</router-link> <span
          class="nota">{{ p.row.nota }}</span>
      </o-table-column>
      <o-table-column field="imagen" label="Cartel" v-slot="p">
        <img :src="'https://image.tmdb.org/t/p/original' + p.row.imagen" width="100" :title="p.row.titulo">
      </o-table-column>
      <o-table-column field="created_at" label="Fecha" v-slot="p">
        {{ p.row.fecha }}
      </o-table-column>
      <!-- <o-table-column field="actores" label="Actores" v-slot="p">
        <div v-for="t in p.row.actores" :key="t.id" class="inline mr-2">
          {{ t.nombre }}
        </div>
      </o-table-column> -->
    </o-table>
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
  methods: {
    updatePage() {
      if (this.byDate)
        setTimeout(this.listPage(), 100)
      else
        setTimeout(this.orderByPopularity(), 100)
    },
    listPage() {
      // const config = {
      //   headers: { Authorization: `Bearer ${this.$cookies.get('auth').token}` }
      // };
      this.isLoading = true;
      this.$axios
        // .get("/api/peliculas?page=" + this.currentPage, config)
        .get("/api/peliculas?page=" + this.currentPage)
        .then((res) => {
          this.posts = res.data;
          this.isLoading = false;
          this.byDate = true
        });
    },
    orderByPopularity() {
      this.isLoading = true;
      this.$axios
        // .get("/api/peliculas?page=" + this.currentPage, config)
        .get("/api/peliculas/votos?page=" + this.currentPage)
        .then((res) => {
          this.posts = res.data;
          this.isLoading = false;
          this.byDate = false
        });
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
    this.listPage()
  },
};
</script>
