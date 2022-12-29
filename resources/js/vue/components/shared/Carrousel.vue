<template>
  <div id="tab" class="tabs">
      <ul class="flex flex-wrap font-medium text-center ">
          <li v-if="peliculas != null" class="mr-2">
              <a @click="f_peliculas()" href="#tab" class="tab-titulo" :class="{'active':tab_peliculas }">Peliculas</a>
          </li>
          <li v-if="series != null" class="mr-2">
              <a @click="f_series()" href="#tab" class="tab-titulo" :class="{'active':tab_series }">Series</a>
          </li>
          <li v-if="personas != null" class="mr-2">
              <a @click="f_personas()" href="#tab" class="tab-titulo" :class="{'active':tab_personas }">{{ personasText }}</a>
          </li>
      </ul>
      <div class="tabs-contenido">
          <div v-if="personas != '' && tab_personas">
            <o-carousel  v-model="carousel" v-bind="settings">
                <o-carousel-item v-for="(persona, i) in personas" :key="i">        
                  <router-link :to="{ name: 'persona', params: { 'slug': persona.slug } }" class=" bg-lime-800">
                  <img v-if="persona.foto == null" src="https://cdn1.cinecritica.com/media/unknown.png" alt="{{ persona.nombre }}">  
                  <img v-else :src="'https://cdn1.cinecritica.com/media/personas' + persona.foto " :alt="persona.nombre"/>
                      <div class=" bottom-0 w-full bg-lime-800 text-white min-h-42 flex flex-row">
                        <div class="grow text-center">
                          <strong>{{ persona.nombre }}</strong><span v-if="persona.pivot != null" class="block">{{ persona.pivot.personaje }}</span>
                        </div>
                      </div>
                  </router-link>
                </o-carousel-item>
            </o-carousel>
          </div>
          <div v-if="peliculas != '' && tab_peliculas">
            <o-carousel  v-model="carousel" v-bind="settings">
                <o-carousel-item v-for="(pelicula, i) in peliculas" :key="i">        
                  <router-link :to="{ name: 'pelicula', params: { 'slug': pelicula.slug } }" class=" bg-lime-800">
                  <img :src="'https://cdn1.cinecritica.com/media/peliculas' + pelicula.imagen" :alt="pelicula.titulo" />
                      <div class=" bottom-0 w-full bg-lime-800 text-white min-h-42 flex flex-col">
                        <div class="grow text-center">
                          {{ pelicula.titulo }}
                        </div>
                        <div v-if="pelicula.nota < 5" class="nota-roja">
                          {{ pelicula.nota }}
                        </div>
                        <div v-else-if="pelicula.nota < 6.5" class="nota-ambar">
                          {{ pelicula.nota }}
                        </div>
                        <div v-else class="nota-verde">
                          {{ pelicula.nota }}
                        </div>
                      </div>
                  </router-link>
                </o-carousel-item>
            </o-carousel>
          </div>
          <div v-if="series != '' && tab_series">
            <o-carousel  v-model="carousel" v-bind="settings">
                <o-carousel-item v-for="(serie, i) in series" :key="i" class="w-1/3">        
                  <router-link :to="{ name: 'serie', params: { 'slug': serie.slug } }" class=" bg-lime-800">
                  <img :src="'https://cdn1.cinecritica.com/media/series' + serie.imagen" :alt="serie.titulo" />
                      <div class=" bottom-0 w-full bg-lime-800 text-white min-h-42 flex flex-col">
                        <div class=" text-center">
                          {{ serie.titulo }}
                        </div>
                        <div v-if="serie.nota < 5" class="nota-roja">
                          {{ serie.nota }}
                        </div>
                        <div v-else-if="serie.nota < 6.5" class="nota-ambar">
                          {{ serie.nota }}
                        </div>
                        <div v-else class="nota-verde">
                          {{ serie.nota }}
                        </div>
                      </div>
                  </router-link>
                </o-carousel-item>
            </o-carousel>
          </div>
      </div>
  </div>
</template>

<script>

  export default {
    props : {
      peliculas:{
        type:Array,
        required:false,
        default:null
      },
      series:{
        type:Array,
        required:false,
        default:null
      },
      personas:{
        type:Array,
        required:false,
        default:null
      },
      personasText:{
        type:String,
        required:false,
        default:'Personas'
      }
    },
    data(){ 
        return {
            items:[],
            carousel : 0,
            settings : {
                arrow: true,
                arrowHover: false,
                hasDrag: true,
                itemsToShow: 2,
                itemsToList: 2,
                repeat: false,
                breakpoints: { 
                  768: { itemsToShow: 3, itemsToList: 3,}, 
                  960: { itemsToShow: 4, itemsToList: 4,}, 
                  1200: { itemsToShow: 5, itemsToList: 5,}
                }
            },
            tab_peliculas: true,
            tab_personas:false,
            tab_series:false
        }
    },
    methods: {
        f_peliculas(){
            this.tab_peliculas=true
            this.tab_personas = this.tab_series = false
        },
        f_series(){
            this.tab_series=true
            this.tab_personas = this.tab_peliculas = false
        },
        f_personas(){
            this.tab_personas=true
            this.tab_peliculas = this.tab_series = false
        },
    },
    updated(){        
      if(this.peliculas == null && this.series == null){
        this.f_personas()
      } else if ( this.peliculas == null && this.personas == null){
        this.f_series()
      }   
    }
  }
</script>

<style>

</style>