<template>
    <div class="">
        <h1>{{ pelicula.titulo }}</h1>
        <h2>{{ pelicula.tagline }}</h2>
        <div class="float-left max-w-sm mr-4 mb-4">
            <img :src="'https://image.tmdb.org/t/p/original' + pelicula.imagen">
        </div>
        <div class="ficha bg-green-50 p-4 mb-4 inline-block border border-green-900 text-lg">
            <ul>
                <li>Director:
                    <ul class="datos-ficha">
                        <li v-for="(director, id) in pelicula.directores" :key="id">
                            <router-link :to="{ name: 'persona', params: { 'slug': director.slug } }">
                                {{ director.nombre }}
                            </router-link>
                        </li>
                    </ul>
                </li>
                <li>Nota: <span class="datos-ficha">{{ pelicula.nota }}</span></li>
                <li>Número de votos: <span class="datos-ficha">{{ pelicula.numero_votos }}</span></li>
                <li>Año: <span class="datos-ficha">{{ pelicula.year }}</span></li>
                <li>Fecha estreno mundial: <span class="datos-ficha">{{ pelicula.fecha }}</span></li>
                <li>Titulo Original: <span class="datos-ficha">{{ pelicula.titulo_original }}</span></li>
                <li>Presupuesto: <span class="datos-ficha">{{ new Intl.NumberFormat().format(pelicula.presupuesto)
                }}</span>
                </li>
                <li>Recaudacion: <span class="datos-ficha">{{ new Intl.NumberFormat().format(pelicula.recaudacion)
                }}</span>
                </li>
                <li>Productora: <span class="datos-ficha">{{ pelicula.productora }}</span></li>
                <li>Duracion: <span class="datos-ficha">{{ pelicula.duracion }}</span></li>
                <li>Pais: <span class="datos-ficha">{{ pelicula.pais }}</span></li>
                <li v-if="pelicula.generos != ''">
                    Generos:
                    <ul class="datos-ficha">
                        <li v-for="(genero, id) in pelicula.generos" :key="id" >
                            {{ genero.titulo }}
                        </li>
                    </ul>
                </li>
                <li v-if="pelicula.guionistas != ''">
                    Guión:
                    <ul class="datos-ficha">
                        <li v-for="(guionista, id) in pelicula.guionistas" :key="id" >
                            <router-link :to="{ name: 'persona', params: { 'slug': guionista.slug } }">
                                {{ guionista.nombre }}
                            </router-link>
                        </li>
                    </ul>
                </li>
                <li v-if="pelicula.escritores != ''">
                    Historia:
                    <ul class="datos-ficha">
                        <li v-for="(escritor, id) in pelicula.escritores" :key="id" >
                            <router-link :to="{ name: 'persona', params: { 'slug': escritor.slug } }">
                                {{ escritor.nombre }}
                            </router-link>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <p>{{ pelicula.descripcion }}</p>
        <Grilla :posts="pelicula.actores" tipo="persona" />
        <img :src="'https://image.tmdb.org/t/p/original' + pelicula.imagen_principal">
    </div>
</template>

<script>
import Grilla from '../Grilla.vue'
export default {
    data() {
        return {
            pelicula: []
        }
    },
    components: {
        Grilla
    },
    methods: {
        updatePage() {
            setTimeout(this.listPage, 100);
        },
        listPage() {
            this.isLoading = true;
            this.$axios
                .get("/api/pelicula/" + this.$route.params.slug)
                .then((res) => {
                    this.pelicula = res.data;
                });

        },
        formatFecha(strFecha) {
            const trozoFecha = strFecha.split('/')
            trozoFecha.forEach(element => {
                console.log(element);
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