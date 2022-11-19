<template>
    <div class="">       
        <h1>{{ serie.titulo }}</h1>
        <h2>{{ serie.tagline }}</h2>
        <div class="lg:float-left block max-w-sm mr-4 mb-4">
            <img :src="'https://image.tmdb.org/t/p/original' + serie.imagen">
        </div>
        <div class="grid lg:grid-cols-2 lg:gap-4 grid-cols-1">
            <div class="ficha bg-green-50 p-4 mb-4  border border-green-900 text-lg">
                <ul class=" divide-y flex flex-col gap-y-3">
                    <li>Número de votos: <span class="datos-ficha">{{ serie.numero_votos }}</span></li>
                    <li>Año: <span class="datos-ficha">{{ serie.year }}</span></li>
                    <li>Fecha estreno mundial: <span class="datos-ficha">{{ serie.fecha }}</span></li>
                    <li>Titulo Original: <span class="datos-ficha">{{ serie.titulo_original }}</span></li>
                    <li>Presupuesto: <span class="datos-ficha">{{ new Intl.NumberFormat().format(serie.presupuesto)
                    }}$</span>
                    </li>
                    <li>Recaudacion: <span class="datos-ficha">{{ new Intl.NumberFormat().format(serie.recaudacion)
                    }}$</span>
                    </li>
                    <li>Productora: <span class="datos-ficha">{{ serie.productora }}</span></li>
                    <li>Duracion: <span class="datos-ficha">{{ serie.duracion }} min.</span></li>
                    <li>Pais: <span class="datos-ficha">{{ serie.pais }}</span></li>
                    <li v-if="serie.generos != ''">
                        Generos:
                        <ul class="datos-ficha">
                            <li v-for="(genero, id) in serie.generos" :key="id">
                                {{ genero.titulo }}
                            </li>
                        </ul>
                    </li>
                    <li v-if="serie.guionistas != ''">
                        Guión:
                        <ul class="datos-ficha">
                            <li v-for="(guionista, id) in serie.guionistas" :key="id">
                                <router-link :to="{ name: 'persona', params: { 'slug': guionista.slug } }">
                                    {{ guionista.nombre }}
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="serie.escritores != ''">
                        Historia:
                        <ul class="datos-ficha">
                            <li v-for="(escritor, id) in serie.escritores" :key="id">
                                <router-link :to="{ name: 'persona', params: { 'slug': escritor.slug } }">
                                    {{ escritor.nombre }}
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
                <div class="grid grid-cols-2 gap-4">
                    <div>Creador:</div>
                    <ul class="datos-ficha text-center">
                        <li v-for="(creador, id) in serie.creadores" :key="id">
                            <router-link :to="{ name: 'persona', params: { 'slug': creador.slug } }">
                                <img :src="'https://image.tmdb.org/t/p/original' + creador.foto" width="100" class="block mx-auto">
                                {{ creador.nombre }}
                            </router-link>
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
        <img :src="'https://image.tmdb.org/t/p/original' + serie.imagen_principal">
    </div>
</template>

<script>

import Grilla from '../Grilla.vue'

export default {
    data() {
        return {
            serie: []
        }
    },
    components:{
        Grilla
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
        }
    },
    async mounted() {
        this.listPage();
    },
}
</script>

<style>

</style>