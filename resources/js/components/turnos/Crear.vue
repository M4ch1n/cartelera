<template>
    <div class="col-lg-12">        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Crear Nuevo Turno</div>
                    <div class="card-body">
                        <div v-if="errors" class="alert alert-danger">
                            <ul v-for="(v, k) in errors" :key="k">
                                <li v-for="error in v" :key="error" class="text-sm">
                                  {{ error }}
                                </li>
                            </ul>
                        </div>
                        <div class="form-group" :form="form">
                            <input type="time" :form="form" v-model="form.data.time">
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
            turnoId: { default: 0 },
            time: { default: '' },
        },

        data() {
            return {                
                create: true,                
                errors: null,
                form: new AppForm({
                    id: 0,
                    time: '',
                }),
            }
        },

        watch: { 
            turnoId: function(newVal, oldVal) {
                if(newVal != 0) {
                    this.form.data.time = this.time;                    
                    this.create = false;
                    this.errors = null;
                } else {
                    this.form.data.time = '';                    
                    this.create = true;
                    this.errors = null;
                }
            }
        },

        methods:{
            submit() {
                let formData = new FormData();

                formData.append('time', this.form.data.time);                

                if(this.create) {
                    axios.post(`/turnos/crear`, formData)
                    .then(response => {                        
                        this.turnoId = response.data.id;
                        this.time = response.data.turno;
                        this.errors = null;
                        this.create = false;
                    }).catch(e => {
                        this.errors = e.response.data.errors;
                    });
                } else {
                    axios.post(`/turnos/${this.turnoId}/actualizar`, formData)
                    .then(response => {
                        this.errors = null;
                    }).catch(e => {
                        this.errors = e.response.data.errors;
                    });
                }
            },
        }
    }
</script>
