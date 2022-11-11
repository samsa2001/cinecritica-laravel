<template>
    <div>  
      <h1>Listado de <span v-if="tipo='pelicula'">películas</span><span v-else>series</span></h1>
      <o-button iconLeft="plus" @click="$router.push({ name: 'save' })">Crear</o-button>
  
      <o-table
        :loading="isLoading"
        :data="posts.current_page && posts.data.length == 0 ? [] : posts.data"
      >
        <o-table-column field="title" label="Título" v-slot="p">
          <router-link :to="{ name:'serie',params:{ 'slug': p.row.slug } }">{{ p.row.titulo }}</router-link> <span class="nota">{{  p.row.nota }}</span>
        </o-table-column>
        <o-table-column field="imagen" label="Cartel" v-slot="p">
          <img :src="'https://image.tmdb.org/t/p/original' + p.row.imagen " width="100" :title="p.row.titulo">      
        </o-table-column>
        <o-table-column field="created_at" label="Fecha" v-slot="p">
          {{ p.row.fecha }}
        </o-table-column>
        <o-table-column field="actores" label="Actores" v-slot="p">
          <div v-for="t in p.row.actores" :key="t.id" class="inline mr-2">
            {{ t.nombre }}
          </div>
        </o-table-column> 
      </o-table>
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
  