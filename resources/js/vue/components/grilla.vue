<template> 
  <!-- se deben precargar las clases que puede que se utilicen en la funcion crearClases  -->
  <div class="grid lg:grid-cols-6 lg:grid-cols-5 lg:grid-cols-4 lg:grid-cols-3 grid-cols-5 grid-cols-4 grid-cols-3 lg:gap-8 lg:gap-6 lg:gap-4"></div>
  <div v-if="posts" :class="crearClases()" >
    <div v-for="post in posts" :key="post.id">
      <router-link :to="{ name: tipo, params: { 'slug': post.slug } }" class="grilla-enlace">
        <img v-if="tipo != 'persona' && post.imagen != null" :src="'https://image.tmdb.org/t/p/original' + post.imagen" :title="post.titulo + ', Poster'" />
        <img v-else-if="post.foto != null" :src="'https://image.tmdb.org/t/p/original' + post.foto" :title="post.nombre + ' , Foto'" />
        <img v-else src="https://cdn1.cinecritica.com/media/unknown.png" :title="post.nombre + ' , Foto'" />
        <div class="grilla-titulo">
          <div v-if="post.nota < 5" class="grilla-nota nota-roja">
            {{ post.nota }}
          </div>
          <div v-else-if="post.nota < 6.5" class="grilla-nota nota-ambar">
            {{ post.nota }}
          </div>
          <div v-else-if="tipo != 'persona'" class="grilla-nota nota-verde">
            {{ post.nota }}
          </div>
          <div v-if="tipo == 'persona'" class="grilla-titulo-texto">
            <strong>{{ post.nombre }}</strong><br/> {{post.pivot.personaje}}
          </div>
          <div v-else class="grilla-titulo-texto">
            {{ post.titulo }}
          </div>
        </div>
      </router-link>
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
      },
      columnas:{
        type:String,
        required:false,
        default:4
      },
      gap:{
        type: String,
        required:false,
        default:4
      }
    },
    methods:{
      crearClases(){
        return ' grilla lg:grid-cols-' + this.columnas + ' lg:gap-' + this.gap + '  '
      }
    }
  };
  </script>
  