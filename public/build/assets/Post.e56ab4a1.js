import{_ as i,o as n,c as r,b as e,t as c}from"./main.29450f72.js";import"./axios.0ae12843.js";const p={data(){return{post:[]}},methods:{updatePage(){setTimeout(this.listPage,100)},listPage(){this.isLoading=!0,this.$axios.get("/api/post/"+this.$route.params.slug).then(t=>{this.post=t.data})},formatFecha(t){t.split("/").forEach(s=>{console.log(s)})}},async mounted(){this.listPage()}},l={class:""},h=["innerHTML"];function d(t,a,s,u,o,_){return n(),r("div",l,[e("h1",null,c(o.post.titulo),1),e("div",{innerHTML:o.post.contenido},null,8,h)])}const f=i(p,[["render",d]]);export{f as default};