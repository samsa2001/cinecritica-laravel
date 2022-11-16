<template>
    <div >  
      <div v-if="posts" :class="crearClases()" class="grilla ">
        <div v-for="post in posts" :key="post.id">
          <router-link :to="{ name: tipo, params: { 'slug': post.slug } }" class="grilla-enlace">
            <img v-if="tipo != 'persona' && post.imagen != null" :src="'https://image.tmdb.org/t/p/original' + post.imagen" :title="post.titulo + ', Poster'" />
            <img v-else-if="post.foto != null" :src="'https://image.tmdb.org/t/p/original' + post.foto" :title="post.nombre + ' , Foto'" />
            <img v-else src="https://cdn1.cinecritica.com/media/unknown.png" :title="post.nombre + ' , Foto'" />
            <div class="grilla-titulo">
              <div v-if="post.nota < 5" class="grilla-nota bg-red-900">
                {{ post.nota }}
              </div>
              <div v-else-if="post.nota < 6.5" class="grilla-nota bg-amber-500">
                {{ post.nota }}
              </div>
              <div v-else-if="tipo != 'persona'" class="grilla-nota bg-green-900">
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
      </div>
  </template>
  
  <script>
  
  export default {
    props : {
      columnas:{
        type:String,
      },
      posts: {
        type:Array,
        required:true
      },
      tipo: {
        type:String,
        required:false,
        default: 'pelicula'
      },
      gap:{
        type: Number,
        required:false,
        default:4
      }
    },
    mounted() {
      console.log(this.columnas);

    },
    methods:{
      crearClases(){
        return 'lg:grid-cols-' + this.columnas + ' gap-' + this.gap + ' mt-4'
      }
    }
  };
  </script>
  