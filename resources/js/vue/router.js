import { createRouter, createWebHistory } from 'vue-router'

import List from './components/List.vue'
import Pelicula from './components/Peliculas/Pelicula.vue'
import PeliculaComposition from './components/Peliculas/PeliculaComposition.vue'
import PeliculasList from './components/Peliculas/PeliculasList.vue'
import PeliculasListComposition from './components/Peliculas/PeliculasListComposition.vue'
import Persona from './components/Personas/Persona.vue'
import SeriesList from './components/Series/SeriesList.vue'
import SeriesListComposition from './components/Series/SeriesListComposition.vue'
import Serie from './components/Series/Serie.vue'
import SerieComposition from './components/Series/SerieComposition.vue'
import Buscar from './components/Buscar/PaginaBuscar.vue'
import Login from './components/Auth/Login.vue'
import Blog from './components/Blog/PostList.vue'
import Post from './components/Blog/Post.vue'
import Espana from './components/Peliculas/PeliculasEspana.vue'

const routes = [
    {
        name: 'list',
        path: '/',
        component: List
    },
    {
        name: 'peliculaslist',
        path: '/peliculas/:page(\\d+)?',
        component: PeliculasListComposition
    },
    {
        name: 'pelicula',
        path: '/pelicula/:slug',
        component: PeliculaComposition
    },,
    {
        name: 'espana',
        path: '/españa',
        component: Espana
    },
    {
        name: 'serieslist',
        path: '/series/:page(\\d+)?',
        component: SeriesListComposition
    },
    {
        name: 'serie',
        path: '/serie/:slug',
        component: SerieComposition
    },
    {
        name: 'persona',
        path: '/persona/:slug',
        component: Persona
    },
    {
        name: 'buscar',
        path: '/buscar',
        component: Buscar,
    },
    {
        name: 'blog',
        path: '/blog',
        component: Blog
    },
    {
        name: 'post',
        path: '/blog/:slug',
        component: Post
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router