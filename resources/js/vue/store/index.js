import { createStore } from 'vuex'
import authStore from './auth'
import buscarStore from './buscar'

export default createStore({
    modules: {
        authStore,
        buscarStore
    }
})