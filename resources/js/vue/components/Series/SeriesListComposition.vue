<template>
  <div>
    <div class="flex justify-between lg:flex-row flex-col items-center">
      <h1>Listado de series</h1>
      <div class="ordenacion">
        <o-radio v-model="orden" name="name" native-value="fecha" @update:modelValue="updatePage()">
          Ordenar por fecha estreno
        </o-radio>
        <o-radio v-model="orden" name="name" native-value="numVotos" @update:modelValue="updatePage()">
          Ordenar por número votos
        </o-radio>
      </div>
    </div>
    <Grilla :posts="posts.data" tipo="serie" columnas="5" gap="8"></Grilla>
    <o-pagination v-if="posts.current_page && posts.data.length > 0" @change="updatePage" :total="posts.total"
      v-model:current="currentPage" :range-before="2" :range-after="3" order="centered" size="medium" :simple="false"
      :rounded="true" :per-page="posts.per_page">
    </o-pagination>
  </div>
</template>

<script>
import { ref, onMounted  } from 'vue'
import Grilla from '../Grilla.vue'
import Votar from '../Votar.vue'
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
    })

    function updatePage() {
        setTimeout(listPage, 100);
    }
    function listPage() {
        isLoading.value = true;
        const apiQuery = (orden.value == 'fecha') 
          ? "/api/series?page=" + currentPage.value 
          : "/api/series/votos?page=" + currentPage.value
        axios
            .get(apiQuery)
            .then((res) => {
                posts.value = res.data;
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
