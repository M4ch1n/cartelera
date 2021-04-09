<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="offset-lg-11 col-lg-1 offset-md-11 col-md-1 text-right">
                <button type="button" class="btn btn-primary" @click="showCreate" v-show="!create">Crear Turno</button>
                <button type="button" class="btn btn-primary" @click="showCreate" v-show="create">Regresar</button>
            </div>

        </div>        
        <div class="row justify-content-center" v-show="!create">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">Turnos</div>

                    <div class="card-body">
                        <div class="row" v-for="turno in turnos">
                            <div class="col-md-3">{{turno.turno}}</div>                            
                            <div class="col-md-3" v-if="turno.estado">Activo</div>
                            <div class="col-md-3" v-else>Inactivo</div>
                            <div class="col-md-3">
                                <button @click="editarTurno(turno.id, turno.turno)">
                                    <i class="fa fa-edit fa-fw"></i>
                                </button>                                
                                <button v-if='turno.estado' @click="cambiarEstado(turno.id, 0)">
                                    <i class="fa fa-unlock fa-fw"></i>                                    
                                </button>
                                <button v-else @click="cambiarEstado(turno.id, 1)">
                                    <i class="fa fa-lock fa-fw"></i>
                                </button>
                                <button data-toggle="modal" data-target="#modalBorrarturno"" @click="setTurnoId(turno.id)">
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
        <div class="modal" tabindex="-1" role="dialog" id="modalBorrarturno">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Borrar turno</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Estas seguro de borrar el turno?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" @click="borrarTurno(turnoId)">Borrar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-show="create">
            <app-turnos-crear 
                :turnoId="turnoId"
                :time="time"
            >
            </app-turnos-crear>
        </div>

        
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getTurnos();
        },

        data() {
            return {
                create: false,
                turnos: null,
                turnoId: 0,
                time: '',
                pagination: {
                    current: 1,
                    total: 0
                }
            }
        },

        methods: {
            showCreate() {
                this.turnoId = 0;
                this.create = !this.create;

                if(!this.create) {
                    this.reloadTable();
                }
            },

            getTurnos() {
                axios.get('/turnos/list?page=' + this.pagination.current)
                .then(response => {                    
                    this.turnos = response.data.data;
                    this.pagination.current = response.data.current_page;
                    this.pagination.total = response.data.last_page;
                });
            },
            
            onPageChange() {
                this.getTurnos();
            },

            editarTurno(turnoId, time) {
                this.turnoId = turnoId;
                this.time = time;                
                this.create = true;
                //console.log('asignarHorario');
            },

            cambiarEstado(turnoId, val) {
                axios.patch(`/turnos/${turnoId}/estado`, {
                    'estado': val
                }).then(response => {                    
                    this.reloadTable();
                });
            },

            borrarTurno(turnoId) {
                axios.delete(`/turnos/${turnoId}/borrar`)
                .then(() => {
                    this.reloadTable();
                });
            },

            reloadTable() {
                this.getTurnos();
            },

            setTurnoId(turnoId) {
                this.turnoId = turnoId;
            }
        },
    }
</script>

<style scoped>
    .custom {
        color: #000;
    }
    .v-pagination {
        align-items: center;
        display: inline-flex;
        list-style-type: none;
        justify-content: center;
        margin: 0;
        max-width: 100%;
        width: 100%;
    }

    .v-pagination > li {
        align-items: center;
        display: flex;
    }

    .v-pagination__navigation {
        box-shadow: 0 3px 1px -2px rgb(0 0 0 / 20%), 0 2px 2px 0 rgb(0 0 0 / 14%), 0 1px 5px 0 rgb(0 0 0 / 12%);
        border-radius: 4px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        height: 32px;
        width: 32px;
        margin: .3rem 10px;
    }

    .v-pagination__navigation--disabled {
        opacity: .6;
        pointer-events: none;
    }

    /*.theme--light.v-pagination .v-pagination__item--active {
        color: #fff;
    }*/

    .theme--light.v-pagination .v-pagination__item {
        background: #000 !important;
        color: rgba(0,0,0,.87);
    }

    .v-application .primary {
        background-color: #1867c0 !important;
        border-color: #1867c0 !important;
    }

    .v-pagination__item--active {
        background: #000 !important;
        box-shadow: 0 2px 4px -1px rgb(0 0 0 / 20%), 0 4px 5px 0 rgb(0 0 0 / 14%), 0 1px 10px 0 rgb(0 0 0 / 12%);
    }

    .v-pagination__item {
        background: transparent;
        border-radius: 4px;
        font-size: 1rem;
        height: 34px;
        margin: .3rem;
        min-width: 34px;
        padding: 0 5px;
        text-decoration: none;
        transition: .3s cubic-bezier(0,0,.2,1);
        width: auto;
        box-shadow: 0 3px 1px -2px rgb(0 0 0 / 20%), 0 2px 2px 0 rgb(0 0 0 / 14%), 0 1px 5px 0 rgb(0 0 0 / 12%);
    }
</style>

