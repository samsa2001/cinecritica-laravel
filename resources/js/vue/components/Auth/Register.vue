<template>
  <form @submit.prevent="submit()">
    <o-field 
        :variant="errors.login ? 'danger' : 'primary'"
        label="Nombre"
    >
        <o-input v-model="form.name"></o-input>
    </o-field>
    <o-field 
        :variant="errors.login ? 'danger' : 'primary'"
        label="Email"
    >
        <o-input v-model="form.email"></o-input>
    </o-field>
    <o-field 
        :variant="errors.login ? 'danger' : 'primary'"
        label="Contraseña"
    >
        <o-input v-model="form.password" type="password"></o-input>
    </o-field>
    <o-field 
        :variant="errors.login ? 'danger' : 'primary'"
        label="Confirmar contraseña"
    >
        <o-input v-model="form.password_confirmation" type="password"></o-input>
    </o-field>
    <div v-if="errors.login" class="bg-red-200 border border-red-600 rounded-md m-2 p-2">
        <ul>
            <li v-if="errors.login.errors.name">{{errors.login.errors.name[0]}}</li>
            <li v-if="errors.login.errors.email">{{errors.login.errors.email[0]}}</li>
            <li v-if="errors.login.errors.password">{{errors.login.errors.password[0]}}</li>
        </ul>
    </div>
    <o-button
        :disabled="disabledBotton"
        class="float-right"
        variant="primary"
        native-type="submit"
        >Enviar</o-button
    >
  </form>
</template>

<script>

import { mapState, mapActions } from "vuex"

export default {
    methods: {
        cleanErrorsForm() {
            this.errors.login = "";
        },
        submit(){
            this.disabledBotton = true;
            this.cleanErrorsForm();
            this.$axios
                .post('/api/user/register', this.form)
                .then((res)=>{
                    this.$store.commit('authStore/updateUser',res.data)
                    this.$cookies.set("auth", res.data);
                    setTimeout(() => {
                        this.disabledBotton = false;
                        this.$router.push({ name: 'list' });
                    }, 1500);
                    this.$oruga.notification.open({
                        message: "Login exitoso",
                        position: "bottom-right",
                        duration: 4000,
                        closable: true,
                    });
                    
                }).catch((error)=>{
                    this.disabledBotton = false;
                    if(error.response.data){
                        this.errors.login = error.response.data
                        console.log(error.response.data);
                    }
                })
        }
    },
    computed:{
      ...mapState('authStore',['isLoggedIn','user','token'])
    },
    data(){
        return {
            form: {
                email:'',
                password:''
            },
            disabledBotton: false,
            errors: {
                login:'',
            }
        }
    }
}
</script>

<style>

</style>