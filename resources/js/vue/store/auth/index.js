

const authStore ={
    namespaced: true,
    // el state es como el data de los components
    state:() =>( {
        isLoggedIn:false,
        user:'',
        token:''
    }),
    // las mutations realizan los cambios en state
    // las mutations son como los methods de components, no pueden ser asincronos
    mutations: {
        updateUser (state, data){
            state.isLoggedIn = data.isLoggedIn
            state.user = data.user
            state.token = data.token

        },
        clearUser (state){
            state.isLoggedIn = false
            state.user = ''
            state.token = ''

        }
    },
    // las actions pueden ser async y cambian el state llamando a mutaciones
    actions: {
    },
    // los getters son parecidos a las computed properties devuelven el valor de las state
    getters:{
    }

}

export default authStore