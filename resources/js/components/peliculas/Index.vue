<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="offset-lg-11 col-lg-1 offset-md-11 col-md-1 text-right">
                <button type="button" class="btn btn-primary" @click="showCreate" v-show="!create">Crear Pelicula</button>
                <button type="button" class="btn btn-primary" @click="showCreate" v-show="create">Regresar</button>
            </div>

        </div>        
        <div class="row justify-content-center" v-show="!create">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">Peliculas</div>

                    <div class="card-body">
                        <div class="row" v-for="pelicula in peliculas">
                            <div class="col-md-3">{{pelicula.nombre}}</div>
                            <div class="col-md-3">{{pelicula.created_at | toReadableDate }}</div>
                            <div class="col-md-3" v-if="pelicula.estado">Activo</div>
                            <div class="col-md-3" v-else>Inactivo</div>
                            <div class="col-md-3">
                                <button @click="editarPelicula(pelicula.id, pelicula.nombre, pelicula.imagen)">
                                    <i class="fa fa-edit fa-fw"></i>
                                </button>
                                <button data-toggle="modal" data-target="#modalAsignarHorario" @click="checkTurnos(pelicula.id, pelicula.turnos)">
                                    <i class="fa fa-clock-o fa-fw"></i>
                                </button>
                                <button v-if='pelicula.estado' @click="cambiarEstado(pelicula.id, 0)">
                                    <i class="fa fa-unlock fa-fw"></i>                                    
                                </button>
                                <button v-else @click="cambiarEstado(pelicula.id, 1)">
                                    <i class="fa fa-lock fa-fw"></i>
                                </button>
                                <button data-toggle="modal" data-target="#modalBorrarPelicula" @click="setPeliculaId(pelicula.id)">
                                    <i class="fa fa-trash fa-fw"></i>
                                </button>
                            </div>
                        </div>

                        <v-pagination
                            v-model="pagination.current"
                            :length="pagination.total"
                            @input="onPageChange"
                            color="#3490dc"
                            prev-icon='<i class="fa fa-arrow-left fa-fw"></i>'
                            next-icon='<i class="fa fa-arrow-right fa-fw"></i>'
                        ></v-pagination>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" tabindex="-1" role="dialog" id="modalBorrarPelicula">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Borrar pelicula</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Estas seguro de borrar la pelicula?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" @click="borrarPelicula(peliculaId)">Borrar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" tabindex="-1" role="dialog" id="modalAsignarHorario">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Asignar Horarios</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div v-for="turno in turnos" class="col-md-3">
                                <input type="checkbox" :id="turno.id" :value="turno.turno" @click="toggleValue(turno.id, $event)"> {{ turno.turno | removeSeconds }}
                            </div>                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" @click="asignarHorario(peliculaId)">Asignar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" v-show="create">
            <app-peliculas-crear 
                :peliculaId="peliculaId"
                :nombre="nombre"
                :imagen="imagen"
            >
            </app-peliculas-crear>
        </div>

        
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getPeliculas();
            this.getTurnos();
        },

        data() {
            return {
                create: false,
                peliculas: null,
                peliculaId: 0,
                nombre: '',
                imagen: '',
                turnos: null,
                checkedTurnos: [],
                pagination: {
                    current: 1,
                    total: 0
                }
            }
        },

        methods: {
            showCreate() {
                this.peliculaId = 0;
                this.create = !this.create;

                if(!this.create) {
                    this.reloadTable();
                }
            },

            getPeliculas() {
                axios.get('/peliculas/list?page=' + this.pagination.current)
                .then(response => {
                    this.peliculas = response.data.data;
                    this.pagination.current = response.data.current_page;
                    this.pagination.total = response.data.last_page;
                });
            },

            getTurnos() {
                axios.get('/turnos/all')
                .then(response => {
                    this.turnos = response.data;
                })
            },
            
            onPageChange() {
                this.getPeliculas();
            },

            asignarHorario() {
                let formData = new FormData();
                formData.append('id', this.peliculaId);
                formData.append('turnos', this.checkedTurnos);

                axios.post(`/peliculas/turnos`, formData)
                .then(response => {
                    this.reloadTable();
                });
                
            },

            editarPelicula(peliculaId, nombre, imagen) {
                this.peliculaId = peliculaId;
                this.nombre = nombre;
                this.imagen = imagen;
                this.create = true;
                //console.log('asignarHorario');
            },

            cambiarEstado(peliculaId, val) {
                axios.patch(`/peliculas/${peliculaId}/estado`, {
                    'estado': val
                }).then(response => {
                    this.reloadTable();
                });
            },

            borrarPelicula(peliculaId) {
                axios.delete(`/peliculas/${peliculaId}/borrar`)
                .then(() => {
                    this.reloadTable();
                });
            },

            reloadTable() {
                this.getPeliculas();
            },

            setPeliculaId(peliculaId) {
                this.peliculaId = peliculaId;
            },

            toggleValue(val, event) {
                if(event.target.checked) {
                    this.checkedTurnos.push(val);
                } else {
                    var index = this.checkedTurnos.indexOf(val);
                    if (index > -1) {
                        this.checkedTurnos.splice(index, 1);
                    }
                }
            },

            checkTurnos(peliculaId, turnos) {
                this.checkedTurnos = [];
                this.setPeliculaId(peliculaId);
                this.uncheckTurnos();
                
                turnos.forEach((value) => {
                    $("#" + value.id).prop( "checked", true );
                    this.checkedTurnos.push(value.id);
                });
            },

            uncheckTurnos() {
                this.turnos.forEach((value) => {
                    $("#" + value.id).prop( "checked", false );
                });
            },
        },
    }
</script>
