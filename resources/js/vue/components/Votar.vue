<template>
    <div class="flex flex-row gap-4 my-4 items-center bg-slate-200 py-2 px-4 bordered justify-around" >
        <h5>Votar</h5>
        <select v-model="voto" class="w-28 rounded-md">
            <option v-for="nota in notas" :key="nota" :value="nota">{{nota}}</option>
        </select>
        <div class="btn" @click="enviarVoto()">Enviar</div>
    </div>

</template>

<script>
export default {
    data(){
        return{
            voto:'',
            notas:[1,2,3,4,5,6,7,8,9,10]
        }
    },
    methods:{
        enviarVoto(){
            if (this.voto)
                console.log("Has votado con un " + this.voto)
        }
    }
}
</script>

<style>

</style>