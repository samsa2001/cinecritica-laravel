<template>
  <div>
    <div class="flex justify-between">
      <h1>Blog</h1>
      <div class="block">
        <o-radio v-model="tipo" name="name" native-value="curiosidades" @update:modelValue="listPage()">
          Ver curiosidades
        </o-radio>
        <o-radio v-model="tipo" name="name" native-value="estrenos" @update:modelValue="listPage()">
          Ver últimos estrenoso
        </o-radio>
        <o-radio v-model="tipo" name="name" native-value="taquilla" @update:modelValue="listPage()">
          Ver datos de taquilla
        </o-radio>
      </div>
    </div>
    <div v-if="posts">
      <div v-for="post in posts.data" :key="post.id" class="border p-2 mb-4">
        <h2 class="post-titulo">
          <router-link :to="{ name: 'post', params: { 'slug': post.slug } }">{{ post.titulo }}</router-link>
        </h2>
        <div class="post-fecha">{{ post.fecha }}</div>
        <div class="post-excerpt">
          {{crearExcerpt(post.contenido)}}
        </div>
        <router-link :to="{ name: 'post', params: { 'slug': post.slug } }" class="btn">Ver post</router-link>
      </div>
    </div>
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

export default {
  data() {
    return {
      posts: [],
      tipo: 'curiosidades',
      isLoading: true,
      currentPage: 1,
      confirmDeleteActive: false,
      deletePostRow: "",
    };
  },
  methods: {
    updatePage() {
      window.scrollTo(0, 0);
      setTimeout(() => { this.listPage() }, 100)
    },
    listPage() {
      this.isLoading = true;
      const apiQuery = (this.tipo == 'estrenos') 
        ? "/api/posts/estrenos?page=" + this.currentPage 
        : (this.tipo == 'taquilla') 
          ? "/api/posts/taquilla?page=" + this.currentPage
          : "/api/posts/curiosidades?page=" + this.currentPage
      this.$axios
        .get(apiQuery)
        .then((res) => {
          this.posts = res.data;
          this.isLoading = false;
        });
    },
    crearExcerpt(content){
      return content.length > 150 ? content.slice(0, 150).replace(/<\/?[^>]+>/ig, " ") + '...' : content;
    }
  },
  async mounted() {
    if (this.$route.query.tipo == 'estrenos' || this.$route.query.tipo == 'taquilla' || this.$route.query.tipo == 'curiosidades'){
      this.tipo = this.$route.query.tipo
    }
    
    this.listPage()
  },
};
</script>
