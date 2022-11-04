import { createRouter, createWebHistory } from 'vue-router'

import List from './components/List.vue'
import Pelicula from './components/Peliculas/Pelicula.vue'
import PeliculasList from './components/Peliculas/PeliculasList.vue'
import Persona from './components/Personas/Persona.vue'
import SeriesList from './components/Series/SeriesList.vue'
import Serie from './components/Series/Serie.vue'
import Buscar from './components/Buscar/Buscar.vue'
import Login from './components/Auth/Login.vue'

const routes = [
    {
        name: 'list',
        path: '/vue',
        component: List
    },
    {
        name: 'peliculaslist',
        path: '/vue/peliculas',
        component: PeliculasList
    },
    {
        name: 'pelicula',
        path: '/vue/pelicula/:slug?',
        component: Pelicula
    },
    {
        name: 'serieslist',
        path: '/vue/series',
        component: SeriesList
    },
    {
        name: 'serie',
        path: '/vue/serie/:slug?',
        component: Serie
    },
    {
        name: 'persona',
        path: '/vue/persona/:slug?',
        component: Persona
    },
    {
        name: 'buscar',
        path: '/vue/buscar',
        component: Buscar
    },
    {
        name: 'login',
        path: '/vue/login',
        component: Login
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router