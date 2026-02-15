<template>
   <div class="">
      <h1>{{ serie.titulo }}</h1>
      <h2>{{ serie.tagline }}</h2>
      <div class="flex flex-wrap">
         <div class="md:w-2/3 w-full flex flex-wrap">
            <div class="w-2/5  px-2 md:order-0 order-1">
               <img :src="'https://cdn1.cinecritica.com/media/series' + serie.imagen">
               <div class="md:hidden p-2 bg-green-900">
                  <h4 class="my-2 text-white">Imágenes</h4>
                  <div class="grid gap-2 md:grid-cols-3 grid-cols-1 ">
                     <div v-for="imagen in serie.imagenes" :key="imagen.id">
                        <div @click="imageModal(imagen.imagen)">
                           <img :src="'https://image.tmdb.org/t/p/original' + imagen.imagen">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="w-3/5  px-2 md:order-1 order-0">
               <div class="serie-descripcion">
                  <div class="barra-horizontal mt-0"></div>
                  <div class="grid grid-cols-2 gap-4">
                     <h3>Nota: </h3>
                     <div v-if="serie.nota < 5" class="nota nota-roja">
                        {{ serie.nota }}
                     </div>
                     <div v-else-if="serie.nota < 6.5" class="nota nota-ambar">
                        {{ serie.nota }}
                     </div>
                     <div v-else class="nota nota-verde">
                        {{ serie.nota }}
                     </div>
                  </div>
                  <Votar></Votar>
                  <div v-if="serie.providers">
                     <div class="barra-horizontal"></div>
                     <h3>Donde ver:</h3>
                     <div class="flex flex-wrap gap-2">
                        <div v-for="provider in serie.providers" :key="provider.id" class="text-center my-2 w-14">
                           <img :src="'https://cdn1.cinecritica.com/media/providers' + provider.logo" width="50"
                              class="block mx-auto">
                           <div class="block text-sm">{{ provider.nombre }}</div>
                        </div>
                     </div>
                  </div>
                  <div class="barra-horizontal"></div>
                  <p>{{ serie.descripcion }}</p>
                  <div class="barra-horizontal"></div>
               </div>
            </div>
            <div class="w-full order-2 md:pr-2">
               <Carrousel :personas="serie.actores" :personasText="'Actores'"></Carrousel>
            </div>
            <div class="md:block hidden w-full order-3 md:mr-2 p-2 bg-lime-900">
               <h4 class="my-2 text-white">Imágenes</h4>
               <div class="grid gap-2 md:grid-cols-3 grid-cols-1 ">
                  <div v-for="imagen in serie.imagenes" :key="imagen.id">
                     <div @click="imageModal(imagen.imagen)">
                        <img :src="'https://image.tmdb.org/t/p/original' + imagen.imagen">
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="md:w-1/3 w-full ficha">
            <ul class=" divide-y flex flex-col gap-y-3">
               <li>Número de votos: <span class="datos-ficha">{{ serie.numero_votos }}</span></li>
               <li>Año: <span class="datos-ficha">{{ serie.year }}</span></li>
               <li>Fecha estreno mundial: <span class="datos-ficha">{{ serie.fecha }}</span></li>
               <li>Titulo Original: <span class="datos-ficha">{{ serie.titulo_original }}</span></li>
               <li>Canal original: <span class="datos-ficha">{{ serie.canal }}</span>
               </li>
               <li>Número episodios: <span class="datos-ficha">{{ serie.numero_episodios }}</span>
               </li>
               <li>Duración por episodio: <span class="datos-ficha">{{ serie.duracion }}</span>
               </li>
               <li v-if="serie.en_produccion > 0">En producción : Sí</li>
               <li v-if="serie.fecha_ultimo">Fecha último episodio: <span class="datos-ficha">{{ serie.fecha_ultimo
               }}</span></li>
               <li>Pais: <span class="datos-ficha">{{ serie.pais }}</span></li>
               <li v-if="serie.generos != ''">
                  Generos:
                  <ul class="datos-ficha">
                     <li v-for="(genero, id) in serie.generos" :key="id">
                        {{ genero.titulo }}
                     </li>
                  </ul>
               </li>
               <li v-if="serie.creadores != ''">
                  Creador/es:
                  <ul class="datos-ficha">
                     <li v-for="(creador, id) in serie.creadores" :key="id">
                        <router-link :to="{ name: 'persona', params: { 'slug': creador.slug } }">
                           {{ creador.nombre }}
                        </router-link>
                     </li>
                  </ul>
               </li>
            </ul>
            <div v-if="serie.temporadas != ''">
               <div class="barra-horizontal"></div>
               <h3>Temporadas:</h3>
               <div class="grid grid-cols-3 gap-4">
                  <div v-for="(temporada, id) in serie.temporadas" :key="id">
                     <div @click="imageModalTemp(temporada.imagen)">
                        <img :src="'https://cdn1.cinecritica.com/media/temporadas' + temporada.imagen" />
                        {{ temporada.titulo }}
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="md:hidden block">
         <img :src="'https://cdn1.cinecritica.com/media/imagen-principal-series' + serie.imagen_principal">
      </div>
   </div>
</template>

 
<script>
import { defineComponent, h, ref, onMounted } from 'vue'
import { useProgrammatic } from '@oruga-ui/oruga-next'
import Grilla from '../shared/Grilla.vue'
import Votar from '../shared/Votar.vue'
import Carrousel from '../shared/Carrousel.vue'
import axios from "axios"
import { useRoute } from 'vue-router'

export default defineComponent({
   components: {
      Grilla,
      Votar,
      Carrousel,
      // Modal
   },
   setup() {
      const serie = ref([])
      const isLoading = ref(true)
      const route = useRoute()
      const { oruga } = useProgrammatic()
      onMounted(async () => {
         listPage();
      })

      function imageModal(imagen) {
         const vnode = h('p', { style: { 'text-align': 'center' } }, [
            h('img', { src: 'https://image.tmdb.org/t/p/original' + imagen })
         ])
         oruga.modal.open({
            content: [vnode],
            width: 1500,
            fullscreen: true,
         })
      }
      function imageModalTemp(imagen) {
         const vnode = h('p', { style: { 'text-align': 'center' } }, [
            h('img', { src: 'https://cdn1.cinecritica.com/media/temporadas' + imagen })
         ])
         oruga.modal.open({
            content: [vnode],
            width: 1500,
            fullscreen: true,
         })
      }
      function updatePage() {
         setTimeout(listPage, 100);
      }
      function listPage() {
         isLoading.value = true;
         axios
            .get("/api/serie/" + route.params.slug)
            .then((res) => {
               serie.value = res.data;
               if(serie.value && serie.value.titulo) document.title = serie.value.titulo + ' - Cinecritica';
            });
      }

      return {
         serie,
         isLoading,
         updatePage,
         imageModal,
         imageModalTemp,
      }
   }
})
</script>