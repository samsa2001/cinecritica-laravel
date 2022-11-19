

const buscarStore ={
    namespaced: true,
    // el state es como el data de los components
    state:() =>( {
        textoBuscar:'',
        coleccion:null,
    }),
    // las mutations realizan los cambios en state
    // las mutations son como los methods de components, no pueden ser asincronos
    mutations: {
        updateStore (state, data){
            console.log(data);
            state.textoBuscar = data.textoBuscar
            state.coleccion = data.coleccion

        },
        clearStore (state){
            state.textoBuscar = ''
            state.coleccion = null

        }
    },
    // las actions pueden ser async y cambian el state llamando a mutaciones
    actions: {
    },
    // los getters son parecidos a las computed properties devuelven el valor de las state
    getters:{
        getState(){
            return state
        },
    }

}

export default buscarStore