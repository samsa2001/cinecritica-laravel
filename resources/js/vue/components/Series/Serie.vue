<template>
    <div class="">       
        <h1>{{ serie.titulo }}</h1>
        <h2>{{ serie.tagline }}</h2>
        <div class="lg:float-left block max-w-sm mr-4 mb-4">
            <img :src="'https://image.tmdb.org/t/p/original' + serie.imagen">
            <h4 class="my-2">Imágenes</h4>
            <div class="grid gap-2 grid-cols-3 ">
                <div v-for="imagen in serie.imagenes" :key="imagen.id">                       
                    <div  @click="imageModal2()">
                        <img :src="'https://cdn1.cinecritica.com/series' + imagen.imagen">
                    </div>
                </div>
            </div>   
            <!-- <Modal></Modal>   -->
            <!-- <o-modal v-model:active="isImageModalActive()">
                <p style="text-align: center">
                    <img :src="'https://image.tmdb.org/t/p/original' + imagen.imagen">
                </p>
            </o-modal> -->
        </div>
        <div class="grid lg:grid-cols-2 lg:gap-4 grid-cols-1">
            <div class="ficha bg-green-50 p-4 mb-4  border border-green-900 text-lg">
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
                    <li v-if="serie.fecha_ultimo">Fecha último episodio: <span class="datos-ficha">{{ serie.fecha_ultimo }}</span></li>
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
                <Votar></Votar>
            </div>
            <div class="serie-descripcion">
                <div class="barra-horizontal mt-0"></div>
                <div class="grid grid-cols-2 gap-4">
                    <div>Nota: </div>
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
                <div class="barra-horizontal"></div>
                <div v-if="serie.temporadas != ''">
                    Temporadas:
                    <ul class="datos-ficha flex flex-wrap">
                        <li v-for="(temporada, id) in serie.temporadas" :key="id" class="w-20 m-2">
                            <img :src="'https://cdn1.cinecritica.com/series-temporada'+temporada.imagen" />
                                {{ temporada.titulo }}
                        </li>
                    </ul>
                </div>
                <div class="barra-horizontal"></div>
                <p>{{ serie.descripcion }}</p>
                <div class="barra-horizontal"></div>
            </div>
        </div>
        <div class="clear-both"></div>
        <Grilla :posts="serie.actores" tipo="persona" columnas="6" gap="8" />
        <img :src="'https://cdn1.cinecritica.com/imagen-principal-series' + serie.imagen_principal">
    </div>
</template>

<script>

import { h } from 'vue'
import Grilla from '../shared/Grilla.vue'
import Votar from '../shared/Votar.vue'
import { useProgrammatic } from '@oruga-ui/oruga-next'
// import Modal from './Modal.vue'

export default {
    data() {
        return {
            serie: [],
        }
    },
    components:{
        Grilla,
        Votar, 
        // Modal
    },
    methods: {
        updatePage() {
            setTimeout(this.listPage, 100);
        },
        listPage() {
            this.isLoading = true;
            this.$axios
                .get("/api/serie/" + this.$route.params.slug)
                .then((res) => {
                    this.serie = res.data;
                });
        },
        imageModal(imagen) {
            const vnode = h('p', { style: { 'text-align': 'center' } }, [
                // h('img', { src: 'https://image.tmdb.org/t/p/original' + imagen })
                h('img', { src: 'https://image.tmdb.org/t/p/original/5s9XHTB9SLPdg3mNU6BlSLnZ9Qq.jpg' })
            ])
            this.oruga.modal.open({
                content: [vnode]
            })
        },
        imageModal2() {
        const vnode = h('p', { style: { 'text-align': 'center' } }, [
            h('img', { src: 'https://avatars2.githubusercontent.com/u/66300512?s=200&v=4' })
        ])
        this.oruga.modal.open({
            content: [vnode]
        })
        }
    },
    async mounted() {
        this.listPage();
    },
}
</script>

<style>

</style>