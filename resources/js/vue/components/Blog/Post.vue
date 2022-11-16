<template>
    <div class="">
        <h1>{{ post.titulo }}</h1>
        <div v-html="post.contenido">
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            post: []
        }
    },
    methods: {
        updatePage() {
            setTimeout(this.listPage, 100);
        },
        listPage() {
            this.isLoading = true;
            this.$axios
                .get("/api/post/" + this.$route.params.slug)
                .then((res) => {
                    this.post = res.data;
                });

        },
        formatFecha(strFecha) {
            const trozoFecha = strFecha.split('/')
            trozoFecha.forEach(element => {
                console.log(element);
            });
        }
    },
    async mounted() {
        this.listPage();
    },
}
</script>

<style>

</style>