<template>
    <div class="relative">
        <o-field class="barra-buscar">
        <o-input v-model="textoBuscar" placeholder="Buscar..." type="search" icon="magnify" icon-pack="mdi" icon-clickable iconRightClickable @icon-click="buscar" @icon-right-click="buscar" iconRight="arrow-right" @keyup="buscarActiva" @keyup.enter="buscar">
        </o-input>
        </o-field>
        <div id="resultado-busqueda" :class="{'activo':activo}">
            <div @click="limpiarBusqueda()">
                <Buscar v-if="activo" :coleccion="coleccion" :textoBuscar="textoBuscar    "></Buscar>
            </div>
        </div>
    </div>
</template>

<script>
import Buscar from './Buscar.vue'
export default {
    data() {
    return {
      coleccion:[],
      textoBuscar: "",
      activo: false,
    }
    },
    components:{
        Buscar
    },
    methods: {
        buscar() {
            this.$router.push({ name: 'buscar', query: { q: this.textoBuscar } })
            this.limpiarBusqueda()
        },
        buscarActiva (){
            if(this.textoBuscar.length > 3) {
                this.activo = true
                this.hacerBusqueda()
            } else {
                this.activo = false
            }
        },
        hacerBusqueda(){
            if(this.textoBuscar.length > 3) {
                this.$axios
                    .get("/api/buscar/" + this.textoBuscar)
                    .then((res) => {
                        this.coleccion = res.data;
                    });
                }
        },
        limpiarBusqueda(){            
            this.textoBuscar= ''
            this.coleccion = []
            this.activo = false
        }
    },
    async mounted() {
        // this.textoBuscar = this.$route.query.q
        // this.listPage();
        
    },
    async updated() {
        // this.textoBuscar = this.$route.query.q
        // this.listPage();
        
    },
}
</script>

<style>

</style>