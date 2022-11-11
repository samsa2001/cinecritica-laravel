<template>
    <div class="my-4">  
      <div v-if="posts" class="grid lg:grid-cols-5 md:grid-cols-3 grid-cols-2 md:gap-8 gap-4">
        <div v-for="post in posts" :key="post.id">
          <router-link :to="{ name: tipo, params: { 'slug': post.slug } }" class=" bg-lime-800">
            <img v-if="tipo != 'persona' && post.imagen != null" :src="'https://image.tmdb.org/t/p/original' + post.imagen" :title="post.titulo + ', Poster'" />
            <img v-else-if="post.foto != null" :src="'https://image.tmdb.org/t/p/original' + post.foto" :title="post.nombre + ' , Foto'" />
            <img v-else src="https://cdn1.cinecritica.com/media/unknown.png" :title="post.nombre + ' , Foto'" />
            <div class=" bottom-0 w-full bg-lime-800 text-white min-h-42 flex flex-row">
              <div v-if="post.nota < 5" class="p-3 min-h-full bg-red-900 text-white">
                {{ post.nota }}
              </div>
              <div v-else-if="post.nota < 6.5" class="p-3 min-h-full bg-slant-900 text-white">
                {{ post.nota }}
              </div>
              <div v-else-if="tipo != 'persona'" class="p-3 min-h-full bg-green-900 text-white">
                {{ post.nota }}
              </div>
              <div v-if="tipo == 'persona'" class="grow text-center">
                <strong>{{ post.nombre }}</strong><br/> {{post.pivot.personaje}}
              </div>
              <div v-else class="grow text-center">
                {{ post.titulo }}
              </div>
            </div>
          </router-link>
        </div>
      </div>
      </div>
  </template>
  
  <script>
  
  export default {
    props : {
      posts: {
        type:Array,
        required:true
      },
      tipo: {
        type:String,
        required:false,
        default: 'pelicula'
      }
    }
  };
  </script>
  