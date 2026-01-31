import { createApp } from "vue";

import App from "./App.vue"

import axios from 'axios'

import router from './router'

import store from './store'

import VueCookies from 'vue3-cookies'

// oruga
import Oruga from '@oruga-ui/oruga-next'
import '@oruga-ui/oruga-next/dist/oruga.css'
import '@oruga-ui/oruga-next/dist/oruga-full.css'

// material design
import "@mdi/font/css/materialdesignicons.min.css"

//tailwind
import '../../css/app.css'


const app = createApp(App)
    .use(Oruga)
    .use(router)
    .use(store)
    .use(VueCookies)
app.config.globalProperties.$axios = axios
window.axios = axios
// Default title
document.title = 'Cinecritica'

// Set title for list pages (URL) or keep default; detail pages will set title after data loads
router.afterEach((to) => {
    const urlListNames = ['list', 'peliculaslist', 'serieslist']
    if (to && to.name && urlListNames.includes(to.name)) {
        document.title = window.location.href
    } else {
        // keep default until component updates it after fetching
        document.title = 'Cinecritica'
    }
    // Send page_path to Google Analytics if available
    try {
        if (window.gtag && to && to.fullPath) {
            window.gtag('config', 'G-XWBZGL68NM', { page_path: to.fullPath, page_title: document.title });
        }
    } catch (e) {
        // ignore
    }
})

app.mount('#app')
//createApp(App).use(Oruga).mount("#app")