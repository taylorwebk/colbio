<template>
            <main class="main">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
                <li class="breadcrumb-item"><a href="#" @click="ocultarFormulario()">Afiliados</a></li>
                <li v-if="listado==2" class="breadcrumb-item"><a href="#">Titulos</a></li>
                <li v-if="listado==3" class="breadcrumb-item"><a href="#">Perfil</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Afiliados             
                            <button v-if="listado==1" type="button" @click="mostrarFormulario()" class="btn btn-secondary">
                                <i class="icon-plus"></i>&nbsp;Nuevo
                            </button>
                    </div>
                    <!--Listado, Tabla de afiliados-->
                    <template v-if="listado==1">
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
                                        <input type="text" v-model="buscar" @keyup.enter="listarAfiliado(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarAfiliado(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr> 
                                        <th>Paterno</th>
                                        <th>Materno</th>
                                        <th>Nombres</th>
                                        <th>CI</th>
                                        <th>Carnet Colegio</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="afiliado in arrayAfiliado" :key="afiliado.id">
                                        <!--mostrar datos-->
                                        <td v-text="afiliado.apellido_paterno"></td>
                                        <td v-text="afiliado.apellido_materno"></td>
                                        <td v-text="afiliado.nombres"></td>
                                        <td v-text="afiliado.ci"></td>
                                        <td v-text="afiliado.codigounico"></td>
                                        <!--mostrar si esta activo o desactivado-->
                                        <td>
                                            <div v-if="afiliado.condicion==1">
                                                <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-else>
                                                <span class="badge badge-danger">Desactivado</span>
                                            </div>
                                            
                                        </td>
                                        <td><!--botones actualizar, eliminar-->
                                            <button type="button" @click="mostrarTitulos(afiliado)" class="btn btn-info btn-sm">
                                                <i class="icon-graduation"></i>
                                            </button>
                                            <button type="button"  @click="mostrarFormularioModificar(afiliado)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil"></i>
                                            </button> 
                                            <template v-if="afiliado.condicion==0">
                                                <button type="button" class="btn btn-success btn-sm" @click="modificarEstado(afiliado,4)">
                                                    <i class="icon-arrow-up-circle"></i>
                                                </button>
                                            </template>
                                            <template v-if="afiliado.condicion==1">
                                                <button type="button" class="btn btn-danger btn-sm" @click="modificarEstado(afiliado,3)">
                                                    <i class="icon-arrow-down-circle"></i>
                                                </button>
                                            </template>
                                            <button type="button" @click="mostrarPerfil(afiliado)" class="btn btn-secondary btn-sm">
                                                <i class="icon-user"></i>
                                            </button> 
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
                    </template>
                    <!--Componente para añadir titulos-->
                    <template v-if="listado==2">
                        <div class="card-body">
                                <titulos :mensaje="afiliado_id"></titulos>        
                        </div><!-- FIN Formulario-->
                    </template>
                    <template v-if="listado==3">
                        <div class="card-body">
                                <perfil :mensaje="afiliado_id"></perfil>
                                <button type="button" @click="ocultarFormulario()" class="btn btn-secondary">Cerrar</button>
                        </div><!-- FIN Formulario-->
                    </template>
                    <!--Formulario, anñadir Mod de afiliados-->
                    <template v-if="listado==0">
                        <div class="card-body">
                            <div class="form-group row border">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Paterno(*)</label>
                                        <input type="text" class="form-control" v-model="apellido_paterno">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Materno(*)</label>
                                        <input type="text" class="form-control" v-model="apellido_materno">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Nombres(*)</label>
                                        <input type="text" class="form-control" v-model="nombres">
                                    </div>
                                </div>
                                <!--nueva linea-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Fecha de Nacimiento(*)</label>
                                        <input type="date" class="form-control" v-model="fecha_nac">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Lugar de Nacimiento</label>
                                        <input type="text" class="form-control" v-model="lugar_nac">
                                    </div>
                                </div>
                                <!--nueva linea-->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">CI (*)</label>
                                        <input type="text" class="form-control" v-model="ci">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Expedido</label>
                                        <select class="form-control" v-model="departamento">
                                            <option value="LP">La Paz (LP)</option>
                                            <option value="CB">Cochabamba (CB)</option>
                                            <option value="SC">Santa Cruz (SC)</option>
                                            <option value="PT">Potosi (PT)</option>
                                            <option value="OR">Oruro (OR)</option>
                                            <option value="CQ">Chuquisaca (CQ)</option>
                                            <option value="TJ">Tarija (TJ)</option>
                                            <option value="BN">Beni (BN)</option>
                                            <option value="PD">Pando (PD)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Nacionalidad</label>
                                        <input type="text" class="form-control" v-model="nacionalidad">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Estado Civil</label>
                                        <select class="form-control" v-model="estado_civil">
                                            <option value="Soltero(a)">Soltero(a)</option>
                                            <option value="Casado(a)">Casado(a)</option>
                                            <option value="Divorciado(a)">Divorciado(a)</option>
                                            <option value="Viudo(a)">Viudo(a)</option>
                                        </select>
                                    </div>
                                </div>
                                <!--nueva linea-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Telefono</label>
                                        <input type="text" class="form-control" v-model="telefono">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Celular</label>
                                        <input type="text" class="form-control" v-model="celular">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">E-mail</label>
                                        <input type="text" class="form-control" v-model="email">
                                    </div>
                                </div>
                                <!--nueva linea-->
                            </div>
                            <div class="form-group row border">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Fecha, Registro Min. Salud y Deportes</label>
                                        <input type="date" class="form-control" v-model="fecha_min_salud">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Numero de Registro Matricula</label>
                                        <input type="text" class="form-control" v-model="matricula">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row border">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Lugar de Trabajo</label>
                                        <input type="text" class="form-control" v-model="lugar_trabajo">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Dirección</label>
                                        <input type="text" class="form-control" v-model="direccion_trabajo">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row border">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Modalidad de Ingreso</label>
                                        <select class="form-control" v-model="modalidad">
                                            <option value="NUEVO">NUEVO</option>
                                            <option value="TRASPASO">TRASPASO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Fecha de Inicio de Pago</label>
                                        <input type="date" class="form-control" v-model="fecha_modalidad">
                                        <small>Fecha de Inicio de los pagos de aportes</small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Carnet Colegio</label>
                                        <input type="text" class="form-control" v-model="codigounico">
                                        <small>Numero de Carnet de Afiliado Colegio de Biquimica y Farmacia</small>
                                    </div>
                                </div>
                            </div>
                            <!--formulario USER para su respectivo Login-->
                            <div class="form-group row border">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Usuario</label>
                                        <input type="text" class="form-control" v-model="codigounico" placeholder="Nombre de Usuario (Carnet de Afiliado)" disabled>
                                        <small>Nombre de Usuario</small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Contraseña </label>
                                        <input type="text" class="form-control" v-model="ci" placeholder="Password de acceso (Cedula de Identidad)" disabled>
                                        <small>Contraseña de Acceso </small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Rol </label>
                                        <select class="form-control" v-model="idrol">
                                            <option value="0">Seleccione un rol</option>
                                            <option v-for="rol in arrayRol" :key="rol.id" :value="rol.id" v-text="rol.nombre" >
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div v-show="errorAfiliado" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjAfiliado" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <button type="button" @click="ocultarFormulario()" class="btn btn-secondary">Cerrar</button>
                                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarAfiliado()">Registrar Afiliado</button>
                                    <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="actualizarAfiliado()">Actualizar</button>
                                </div>
                            </div>
                        </div><!-- FIN Formulario-->
                    </template>
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
                                        <p> <strong>C.I:</strong>{{ci}} <strong> &nbsp; Carnet Colegio </strong> {{codigounico}}  </p>
                                    </div>
                                    <div class="col-md-offset-2 col-md-9">
                                    <p><strong>Modalidad de Pago: </strong> {{ modalidad }}  &nbsp; <strong>Fecha de ingreso: </strong>{{ desde(fecha_modalidad) }}</p>
                                    <p> <strong>Pago hasta: </strong>{{ desde(fecha_ultimo_pago) }}</p>
                                    </div>
                                </div>

                                <div v-if="tipoAccion==3" class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input"> Seleccione Motivo </label>

                                    <select class="col-md-3" v-model="motivo">
                                        <option value="TRASPASO">TRASPASO</option>   
                                        <option value="JUBILACION">JUBILACION</option>
                                        <option value="MUERTE">MUERTE</option>
                                        <option value="OTROS">OTROS</option>
                                        
                                    </select>

                                    <label class="col-md-2 form-control-label" for="text-input">En Fecha </label>
                                    <input type="date" class="form-control col-md-3" v-model="fecha_motivo">
                                </div>
                                <div v-else  class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input"> Modalidad de Ingreso </label>

                                    <input type="text" class="form-control col-md-3" v-model="modalidad" disabled>

                                    <label class="col-md-2 form-control-label" for="text-input">En Fecha </label>
                                    <input type="date" class="form-control col-md-3" v-model="fecha_motivo">
                                </div>
                                
                                <div v-show="errorAfiliado" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjAfiliado" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" @click="ocultarFormulario()" class="btn btn-secondary">Cerrar</button>
                            <button type="button" v-if="tipoAccion==3" class="btn btn-danger" @click="registrarBaja()">Deshabilitar</button>
                            <button type="button" v-if="tipoAccion==4" class="btn btn-primary" @click="registrarAlta()">Habilitar</button>
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

