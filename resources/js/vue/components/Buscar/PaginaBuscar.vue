<template>
    <h1>Busqueda de "{{textoBuscar}}"</h1>
        <div id="pagina-buscar" class="w-2/3">
            <Buscar :coleccion="coleccion" :textoBuscar="textoBuscar"></Buscar>
        </div>
</template>

<script>
import Buscar from './Buscar.vue'
export default {
    data() {
        return {
        coleccion:[],
        textoBuscar: "",
        }
    },
    components:{
        Buscar
    },
    methods: {
        updatePage() {
            setTimeout(this.listPage, 100);
        },
        listPage() {
            this.isLoading = true;
            this.$axios
                .get("/api/buscar/" + this.textoBuscar)
                .then((res) => {
                    this.coleccion = res.data;
                });
        }
    },
    async mounted() {
        this.textoBuscar = this.$route.query.q
        this.listPage();
        
    },
    async updated() {
        this.textoBuscar = this.$route.query.q
        this.listPage();
        
    },
}
</script>

<style>

</style>