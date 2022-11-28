import { createRouter, createWebHistory } from 'vue-router'

const routes = [
    {
        name: 'list',
        path: '/',
        component: () => import( './components/List.vue' )
    },
    {
        name: 'peliculaslist',
        path: '/peliculas/:page(\\d+)?',
        component: () => import( './components/Peliculas/PeliculasListComposition.vue' )
    },
    {
        name: 'pelicula',
        path: '/pelicula/:slug',
        component: () => import( './components/Peliculas/PeliculaComposition.vue' )
    },,
    {
        name: 'espana',
        path: '/españa',
        component: () => import( './components/Peliculas/PeliculasEspana.vue' )
    },
    {
        name: 'serieslist',
        path: '/series/:page(\\d+)?',
        component: () => import( './components/Series/SeriesListComposition.vue' )
    },
    {
        name: 'serie',
        path: '/serie/:slug',
        component: () => import( './components/Series/SerieComposition.vue' )
    },
    {
        name: 'persona',
        path: '/persona/:slug',
        component: () => import( './components/Personas/Persona.vue' )
    },
    {
        name: 'buscar',
        path: '/buscar',
        component: () => import( './components/Buscar/PaginaBuscar.vue' )
    },
    {
        name: 'blog',
        path: '/blog',
        component: () => import( './components/Blog/PostList.vue' )
    },
    {
        name: 'post',
        path: '/blog/:slug',
        component: () => import( './components/Blog/Post.vue' )
    },
    {
        name: 'login',
        path: '/login',
        component: () => import( './components/Auth/Login.vue' )
    },
    {
        name: 'register',
        path: '/registro',
        component: () => import( './components/Auth/Register.vue' )
    },
    {
        path: '/:pathMatch(.*)*',
        component: () => import( './components/List.vue' )
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router