import moment,{ months } from 'moment';
moment.locale('es');

import Titulos from './Titulos.vue'
import Perfil from './Perfil.vue'


    export default {
        components: {
            Titulos,
            Perfil
        },

        data (){
            return {
                afiliado_id: 0,

                apellido_paterno:'',
                apellido_materno:'',
                nombres:'',
                fecha_nac:'',
                lugar_nac:'',
                ci:'',
                departamento:'',
                nacionalidad:'',
                estado_civil:'',
                telefono:'',
                celular:'',
                email:'',
                fecha_min_salud:'',
                matricula:'',
                lugar_trabajo:'',
                direccion_trabajo:'',
                modalidad:'',
                fecha_modalidad:'',
                codigounico:0,

                fecha_ultimo_pago:'',
                motivo:'',
                fecha_motivo:'',

                condicion: '',
                estado: '',              
                arrayAfiliado : [],
                listado:1,//para ocultar o mostrar formulario tabla

                usuario : '',
                password : '',
                idrol : 0,
                arrayRol : [],

                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorAfiliado : 0,
                errorMostrarMsjAfiliado : [],
                pagination:{
                    'total':0,
                    'current_page':0,
                    'per_page':0,
                    'last_page':0,
                    'from':0,
                    'to':0,
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
                var url= '/afiliado?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
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
            registrarAfiliado(){
                if (this.validarAfiliado()){return;}

                this.usuario=this.codigounico;
                this.password=this.ci;

                let me = this;
                axios.post('/afiliado/registrar',{
                    'apellido_paterno':this.apellido_paterno,
                    'apellido_materno':this.apellido_materno,
                    'nombres':this.nombres,
                    'fecha_nac':this.fecha_nac,
                    'lugar_nac':this.lugar_nac,
                    'ci':this.ci,
                    'departamento':this.departamento,
                    'nacionalidad':this.nacionalidad,
                    'estado_civil':this.estado_civil,
                    'telefono':this.telefono,
                    'celular':this.celular,
                    'email':this.email,

                    'fecha_min_salud':this.fecha_min_salud,
                    'matricula':this.matricula,
                    'lugar_trabajo':this.lugar_trabajo,
                    'direccion_trabajo':this.direccion_trabajo,
                    'modalidad':this.modalidad,
                    'fecha_modalidad':this.fecha_modalidad,
                    'codigounico':this.codigounico,

                    'usuario': this.usuario,
                    'password': this.password,
                    'idrol' : this.idrol

                }).then(function (response) {
                    me.ocultarFormulario();
                    me.listarAfiliado(1,'','nombres');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarAfiliado(){
               if (this.validarAfiliado()){
                    return;
                }
                let me = this;
                axios.put('/afiliado/actualizar',{
                    'id': this.afiliado_id,
                    'apellido_paterno':this.apellido_paterno,
                    'apellido_materno':this.apellido_materno,
                    'nombres':this.nombres,
                    'fecha_nac':this.fecha_nac,
                    'lugar_nac':this.lugar_nac,
                    'ci':this.ci,
                    'departamento':this.departamento,
                    'nacionalidad':this.nacionalidad,
                    'estado_civil':this.estado_civil,
                    'telefono':this.telefono,
                    'celular':this.celular,
                    'email':this.email,

                    'fecha_min_salud':this.fecha_min_salud,
                    'matricula':this.matricula,
                    'lugar_trabajo':this.lugar_trabajo,
                    'direccion_trabajo':this.direccion_trabajo,
                    'modalidad':this.modalidad,
                    'fecha_modalidad':this.fecha_modalidad,
                    'codigounico':this.codigounico,

                    'usuario': this.usuario,
                    'password': this.password,
                    'idrol' : this.idrol

                }).then(function (response) {
                    me.ocultarFormulario();
                    me.listarAfiliado(1,'','nombres');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            modificarEstado(data=[],accion){
                this.modal = 1;
                this.tipoAccion = accion;
                if(accion==3)
                     this.tituloModal = 'Deshabilitar Afiliado';
                else
                     this.tituloModal = 'Habilitar Afiliado';

                //cargamos el afiliado
                this.afiliado_id=data["id"],
                this.apellido_paterno=data["apellido_paterno"],
                this.apellido_materno=data["apellido_materno"],
                this.nombres=data["nombres"],
                this.ci=data["ci"],
                this.codigounico=data["codigounico"],
                this.modalidad=data["modalidad"],
                this.fecha_modalidad=data["fecha_modalidad"],
                //fecha_ultimo_pago  se carga con funcion
                this.cargarUltimoPago(this.afiliado_id)

            },

            registrarBaja(){
               if (this.validarEstado()){return;}
                let me = this;
                axios.put('/afiliado/deshabilitar',{
                    'id': this.afiliado_id,
                    'motivo':this.motivo,
                    'fecha_motivo':this.fecha_motivo,
                }).then(function (response) {
                    me.ocultarFormulario();
                    me.listarAfiliado(1,'','nombres');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },

            registrarAlta(){
               if (this.validarEstado()){return;}
                let me = this;
                axios.put('/afiliado/habilitar',{
                    'id': me.afiliado_id,
                    'motivo':me.modalidad,
                    'fecha_motivo':me.fecha_motivo,
                }).then(function (response) {
                    me.ocultarFormulario();
                    me.listarAfiliado(1,'','nombres');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },

            cargarUltimoPago(id){
                let me = this;
                var url= '/Aporte/ultimoPago?id=' + id ;
                //listamos afiliados segun esta ruta
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.fecha_ultimo_pago = respuesta.pago.fecha_vencimiento;
                })
                .catch(function (error) {
                    //console.log(error);
                    //si el afiliado es nuevo ... 
                    me.fecha_ultimo_pago = me.fecha_modalidad;
                });
            },

            validarAfiliado(){
                this.errorAfiliado=0;
                this.errorMostrarMsjAfiliado =[];

                if(!this.apellido_paterno) this.errorMostrarMsjAfiliado.push('El Campo Apellido Paterno no puede estar Vació');
                if(!this.apellido_materno) this.errorMostrarMsjAfiliado.push('El Campo Apellido Materno no puede estar Vació');
                if(!this.nombres) this.errorMostrarMsjAfiliado.push('El Campo Nombres no puede estar Vació');
                if(!this.fecha_nac) this.errorMostrarMsjAfiliado.push('El Campo Fecha de Nacimiento no puede estar Vació');
                if(!this.lugar_nac) this.errorMostrarMsjAfiliado.push('El Campo Lugar de Nacimiento no puede estar Vació');
                if(!this.ci) this.errorMostrarMsjAfiliado.push('El Campo C.I no puede estar Vació');
                if(!this.departamento) this.errorMostrarMsjAfiliado.push('El Campo Departamento no puede estar Vació');
                if(!this.nacionalidad) this.errorMostrarMsjAfiliado.push('El Campo Nacionalidad no puede estar Vació');
                if(!this.estado_civil) this.errorMostrarMsjAfiliado.push('El Campo Estado Civil no puede estar Vació');
                if(!this.fecha_min_salud) this.errorMostrarMsjAfiliado.push('Introducir la Fecha de Registro Min. Salud no puede estar Vació');
                if(!this.matricula) this.errorMostrarMsjAfiliado.push('El Campo Registro de Matricula no puede estar Vació');
                if(!this.lugar_trabajo) this.errorMostrarMsjAfiliado.push('El Lugar de Trabajo no puede estar Vació');
                if(!this.direccion_trabajo) this.errorMostrarMsjAfiliado.push('La Dirección de Trabajo no puede estar Vació');
                if(!this.modalidad) this.errorMostrarMsjAfiliado.push('El Campo Modalidad de Pago no puede estar Vació');
                if(!this.fecha_modalidad) this.errorMostrarMsjAfiliado.push('La Fecha de Ingreso no puede estar Vació');
                if(!this.codigounico) this.errorMostrarMsjAfiliado.push('Introducior el Carnet Colegio');

                if (this.errorMostrarMsjAfiliado.length) this.errorAfiliado = 1;

                return this.errorAfiliado;
            },
            
            validarEstado(){
                this.errorAfiliado=0;
                this.errorMostrarMsjAfiliado =[];
                if (!this.fecha_motivo) this.errorMostrarMsjAfiliado.push("Introducir una fecha Valida");
                if (this.errorMostrarMsjAfiliado.length) this.errorAfiliado = 1;
                return this.errorAfiliado;
            },
            mostrarFormulario(){
                //nuevo registro
                this.selectRol();//cargamos los Roles

                this.apellido_paterno='';
                this.apellido_materno='';
                this.nombres='';
                this.fecha_nac='';
                this.lugar_nac='';
                this.ci='';
                this.departamento='';
                this.nacionalidad='BOLIVIANA';
                this.estado_civil='';
                this.telefono='';
                this.celular='';
                this.email='';
                this.fecha_min_salud='';
                this.matricula='';
                this.lugar_trabajo='';
                this.direccion_trabajo='';
                this.modalidad='';
                this.fecha_modalidad='';
                this.codigounico=0;

                this.usuario='';
                this.password='';
                this.idrol=2;

                this.listado=0;
                this.tipoAccion=1;

            },
            mostrarTitulos(data = []){
                this.listado = 2;
                this.afiliado_id=data['id'];
            },
            mostrarPerfil(data = []){
                this.listado = 3;
                this.afiliado_id=data['id'];
            },
            mostrarFormularioModificar(data = []){
                
                //this.tituloModal='Actualizar afiliado ';
                this.selectRol();//cargamos los Roles

                this.listado=0;
                this.tipoAccion=2;

                this.afiliado_id=data['id'];
                this.apellido_paterno=data['apellido_paterno'];
                this.apellido_materno=data['apellido_materno'];
                this.nombres=data['nombres'];
                this.fecha_nac=data['fecha_nac'];
                this.lugar_nac=data['lugar_nac'];
                this.ci=data['ci'];
                this.departamento=data['departamento'];
                this.nacionalidad=data['nacionalidad'];
                this.estado_civil=data['estado_civil'];
                this.telefono=data['telefono'];
                this.celular=data['celular'];
                this.email=data['email'];

                this.fecha_min_salud=data['fecha_min_salud'];
                this.matricula=data['matricula'];
                this.lugar_trabajo=data['lugar_trabajo'];
                this.direccion_trabajo=data['direccion_trabajo'];
                this.modalidad=data['modalidad'];
                this.fecha_modalidad=data['fecha_modalidad'];
                this.codigounico=data['codigounico'];

                this.usuario = data['usuario'];
                this.password = data['password'];
                this.idrol = data['idrol'];
            },            
            ocultarFormulario(){
                this.listado=1;
                this.afiliado_id= 0;
                this.apellido_paterno='';
                this.apellido_materno='';
                this.nombres='';
                this.fecha_nac='';
                this.lugar_nac='';
                this.ci='';
                this.departamento='';
                this.nacionalidad='';
                this.estado_civil='';
                this.telefono='';
                this.celular='';
                this.email='';
                this.fecha_min_salud='';
                this.matricula='';
                this.lugar_trabajo='';
                this.direccion_trabajo='';
                this.modalidad='';
                this.fecha_modalidad='';
                this.codigounico=0;
                this.condicion='';
                this.estado='';
                this.motivo='';
                this.fecha_motivo ='';
                
                this.errorAfiliado = 0;
                this.errorMostrarMsjAfiliado = [];

                this.usuario='';
                this.password='';
                this.idrol=0;

                this.cerrarModal();
            },

            //metodos de Roles Usuario
            selectRol(){
                let me=this;
                var url= '/rol/selectRol';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayRol = respuesta.roles;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },



            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
            },

            desde(date){
                return moment(date).format("D MMMM YYYY");
            },


            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "afiliado":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registro de Titulo Academico';
                                this.afiliado_id= data['id'];

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
                    }
                }
            }
        },
        mounted() {
            this.listarAfiliado(1,this.buscar,this.criterio);
        }
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
