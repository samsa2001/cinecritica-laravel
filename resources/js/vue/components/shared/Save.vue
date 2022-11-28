<template>
    <div>
        <h1 v-if="post">Actualizar post {{ post.id }}</h1>
        <h1 v-else>Nuevo post</h1>
        <form @submit.prevent="submit">
            <o-field label="Titulo" :variant="errors.title ? 'danger' : 'primary'" :message="errors.title">
                <o-input v-model="form.title" value=""></o-input>
            </o-field>
            <div class="grid grid-cols-2 gap-3">
                <o-field label="Descripción" :variant="errors.description ? 'danger' : 'primary'"
                    :message="errors.description">
                    <o-input v-model="form.description" type="textarea" value=""></o-input>
                </o-field>
                <o-field label="Contenido" :variant="errors.content ? 'danger' : 'primary'" :message="errors.content">
                    <o-input v-model="form.content" type="textarea" value=""></o-input>
                </o-field>
                <div class="grid lg:grid-cols-3 gap-3">
                    <o-field label="Categoría" :variant="errors.category_id ? 'danger' : 'primary'"
                        :message="errors.category_id">
                        <o-select v-model="form.category_id" placeholder="Seleccionar categoría">
                            <option v-for="c in categories" v-bind:key="c.id" :value="c.id">{{ c.title }}</option>
                        </o-select>
                    </o-field>
                    <o-field label="Etiquetas">
                        <o-select v-model="form.tags" placeholder="Seleccionar categoría" multiple>
                            <option v-for="t in allTags" v-bind:key="t.id" :value="t.id">{{ t.title }}</option>
                        </o-select>
                    </o-field>
                    <o-field label="Posted" :variant="errors.posted ? 'danger' : 'primary'" :message="errors.posted">
                        <o-select v-model="form.posted" placeholder="Seleccionar un estado">
                            <option value="yes">Sí</option>
                            <option value="not">No</option>
                        </o-select>
                    </o-field>
                </div>
                <div v-if="post" class="border px-3">
                    <o-field :message="fileError">
                        <o-upload v-model="file">
                            <o-button tag="a" variant="primary">
                                <o-icon icon="upload"></o-icon>
                                <span v-if="file">Cambiar imagen</span>
                                <span v-else>Subir una imagen</span>
                            </o-button>
                        </o-upload>
                    </o-field>
                    <div v-if="file">
                        <span class="font-lg font-bold block ">{{ file.name }}</span>
                        <o-button  icon-left="upload" @click="upload"> Subir </o-button>
                    </div>
                </div>
                <!-- 
    
// otro método de subir imagenes.
// como no hay botón de subir imagen
// la imagen se guarda con un watch que vigila cambios

            <div class="flex gap-2" v-if="post">
                <o-field :message="fileError">
                <o-upload v-model="filesDaD" multiple drag-drop>
                    <section>
                    <o-icon icon="upload"></o-icon>
                    <span>Drag and Drop para cargar archivos</span>
                    </section>
                </o-upload>
                </o-field>
                <span v-for="(file, index) in filesDaD" :key="index">
                {{ file.name }}
                </span>
            </div> -->
                <br />
            </div>
            <o-button variant="primary" native-type="submit">
                Enviar
            </o-button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            categories: [],
            allTags: [],
            form: {
                title: "",
                description: "",
                content: "",
                category_id: "",
                posted: "",
                tags: []
            },
            errors: {
                title: "",
                description: "",
                content: "",
                category_id: "",
                posted: "",
            },
            post: "",
            file: null,
            filesDaD: [],
            fileError: "",
        }

    },
    async mounted() {
        if (this.$route.params.url_clean) {
            await this.getPost()
            this.initPost()
        }
        this.getCategory()
        this.getTags()
    },
    methods: {
        clearErrorsForm() {
            this.errors.title = ""
            this.errors.category_id = ""
            this.errors.posted = ""
            this.errors.content = ""
            this.errors.description = ""
        },
        submit() {
            this.clearErrorsForm()
            const config = {
                headers: { Authorization: `Bearer ${this.$cookies.get('auth').token}` }
            };
            console.log(this.form);
            
            if (this.post == "")
                return this.$axios.post('/api/post', this.form, config)
                    .then((res) => {
                        this.$oruga.notification.open({
                            message: "Guardado con éxito",
                            position: "top",
                            duration: 4000,
                            closable: true,
                        });
                        
                    this.$router.push({ name: 'list' });
                    })
                    .catch(error => {
                        if (error.response.data.title)
                            this.errors.title = error.response.data.title[0];
                        if (error.response.data.description)
                            this.errors.description = error.response.data.description[0];
                        if (error.response.data.category_id)
                            this.errors.category_id = error.response.data.category_id[0];
                        if (error.response.data.posted)
                            this.errors.posted = error.response.data.posted[0];
                        if (error.response.data.content)
                            this.errors.content = error.response.data.content[0];
                    })
            this.$axios
                .patch('/api/post/' + this.post.id, this.form, config)
                .then((res) => {
                    this.$oruga.notification.open({
                        message: "Modificado con éxito",
                        position: "bottom-right",
                        duration: 4000,
                        closable: true,
                    });
                    this.$router.push({ name: 'list' });
                })
                .catch(error => {
                    if (error.response.data.title)
                        this.errors.title = error.response.data.title[0];
                    if (error.response.data.description)
                        this.errors.description = error.response.data.description[0];
                    if (error.response.data.category_id)
                        this.errors.category_id = error.response.data.category_id[0];
                    if (error.response.data.posted)
                        this.errors.posted = error.response.data.posted[0];
                    if (error.response.data.content)
                        this.errors.content = error.response.data.content[0];
                })


        },
        getCategory() {
            this.$axios.get('/api/category/all').then(res => {
                this.categories = res.data
            })
        },
        getTags() {
            this.$axios.get('/api/tags/all').then(res => {
                this.allTags = res.data
            })
        },
        async getPost() {
            this.post = await this.$axios.get('/api/post/slug/' + this.$route.params.url_clean)
            this.post = this.post.data
        },
        initPost() {
            this.form.title = this.post.title;
            this.form.description = this.post.description;
            this.form.content = this.post.content;
            this.form.category_id = this.post.category_id;
            this.form.posted = this.post.posted;
            this.form.tags = this.post.tags

        },
        upload() {
            //return console.log(this.file)
            this.fileError = "";
            const formData = new FormData();
            formData.append("image", this.file);
            this.$axios
                .post("/api/post/upload/" + this.post.id, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    },
                })
                .then((res) => {
                    this.$oruga.notification.open({
                        message: "Imagen cargada",
                        position: "bottom right",
                        duration: 4000,
                        closable: true,
                    });
                    this.file=null
                })
                .catch((error) => {
                    this.fileError = error.response.data.message;
                });
        },

    },
    watch: {
        filesDaD: {
            handler(val) {
                //return console.log(val[val.length - 1]);
                this.fileError = "";
                const formData = new FormData();
                formData.append("image", val[val.length - 1]);
                this.$axios
                    .post("/api/post/upload/" + this.post.id, formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                            Authorization: "Bearer " + this.$root.token,
                        },
                    })
                    .then((res) => {
                        console.log(res);
                    })
                    .catch((error) => {
                        this.fileError = error.response.data.message;
                    });
            },
            deep: true,
        },
    },
}
</script>

<style>

</style>