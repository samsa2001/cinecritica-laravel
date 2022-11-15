<template>
   <o-carousel
      v-model="carousel"
      v-bind="settings"
    >
      <o-carousel-item v-for="(post, i) in posts" :key="i">        
        <router-link :to="{ name: (post.numero_episodios >0)?'serie':'pelicula'
            , params: { 'slug': post.slug } }" class=" bg-lime-800">
        <img :src="'https://image.tmdb.org/t/p/original' + post.imagen" />
            <div class=" bottom-0 w-full bg-lime-800 text-white min-h-42 flex flex-row">
              <div v-if="post.nota < 5" class="p-3 min-h-full bg-red-900 text-white">
                {{ post.nota }}
              </div>
              <div v-else-if="post.nota < 6.5" class="p-3 min-h-full bg-amber-500 text-white">
                {{ post.nota }}
              </div>
              <div v-else class="p-3 min-h-full bg-green-900 text-white">
                {{ post.nota }}
              </div>
              <div v-if="tipo == 'persona'" class="grow text-center">
                <strong>{{ post.nombre }}</strong><br/> {{post.pivot.personaje}}
              </div>
              <div v-else class="grow text-center">
                {{ post.titulo }}
              </div>
            </div>
        </router-link>
      </o-carousel-item>
    </o-carousel>
</template>

<script>

  export default {
    props : {
      posts: {
        type:Array,
        required:true
      },
    },
    data(){ 
        return {
            items:[],
            carousel : 0,
            settings : {
                arrow: true,
                arrowHover: false,
                hasDrag: true,
                itemsToShow: 5,
                itemsToList: 5,
                repeat: false,
            },
        }
    },
    mounted(){        
        console.log(this.posts);
    }
  }
</script>

<style>

</style>