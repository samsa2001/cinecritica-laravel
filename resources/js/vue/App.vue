<template>
  <div>
    <Navbar></Navbar>
    <div class="container">
      <div class="contenedor-principal">
        <div id="contenido">
          <router-view></router-view>
        </div>
        <div id="sidebar">
          <h3>Cine y Series</h3>
          <router-link :to="{ name: 'peliculaslist' }" class="btn w-40 relative"><span
              class="mdi mdi-movie-open absolute left-1"></span>Películas</router-link>
          <router-link :to="{ name: 'serieslist' }" class="btn relative"><span
              class="mdi mdi-television-box absolute left-1"></span>Series</router-link>
          <router-link :to="{ name: 'espana' }" class="btn relative"><span
              class="mdi mdi-television-box absolute left-1"></span>Cine Español</router-link>
          <h3>Blog</h3>
          <router-link :to="{ name: 'blog', query: { tipo: 'curiosidades' } }" class="btn relative"><span
              class="mdi mdi-movie-open-plus absolute left-1"></span>Curiosidades</router-link>
          <router-link :to="{ name: 'blog', query: { tipo: 'estrenos' } }" class="btn relative"><span
              class="mdi mdi-television-classic absolute left-1"></span>Estrenos</router-link>
          <router-link :to="{ name: 'blog', query: { tipo: 'taquilla' } }" class="btn relative"><span
              class="mdi mdi-filstrip absolute left-1"></span>Taquilla</router-link>
          <router-link :to="{ name: 'serieslist' }" class="btn relative"><span
              class="mdi mdi-movie-open absolute left-1"></span>Series</router-link>

        </div>
      </div>
    </div>
  </div>
</template>
<script>

import Navbar from './components/shared/Navbar.vue'

export default {
  components: {
    Navbar
  },
};
</script>

