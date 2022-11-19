<template>
  <div>
    <nav class="bg-white border-b border-gray-100">
      <header class="container  px-4 sm:px-6 lg:px-8">
        <div class="flex  items-center justify-araound">
          <div class="basis-1/4">
            <a href="/">
              <img src="https://cdn1.cinecritica.com/media/logo-pulp.png" alt="Cinecritica">
            </a>
          </div>
          <div class="buscador basis-1/2">
            <Buscador></Buscador>
          </div>
          <div class="basis-1/4 flex py-4 px-4 sm:px-6 justify-between items-center">
            <!-- <div></div> -->
            <div class="flex h-8 items-center nav-bar">
              <router-link :to="{ name: 'peliculaslist' }">Películas</router-link>
              <router-link :to="{ name: 'serieslist' }">Series</router-link>
              <router-link v-if="!isLoggedIn" :to="{ name: 'login' }">Login</router-link>
              <router-link class="
                    inline-flex
                    uppercase
                    border-b-2
                    text-sm
                    leading-5
                    mx-3
                    px-4
                    py-1
                    text-gray-600 text-center
                    font-bold
                    hover:text-gray-900 hover:border-gray-700 hover:-translate-y-1
                    duration-150
                    transition-all
                  " v-if="isLoggedIn" :to="{ name: 'list' }">Post</router-link>

              <o-button v-if="isLoggedIn" variant="danger" @click="logout">
                Logout
              </o-button>
            </div>

            <div class="flex flex-col items-center" v-if="isLoggedIn">
              <div class="
                    rounded-full
                    w-9
                    h-9
                    bg-blue-300
                    text-center
                    p-1
                    font-bold
                  ">
                {{ user.name.substr(0, 2).toUpperCase() }}
              </div>
              <p>
                {{ user.name }}
              </p>
            </div>
          </div>
        </div>
      </header>
    </nav>
    <div class="container">
      <div class="contenedor-principal">
        <div id="contenido">
          <router-view></router-view>
        </div>
        <div id="sidebar">
          <router-link :to="{ name: 'peliculaslist' }" class="btn w-40 relative"><span
              class="mdi mdi-movie-open absolute left-1"></span>Películas</router-link>
          <router-link :to="{ name: 'serieslist' }" class="btn relative"><span
              class="mdi mdi-television-box absolute left-1"></span>Series</router-link>
          <router-link :to="{ name: 'espana' }" class="btn relative"><span
              class="mdi mdi-television-box absolute left-1"></span>Cine Español</router-link>
          <h3>Blog</h3>
          <router-link :to="{ name: 'blog', query:{tipo:'curiosidades'} }" class="btn relative"><span
              class="mdi mdi-movie-open-plus absolute left-1"></span>Curiosidades</router-link>
          <router-link :to="{ name: 'blog', query:{tipo:'estrenos'} }" class="btn relative"><span
              class="mdi mdi-television-classic absolute left-1"></span>Estrenos</router-link>
          <router-link :to="{ name: 'blog', query:{tipo:'taquilla'} }" class="btn relative"><span
              class="mdi mdi-filstrip absolute left-1"></span>Taquilla</router-link>
          <router-link :to="{ name: 'serieslist' }" class="btn relative"><span
              class="mdi mdi-movie-open absolute left-1"></span>Series</router-link>

        </div>
      </div>
    </div>
  </div>
</template>
<script>

import { mapState } from 'vuex';
import Buscador from './components/Buscar/Buscador.vue'

export default {
  data() {
  },
  components:{
    Buscador
  },
  computed: {
    ...mapState('authStore', ['isLoggedIn', 'user', 'token'])
  },
  created() {
    const auth = this.$cookies.get("auth");

    if (auth) {
      this.$store.commit('authStore/updateUser', auth)
      this.isLoggedIn = true;
      this.user = auth.user;
      this.token = auth.token;
      this.$axios
        .post("/api/user/token-check", {
          token: auth.token,
        })
        //.then(() => {})
        .catch(() => {
          this.setCookieAuth("");
          this.$router.push({ name: 'login' });
        });
    }
  },
  methods: {
    logout() {
      this.$axios
        .post("/api/user/logout", {
          token: this.token,
        })
        .then((res) => {
          this.setCookieAuth("");
          this.$store.commit('authStore/clearUser')
          this.$router.push({ name: 'login' });
        });
    },
    setCookieAuth(data) {
      this.$cookies.set("auth", data);
    },
  },
};
</script>

