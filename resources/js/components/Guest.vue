<template>
    <div class="col-lg-12">
        <div class="row justify-content-center" v-show="!create">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Peliculas</div>

                    <div class="card-body">
                        <div class="row" v-for="pelicula in peliculas">
                            <div class="col-md-4">{{pelicula.nombre}}</div>                            
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-3" v-for="turno in pelicula.turnos">
                                        {{ turno.turno | removeSeconds }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <i class="fa fa-eye fa-fw" data-toggle="modal" data-target="#modalPeliculaImg" @click="getImage(pelicula.imagen)"></i>
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
        <div class="modal" tabindex="-1" role="dialog" id="modalPeliculaImg">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Poster de la pel&iacute;cula</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img :src='imageSource'>
                    </div>
                    <div class="modal-footer">                        
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getPeliculas();
        },

        data() {
            return {
                create: false,
                peliculas: null,
                imageSource: null,                
                pagination: {
                    current: 1,
                    total: 0
                }
            }
        },

        methods: {
            getPeliculas() {
                axios.get('/peliculas/listg?page=' + this.pagination.current)
                .then(response => {
                    this.peliculas = response.data.data;
                    this.pagination.current = response.data.current_page;
                    this.pagination.total = response.data.last_page;
                });
            },
            
            onPageChange() {
                this.getPeliculas();
            },
            
            reloadTable() {
                this.getPeliculas();
            },

            getImage(val) {
                this.imageSource = val.replace('public/', '');
            }
        },
    }
</script>

<style scoped>
    .modal-body img {
        max-height: 30vh;
    }
</style>
