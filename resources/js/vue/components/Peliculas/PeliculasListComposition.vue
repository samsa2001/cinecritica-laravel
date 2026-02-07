<template>
  <div>
    <div class="flex lg:flex-row flex-col justify-between items-center">
      <h1>Listado de películas</h1>
      <div class="ordenacion">
        <o-radio v-model="orden" name="name" native-value="fecha" @update:modelValue="updatePage()">
          Ordenar por fecha estreno
        </o-radio>
        <o-radio v-model="orden" name="name" native-value="popularidad" @update:modelValue="updatePage()">
          Ordenar por popularidad
        </o-radio>
        <o-radio v-model="orden" name="name" native-value="numVotos" @update:modelValue="updatePage()">
          Ordenar por número votos
        </o-radio>
      </div>
    </div>
    <Grilla :posts="posts.data" tipo="pelicula" columnas="5" gap="12"/>
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
import { ref, onMounted  } from 'vue'
import Grilla from '../shared/Grilla.vue'
import Votar from '../shared/Votar.vue'
import axios from "axios"
import { useRoute } from 'vue-router'

export default ({
    components:{
        Grilla,
        Votar, 
    },
  setup() {
    const posts = ref([])
    const isLoading = ref(true)
    const orden = ref('fecha')
    const currentPage= ref(1)
    const route = useRoute()

    onMounted(async () =>{
      if(route.params.page)
        currentPage.value = route.params.page
      listPage();
      // set title to current URL for list pages
      document.title = window.location.href
    })

    function updatePage() {
        setTimeout(listPage, 100);
    }
    function listPage() { 
        isLoading.value = true;
        const apiQuery = (orden.value == 'fecha') 
          ? "/api/peliculas?page=" + currentPage.value 
          :  (orden.value == 'popularidad') 
            ? "/api/peliculas/popularidad?page=" + currentPage.value 
            : "/api/peliculas/votos?page=" + currentPage.value 
        axios
            .get(apiQuery)
            .then((res) => {
                posts.value = res.data;
              // ensure title reflects URL after data loads
              document.title = window.location.href
            });
    }

    return {
      posts,
      isLoading,
      orden,
      currentPage,
      updatePage,
    }
  }
})
</script>
