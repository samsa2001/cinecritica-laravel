<template>
  <!-- se deben precargar las clases que puede que se utilicen en la funcion crearClases  -->
  <div
    class="grid lg:grid-cols-6 lg:grid-cols-5 lg:grid-cols-4 lg:grid-cols-3 grid-cols-5 grid-cols-4 grid-cols-3 lg:gap-8 lg:gap-6 lg:gap-4 lg:gap-10 lg:gap-12">
  </div>
  <div v-if="posts" :class="crearClases()">
    <div v-for="post in posts" :key="post.id">
      <div v-if="post.hasOwnProperty('nombre')">
        <router-link :to="{ name: 'persona', params: { 'slug': post.slug } }" class="grilla-enlace">
          <img v-if="post.foto != null" :src="'https://cdn1.cinecritica.com/media/personas' + post.foto"
            :title="post.nombre + ', Foto'" />
          <img v-else src="https://cdn1.cinecritica.com/media/unknown.png" :title="post.nombre + ' , Foto'" />
          <div class="grilla-titulo">
            <div class="grilla-titulo-texto">
              <strong>{{ post.nombre }}</strong><br /><span v-if="tipo=='persona'"> {{ post.pivot.personaje }}</span>
            </div>
          </div>
        </router-link>
      </div>
      <div v-else-if="post.hasOwnProperty('numero_episodios')">
        <router-link :to="{ name: 'serie', params: { 'slug': post.slug } }" class="grilla-enlace">
          <img v-if="post.imagen != null" :src="'https://cdn1.cinecritica.com/media/series' + post.imagen"
            :title="post.titulo + ', Poster'" />
          <div class="grilla-titulo">
            <div class="grilla-titulo-texto">
              {{ post.titulo }}
            </div>
          </div>
          <div v-if="post.nota < 5" class="nota grilla-nota nota-roja">
            {{ post.nota }}
          </div>
          <div v-else-if="post.nota < 6.5" class="nota grilla-nota nota-ambar">
            {{ post.nota }}
          </div>
          <div v-else-if="tipo != 'persona'" class="nota grilla-nota nota-verde">
            {{ post.nota }}
          </div>
          <div class="columns-2 bg-slate-300">
            <div class="border px-2"><span class="mdi mdi-calendar-range mr-1"></span> {{ post.year }}</div>
            <div class="border px-2"><span class="mdi mdi-account-check mr-1"></span> {{ post.numero_votos }}</div>
          </div>
        </router-link>
      </div>
      <div v-else>
        <router-link :to="{ name: 'pelicula', params: { 'slug': post.slug } }" class="grilla-enlace">
          <img v-if="post.imagen != null" :src="'https://cdn1.cinecritica.com/media/peliculas' + post.imagen"
            :title="post.titulo + ', Poster'" />
          <div class="grilla-titulo">
            <div class="grilla-titulo-texto">
              {{ post.titulo }}
            </div>
          </div>
          <div v-if="post.nota < 5" class="nota grilla-nota nota-roja">
            {{ post.nota }}
          </div>
          <div v-else-if="post.nota < 6.5" class="nota grilla-nota nota-ambar">
            {{ post.nota }}
          </div>
          <div v-else-if="tipo != 'persona'" class="nota grilla-nota nota-verde">
            {{ post.nota }}
          </div>
          <div class="columns-2 bg-slate-300">
            <div class="border px-2"><span class="mdi mdi-calendar-range mr-1"></span> {{ post.year }}</div>
            <div class="border px-2"><span class="mdi mdi-account-check mr-1"></span> {{ post.numero_votos }}</div>
          </div>
        </router-link>
      </div>
    </div>
  </div>
</template>
  
<script>

export default {
  props: {
    posts: {
      type: Object,
      required: true
    },
    tipo: {
      type: String,
      required: false,
      default: 'pelicula'
    },
    columnas: {
      type: String,
      required: false,
      default: "4"
    },
    gap: {
      type: String,
      required: false,
      default: "6"
    }
  },
  methods: {
    crearClases() {
      return ' grilla lg:grid-cols-' + this.columnas + ' lg:gap-' + this.gap + '  '
    }
  }
};
</script>
  