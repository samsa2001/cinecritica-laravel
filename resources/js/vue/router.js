import { createRouter, createWebHistory } from 'vue-router'

import List from './components/List.vue'
import Pelicula from './components/Peliculas/Pelicula.vue'
import PeliculasList from './components/Peliculas/PeliculasList.vue'
import Persona from './components/Personas/Persona.vue'
import SeriesList from './components/Series/SeriesList.vue'
import Serie from './components/Series/Serie.vue'
import Buscar from './components/Buscar/Buscar.vue'
import Login from './components/Auth/Login.vue'
import Blog from './components/Blog/PostList.vue'
import Post from './components/Blog/Post.vue'

const routes = [
    {
        name: 'list',
        path: '/',
        component: List
    },
    {
        name: 'peliculaslist',
        path: '/peliculas',
        component: PeliculasList
    },
    {
        name: 'pelicula',
        path: '/pelicula/:slug',
        component: Pelicula
    },
    {
        name: 'serieslist',
        path: '/series',
        component: SeriesList
    },
    {
        name: 'serie',
        path: '/serie/:slug',
        component: Serie
    },
    {
        name: 'persona',
        path: '/persona/:slug',
        component: Persona
    },
    {
        name: 'buscar',
        path: '/buscar',
        component: Buscar
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