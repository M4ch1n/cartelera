<template>
    <div class="col-lg-12">        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Crear Nueva Pel&iacute;cula</div>
                    <div class="card-body">
                        <div v-if="errors" class="alert alert-danger">
                            <ul v-for="(v, k) in errors" :key="k">
                                <li v-for="error in v" :key="error" class="text-sm">
                                  {{ error }}
                                </li>
                            </ul>
                        </div>
                        <div class="form-group" :form="form">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" v-model="form.data.name" placeholder="Escribe el nombre">
                        </div>
                        <div class="form-group drop" :form="form" 
                            :class="getClasses" 
                            @dragover.prevent="dragOver" 
                            @dragleave.prevent="dragLeave"
                            @drop.prevent="drop($event)"
                        >
                            <img :src="imageSource" v-if="imageSource"/>
                            <h1 v-if="wrongFile">Formato incorrecto de imagen</h1>
                            <h1 v-if="!imageSource && !isDragging && !wrongFile">Agrega una imagen</h1>
                        </div>
                        <button type="submit" @click="submit" v-show="create" class="btn btn-primary">Crear</button>
                        <button type="submit" @click="submit" v-show="!create" class="btn btn-primary">Editar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AppForm from './../../common/AppForm';
    import AppHttpForm from './../../common/AppHttpForm';

    export default {
        props: {
            peliculaId: { default: 0 },
            nombre: { default: '' },
            imagen: { default: '' }            
        },

        data() {
            return {
                isDragging: false,
                wrongFile: false,
                imageSource: null,
                file: '',
                create: true,
                imageCheck: true,
                errors: null,
                form: new AppForm({
                    name: '',
                    image: '',
                }),
            }
        },

        watch: { 
            peliculaId: function(newVal, oldVal) {
                if(newVal != 0) {
                    this.form.data.name = this.nombre;
                    this.imageSource = this.imagen.replace('public/', '');
                    this.create = false;
                    this.imageCheck = false;
                } else {
                    this.form.data.name = '';
                    this.imageCheck = true;
                    this.create = true;
                    this.imageSource = null;
                }                
            }
        },

        computed:{
            getClasses(){
              return {isDragging: this.isDragging}
            }
        },

        methods:{
            dragOver(){
              this.isDragging = true
            },

            dragLeave(){
              this.isDragging = false
            },

            drop(e){
                let files = e.dataTransfer.files
                this.wrongFile = false
                // allows only 1 file
                if (files.length === 1) {
                    let file = files[0]
                    // allows image only
                    if (file.type.indexOf('image/') >= 0) {
                        var reader = new FileReader()
                        this.file = file;
                        reader.onload = f => {
                            this.imageSource = f.target.result;
                            this.form.data.image = file;
                            this.imageCheck = true;
                            this.isDragging = false;
                        }
                        reader.readAsDataURL(file)
                    } else {
                        this.wrongFile = true
                        this.imageSource = null
                        this.isDragging = false
                    }
                }
            },

            submit() {
                let formData = new FormData();

                formData.append('image', this.form.data.image);
                formData.append('name', this.form.data.name);

                if(this.create) {
                    axios.post(`/peliculas/crear`, formData, { 
                        headers: {
                           'Content-Type': 'multipart/form-data'
                        }
                    }).then(response => {
                        this.peliculaId = response.data.id;
                        this.imagen = response.data.imagen;
                        this.nombre = response.data.nombre;
                        this.errors = null;
                    }).catch(e => {
                        this.errors = e.response.data.errors;
                    });
                } else {
                    formData.append('imageCheck', this.imageCheck);

                    axios.post(`/peliculas/${this.peliculaId}/actualizar`, formData, {
                        headers: {
                           'Content-Type': 'multipart/form-data'
                        }
                    }).then(response => {                        
                        this.errors = null;                        
                    }).catch(e => {
                        this.errors = e.response.data.errors;
                    });
                }
            },
  
        }
    }
</script>

<style scoped>
.drop{
    width: 100%;
    height: 100%;
    background-color: #eee;
    border:10px solid #eee;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    transition: background-color .2s ease-in-out;
    font-family: sans-serif;
}

.isDragging{
    background-color: #999;
    border-color: #fff;
}

img{
    max-height: 50vh;
    object-fit: contain;
}
</style>
