<template>
  
  <nav class="bg-white border-b border-gray-100">
      <header class="container  px-4 sm:px-6 md:px-8">
        <div class="flex  items-center justify-araound flex-wrap">
          <div class="md:basis-1/5 basis-2/5 order-1">
            <a href="/">
              <img src="https://cdn1.cinecritica.com/media/logo-pulp.png" alt="Cinecritica">
            </a>
          </div>
          <div class="buscador md:basis-2/5 basis-full md:order-2 order-4 md:mt-0 mt-2 ">
            <Buscador></Buscador>
          </div>
          <nav class="md:basis-1/5 basis-full md:order-3 order-3 flex h-8 justify-evenly items-center">
            <router-link :to="{ name: 'peliculaslist' }">Películas</router-link>
            <router-link :to="{ name: 'serieslist' }">Series</router-link>
          </nav>
          <div class="nav-user md:basis-1/5 basis-3/5 md:order-4 order-2 flex  justify-evenly items-center">
            <div v-if="isLoggedIn">
              <div class="inline-block rounded-full w-9 h-9 bg-blue-300 text-center p-1 mr-2 font-bold
              ">
                {{ user.name.substr(0, 2).toUpperCase() }}
              </div>
              <button @click="toogleDropdown" id="dropdownDefault" data-dropdown-toggle="dropdown"
                class="btn inline-flex items-center ">Menú {{ user.name }} <svg class="ml-2 w-4 h-4" aria-hidden="true"
                  fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg></button>
              <!-- Dropdown menu -->
              <ul id="dropdown" 
              @click="toogleDropdown" 
              :class="{ hidden: !dropdownOpen }"
                class="absolute z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700">
                <ul class="py-1 text-sm dark:text-gray-200" aria-labelledby="dropdownDefault">
                  <li>
                    <a href="#"
                      class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Listas</a>
                  </li>
                  <li>
                    <a href="#"
                      class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Votaciones</a>
                  </li>
                  <li>
                    <a variant="danger" @click="logout" href="#"
                      class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Desconectar</a>
                  </li>
                </ul>
              </ul>
            </div>
            <router-link v-if="!isLoggedIn" :to="{ name: 'login' }">Identificarse</router-link>
            <router-link v-if="!isLoggedIn" :to="{ name: 'register' }">Registrarse</router-link>
          </div>
        </div>
      </header>
    </nav>
</template>

<script>

import { mapState } from 'vuex';
import Buscador from '../Buscar/Buscador.vue'

export default {
  data() {
    return {
      dropdownOpen: false,
    }
  },
  components: {
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
    this.dropdownOpen = false
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
    toogleDropdown() {
      this.dropdownOpen = !this.dropdownOpen
    }
  },
};
</script>
