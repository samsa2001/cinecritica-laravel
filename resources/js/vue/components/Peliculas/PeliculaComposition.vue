<template>
    <div class="">
        <div class="seccion-titulo" :style="{backgroundImage:'url(https://image.tmdb.org/t/p/original' + pelicula.imagen_principal + ')'}" >
            <div class="fondo-titulo">
                <h1>{{ pelicula.titulo }}</h1> 
                <h2>{{ pelicula.tagline }}</h2>
            </div>
        </div>
        <div class="lg:float-left block max-w-sm mr-4 mb-4">
            <img :src="'https://image.tmdb.org/t/p/original' + pelicula.imagen">
            <h4 class="my-2">Imágenes</h4>
            <div class="grid gap-2 grid-cols-3 ">
                <div v-for="imagen in pelicula.imagenes" :key="imagen.id">                       
                    <div  @click="imageModal(imagen.imagen)">
                        <img :src="'https://image.tmdb.org/t/p/original' + imagen.imagen">
                    </div>
                </div>
            </div>   
        </div>
        <div class="grid lg:grid-cols-2 lg:gap-4 grid-cols-1">
            <div class="ficha bg-green-50 p-4 mb-4  border border-green-900 text-lg">
                <ul class=" divide-y flex flex-col gap-y-3">
                    <li>Número de votos: <span class="datos-ficha">{{ pelicula.numero_votos }}</span></li>
                    <li>Año: <span class="datos-ficha">{{ pelicula.year }}</span></li>
                    <li>Fecha estreno mundial: <span class="datos-ficha">{{ pelicula.fecha }}</span></li>
                    <li>Titulo Original: <span class="datos-ficha">{{ pelicula.titulo_original }}</span></li>
                    <li>Presupuesto: <span class="datos-ficha">{{ new Intl.NumberFormat().format(pelicula.presupuesto)
                    }}$</span>
                    </li>
                    <li>Recaudacion: <span class="datos-ficha">{{ new Intl.NumberFormat().format(pelicula.recaudacion)
                    }}$</span>
                    </li>
                    <li>Productora: <span class="datos-ficha">{{ pelicula.productora }}</span></li>
                    <li>Duracion: <span class="datos-ficha">{{ pelicula.duracion }} min.</span></li>
                    <li>Pais: <span class="datos-ficha">{{ pelicula.pais }}</span></li>
                    <li v-if="pelicula.generos != ''">
                        Generos:
                        <ul class="datos-ficha">
                            <li v-for="(genero, id) in pelicula.generos" :key="id">
                                {{ genero.titulo }}
                            </li>
                        </ul>
                    </li>
                    <li v-if="pelicula.guionistas != ''">
                        Guión:
                        <ul class="datos-ficha">
                            <li v-for="(guionista, id) in pelicula.guionistas" :key="id">
                                <router-link :to="{ name: 'persona', params: { 'slug': guionista.slug } }">
                                    {{ guionista.nombre }}
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="pelicula.escritores != ''">
                        Historia:
                        <ul class="datos-ficha">
                            <li v-for="(escritor, id) in pelicula.escritores" :key="id">
                                <router-link :to="{ name: 'persona', params: { 'slug': escritor.slug } }">
                                    {{ escritor.nombre }}
                                </router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
                <Votar></Votar>
            </div>
            <div class="pelicula-descripcion">
                <div class="barra-horizontal mt-0"></div>
                <div class="grid grid-cols-2 gap-4">
                    <div>Nota: </div>
                        <div v-if="pelicula.nota < 5" class="nota nota-roja">
                            {{ pelicula.nota }}
                        </div>
                        <div v-else-if="pelicula.nota < 6.5" class="nota nota-ambar">
                            {{ pelicula.nota }}
                        </div>
                        <div v-else class="nota nota-verde">
                            {{ pelicula.nota }}
                        </div>
                </div>
                <div class="barra-horizontal"></div>
                <div class="grid grid-cols-2 gap-4">
                    <div>Director:</div>
                    <ul class="datos-ficha text-center">
                        <li v-for="(director, id) in pelicula.directores" :key="id">
                            <router-link :to="{ name: 'persona', params: { 'slug': director.slug } }">
                                <img :src="'https://image.tmdb.org/t/p/original' + director.foto" width="100" class="block mx-auto">
                                {{ director.nombre }}
                            </router-link>
                        </li>
                    </ul>
                </div>
                <div class="barra-horizontal"></div>
                <p>{{ pelicula.descripcion }}</p>
                <div class="barra-horizontal"></div>
            </div>
        </div>
        <div class="clear-both"></div>
        <Grilla :posts="pelicula.actores" tipo="persona" columnas="6" gap="8" />
        <img :src="'https://image.tmdb.org/t/p/original' + pelicula.imagen_principal">
    </div>
</template>
 
<script>
import { defineComponent, h, ref, onMounted  } from 'vue'
import { useProgrammatic } from '@oruga-ui/oruga-next'
import Grilla from '../Grilla.vue'
import Votar from '../Votar.vue'
import axios from "axios"
import { useRoute } from 'vue-router'

export default defineComponent({
    components:{
        Grilla,
        Votar, 
        // Modal
    },
  setup() {
    const pelicula =ref([])
    const isLoading = ref(true)
    const route = useRoute()
    const { oruga } = useProgrammatic()
    onMounted(async () =>{
        listPage();
    })

    function imageModal(imagen) {
      const vnode = h('p', { style: { 'text-align': 'center' } }, [
        h('img', { src: 'https://image.tmdb.org/t/p/original' + imagen })
      ])
      oruga.modal.open({
        content: [vnode],

      })
    }
    function updatePage() {
        setTimeout(listPage, 100);
    }
    function listPage() {
        isLoading.value = true;
        axios
            .get("/api/pelicula/" + route.params.slug)
            .then((res) => {
                pelicula.value = res.data;
            });
    }

    return {
      pelicula,
      isLoading,
      updatePage,
      imageModal,
    }
  }
})
</script>