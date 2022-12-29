<template>
    <div class=" my-4 bg-slate-800 py-2 px-4 bordered" >
        <h5>Votar</h5>
        <div class="flex flex-row gap-4 items-centerjustify-around" >
            <select v-model="voto" class="w-28 rounded-md">
                <option v-for="nota in notas" :key="nota" :value="nota">{{nota}}</option>
            </select>
            <!-- <div v-if="auth" class="btn" @click="enviarVoto()">Enviar</div>
            <div v-else class="text-xs">Debes estar logeado para votar</div> -->
            <div class="btn" @click="enviarVoto()">Enviar</div>
        </div>
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
            if (this.voto){
                this.$axios
                    .post("/api/voto",{voto:this.voto, user:"auth.id"})
                    .then((res) => {
                        
                        console.log( res.data);
                    });
            }
        }
    }
}
</script>

<style>

</style>