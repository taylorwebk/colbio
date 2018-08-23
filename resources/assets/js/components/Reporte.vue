<template>
        <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
                <li class="breadcrumb-item"><a href="#">Aportes</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Control de Aportes
                    </div>
                    <!--Listado, Tabla de afiliados-->
                    <template v-if="listado">
                        
                    </template>

                        <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th colspan="2">Inscritos por Gestión</th>
                            </tr>
                            <tr>
                                <td>Visualizarlos afiliados inscritos en una gestión especifica.</td>
                                <td>
                                    <button type="button" @click="abrirModal('gestion')" class="btn btn-info btn-sm">
                                        <i class="icon-doc"></i> Ver Informe
                                    </button> &nbsp;
                                </td>
                            </tr>

                        </table>

                        <table class="table table-bordered table-striped">
                            <tr>
                                <th colspan="2">Reporte de Deudores </th>
                            </tr>
                            <tr>
                                <td>Visualizarlos afiliados que no realizaron su aporte, hasta una fecha especifica.</td>
                                <td>
                                    <button type="button" @click="abrirModal('deudores')" class="btn btn-info btn-sm">
                                        <i class="icon-doc"></i> Ver Informe
                                    </button> &nbsp;
                                </td>
                            </tr>
                        </table>

                        <table class="table table-bordered table-striped">
                            <tr>
                                <th colspan="2">Reporte de Afiliados que Si pagaron  </th>
                            </tr>
                            <tr>
                                <td>Visualizarlos afiliados que realizaron su aporte, hasta una fecha especifica.</td>
                                <td>
                                    <button type="button" @click="abrirModal('pagaron')" class="btn btn-info btn-sm">
                                        <i class="icon-doc"></i> Ver Informe
                                    </button> &nbsp;
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div v-if="tipoAccion==1" class="form-group row">
                                <label class="form-control-label col-md-6 " for="text-input"> Introdicir Gestión </label>
                                <input type="number" class="form-control col-md-6" v-model="gestion">
                            </div>

                            <div v-if="tipoAccion==2 " class="form-group row">
                                <label class="form-control-label col-md-6 " for="text-input"> introducir Fecha </label>
                                <input type="date" class="form-control col-md-6" v-model="fecha">
                            </div>

                            <div v-if="tipoAccion==3" class="form-group row">
                                <label class="form-control-label col-md-6 " for="text-input"> introducir Fecha </label>
                                <input type="date" class="form-control col-md-6" v-model="fecha">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-secondary">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="informeGestionPdf()">Continuar </button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-success" @click="informeDeudoresPdf()">Continuar </button>
                            <button type="button" v-if="tipoAccion==3" class="btn btn-success" @click="informeNoDeudoresPdf()">Continuar </button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

        </main>
</template>

<script>
import moment from 'moment';
moment.locale('es');
    export default {
        data(){
            return {
                afiliado_id:0,
                arrayAfiliado:[],
                arrayTitulos:[],
                listado : 1,
                gestion : 0,
                fecha : '',

                gestionActual : '',
                fechaActual : '',

                modal : 0,
                tituloModal : '',
                errorAfiliado : '',
                errorMostrarMsjAfiliado : [],
                tipoAccion : '',
            }
        },
        methods:{
            listarTitulos (id){
                    let me=this;
                    var url= 'afiliado/perfil?id='+id;
                    axios.get(url).then(function (response) {
                        me.arrayAfiliado=response.data.afiliado;
                        me.arrayTitulos=response.data.titulos;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            abrirModal(accion){
                switch(accion){
                    case 'gestion':
                    {
                        this.modal = 1;
                        this.tituloModal = 'Generar Informe por Gestión';
                        this.gestion = this.gestionActual;
                        this.tipoAccion = 1;

                        //this.tipoAccion = 1;
                        break;
                    }

                    case 'deudores':
                    {
                        this.modal = 1;
                        this.tituloModal = 'Generar Informe de Afiliados Deudores';
                        this.fecha = this.fechaActual;
                        this.tipoAccion = 2;

                        //this.tipoAccion = 1;
                        break;
                    }

                    case 'pagaron':
                    {
                        this.modal = 1;
                        this.tituloModal = 'Generar Informe de Afiliados que Pagaron';
                        this.fecha = this.fechaActual;
                        this.tipoAccion = 3;

                        //this.tipoAccion = 1;
                        break;
                    }


                    case 'actualizar':
                    {
                        //console.log(data);
                        this.modal=1;
                        this.tituloModal='Actualizar afiliado ';
                        this.tipoAccion=2;
                        this.afiliado_id=data['id'];
                        this.nombres = data['nombres'];
                        this.apellido_paterno= data['apellido_paterno'];
                        break;
                    }
                }
            },
            cerrarModal(){
                this.afiliado_id=0;
                this.arrayAfiliado=[];
                this.arrayTitulos=[];
                this.listado = 1;
                this.gestion = 0;
                this.fecha = '';
                this.modal = 0;
                this.tituloModal = '';
                this.errorAfiliado = '';
                this.errorMostrarMsjAfiliado = [];
                this.tipoAccion = 0;
            },

            informeGestionPdf(){
                window.open('/reporte/gestion?gestion='+this.gestion,'_blank');
            },
            informeDeudoresPdf(){
                window.open('/reporte/deudores?fecha='+this.fecha,'_blank');
            },
            informeNoDeudoresPdf(){
                window.open('/reporte/nodeudores?fecha='+this.fecha,'_blank');
            },

            desde(date){
                return moment(date).format("D MMMM YYYY");
            }
        },
        mounted() {
            this.gestionActual = moment(moment.now()).format("YYYY"); //selecciona el año actual
            this.fechaActual =  moment(moment.now()).format("Y-MM-DD"); //selecciona el año actual
        },
        
    }
</script>

<style>    
    .modal-content{
    
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    @media (min-width: 600px) {
        .btnagregar{
            margin-top:2rem;
        }
    }
</style>
