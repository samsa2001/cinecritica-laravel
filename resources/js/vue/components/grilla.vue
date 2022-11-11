<template>
    <div>  
      <h1>Listado de <span v-if="tipo='pelicula'">películas</span><span v-else>series</span></h1>
      <div v-if="posts" class="grid lg:grid-cols-5 md:grid-cols-3 grid-cols-2 gap-4">
        <div v-for="post in posts.data" :key="id" class=" bg-slate-300 relative">
          <router-link :to="{ name: 'pelicula', params: { 'slug': post.slug } }">
            <img :src="'https://image.tmdb.org/t/p/original' + post.imagen" :title="post.titulo" />
            <div class="absolute bottom-1 w-full text-center bg-lime-800 text-white min-h-42">{{ post.titulo }}</div>
          </router-link>
        </div>
      </div>
      </div>
  </template>
  
  <script>
  
  export default {
    props : {
      posts: [],
      tipo: 'pelicula'
    }
  };
  </script>
  