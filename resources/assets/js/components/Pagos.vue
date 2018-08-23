<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Administración de aportes 
                    </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="ci">C.I</option>   
                                        <option value="codigounico">Carnet Colegio</option>
                                        <option value="apellido_paterno">Apellido Paterno</option>
                                        <option value="nombres">Nombres</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarAfiliado(1,buscar,criterio)" class="form-control" placeholder="Afiliado a Buscar">
                                        <button type="submit" @click="listarAfiliado(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Paterno</th>
                                        <th>Materno</th>
                                        <th>Nombres</th>
                                        <th>CI</th>
                                        <th>Carnet Colegio</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="afiliado in arrayAfiliado" :key="afiliado.id">
                                        <td><!--botones actualizar, eliminar-->
                                            <button type="button" @click="abrirModal('afiliado','registro_pago',afiliado)" class="btn btn-info btn-sm">
                                            <i class="icon-pencil"></i> Registrar Aporte
                                            </button> &nbsp;
                                        </td>
                                        <!--mostrar datos-->
                                        <td v-text="afiliado.apellido_paterno"></td>
                                        <td v-text="afiliado.apellido_materno"></td>
                                        <td v-text="afiliado.nombres"></td>
                                        <td v-text="afiliado.ci"></td>
                                        <td v-text="afiliado.codigounico"></td>
                                        <!--mostrar si esta activo o desactivado-->
                                        <td>
                                            <div v-if="afiliado.condicion">
                                                <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-else>
                                                <span class="badge badge-danger">Desactivado</span>
                                            </div>
                                        </td>
                                    </tr>                                
                                </tbody>
                            </table>
                            </div><!--fin table responsive-->
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item" v-if="pagination.current_page > 1">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                    </li>
                                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                    </li>
                                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                    </li>
                                </ul>
                            </nav>
                        </div><!--FIN Listado, Tabla de afiliados-->
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
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
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group border row">
                                    <div class="col-md-offset-2 col-md-9">
                                        <p><strong>Afiliado:</strong> {{ apellido_paterno }}&nbsp;{{ apellido_materno }} &nbsp; {{nombres}} </p> 
                                        <p> <strong>C.I:</strong>{{ci}} <strong> &nbsp; Carnet Colegio : </strong> {{codigounico}}  </p>
                                    </div>
                                    <div class="col-md-offset-2 col-md-9">
                                    <p><strong>Modalidad de Pago: </strong> {{ modalidad }}  &nbsp; <strong>Fecha de ingreso: </strong>{{ desde(fecha_modalidad) }}</p>
                                    <p> <strong>Pago hasta: </strong>{{ desde(ultimo_pago) }} </p>
                                    </div>

                                </div>
                                <div class="form-group border row">
                                    <label class="col-md-3 form-control-label" for="text-input">Numero de Meses (*)</label>
                                    <div class="col-md-3">
                                        <input type="number" v-model="num_meses" class="form-control" placeholder="00">                                                                             
                                    </div>
                                    <label class="col-md-3 form-control-label" for="text-input">Monto a Pagar</label>
                                    <div class="col-md-3">
                                        <strong> {{ monto_total =  num_meses * 20 }} Bolivianos </strong>                                     
                                    </div>
                                </div>
                                <div v-show="errorPago" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjPago" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPago()">Registrar Pago</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPago()">Actualizar Pago</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>


<script>
import moment from 'moment';
moment.locale('es');

    export default {
        data (){
            return {
                //datos del Afiliado
                afiliado_id: 0,
                apellido_paterno:'',
                apellido_materno:'',
                nombres:'',
                ci:'',
                codigounico:0,
                condicion: '',
                estado: '',

                modalidad:'',
                fecha_modalidad:'',
                ultimo_pago:'',

                //datos del pago
                num_meses:0,
                monto_total:0,
                //datos aplicacion                          
                arrayAfiliado : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorPago : 0,
                errorMostrarMsjPago : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'ci',
                buscar : ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {
            listarAfiliado (page,buscar,criterio){
                let me=this;
                var url= '/pagos?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayAfiliado = respuesta.afiliados.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarAfiliado(page,buscar,criterio);
            },

            registrarPago(){
                if (this.validarPago()){
                    return;
                }
                
                let me = this;

                axios.post('/pago/registrar',{
                    'afiliado_id':this.afiliado_id,                    
                    'num_meses':this.num_meses,
                    'monto_total':this.monto_total
                }).then(function (response) {
                    me.cerrarModal();

                    //me.listarPago(1,'','nombre');

                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarPago(){
               if (this.validarPago()){
                    return;
                }
                
                let me = this;

                axios.put('/pago/actualizar',{
                    'afiliado_id':this.afiliado_id,                    
                    'num_meses':this.num_meses,
                    'monto_total':this.monto_total
                }).then(function (response) {
                    me.cerrarModal();

                    //me.listarPago(1,'','nombre');

                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarPago(id){
               swal({
                title: 'Esta seguro de desactivar este artículo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/articulo/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarPago(1,'','nombre');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            activarPago(id){
               swal({
                title: 'Esta seguro de activar este artículo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/articulo/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarPago(1,'','nombre');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            validarPago(){
                this.errorPago=0;
                this.errorMostrarMsjPago =[];

                if (!this.num_meses) this.errorMostrarMsjPago.push("Debe introducir la cantidad de meses.");

                if (this.errorMostrarMsjPago.length) this.errorPago = 1;

                return this.errorPago;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.afiliado_id=0;//este ID jalamos del listado
                this.apellido_paterno='';
                this.apellido_materno='';
                this.nombres='';
                this.ci='';
                this.codigounico=0;

                this.modalidad='';
                this.fecha_modalidad='';
                this.ultimo_pago='',

                this.num_meses=0;
                this.monto_total=0;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "afiliado":
                    {
                        switch(accion){
                            case 'registro_pago':
                            {
                                this.modal=1;
                                this.tituloModal='Registrar Pago';
                                this.tipoAccion=1;

                                this.afiliado_id=data['id'];//este ID jalamos del listado
                                this.apellido_paterno=data['apellido_paterno'];
                                this.apellido_materno=data['apellido_materno'];
                                this.nombres=data['nombres'];
                                this.ci=data['ci'];
                                this.codigounico=data['codigounico'];

                                this.modalidad=data['modalidad'];
                                this.fecha_modalidad=data['fecha_modalidad'];
                                this.ultimo_pago=data['ultimo_pago'];

                                this.num_meses=0;
                                this.monto_total=0;
                                break;
                            }
                            //aun no estamos usando ACTUALIZAR
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Artículo';
                                this.tipoAccion=2;
                                this.articulo_id=data['id'];
                                this.idcategoria=data['idcategoria'];
                                this.codigo=data['codigo'];
                                this.nombre = data['nombre'];
                                this.stock=data['stock'];
                                this.precio_venta=data['precio_venta'];
                                this.descripcion= data['descripcion'];
                                break;
                            }
                        }
                    }
                }
            },

            desde(date){
                console.log(date);
                return moment(date).format("D MMMM YYYY");
            }
        },
        mounted() {
            this.listarAfiliado(1,this.buscar,this.criterio);
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
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

