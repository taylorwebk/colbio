<template>
        <div>
            <div class="card-body">
                <div class="form-group border row">
                    <div class="col-md-offset-3 col-md-9">
                        <p><strong>Afiliado : </strong> {{ apellido_paterno }}&nbsp;{{ apellido_materno }} &nbsp; {{nombres}} &nbsp; <strong>C.I : </strong>{{ci}}  </p> 
                    </div>
                    <div class="col-md-offset-3 col-md-9">
                        <p><strong>Modalidad de Pago : </strong> {{ modalidad }}&nbsp;<strong>Fecha de ingreso : </strong>{{ desde(fecha_modalidad) }}</p>
                    </div>
                </div>
                <!-- modal = 0 mostrar listado -->
                <template v-if="modal==0">
                    <div class="form-group row">
                        <div class="col-md-10">
                            <div class="input-group">
                                <button type="button"  @click="ocultarListado('registrarTitulo')" class="btn btn-info">
                                    <i class="icon-plus"></i>&nbsp;Agregar Titulo
                                </button>
                                &nbsp;
                                <button type="button" @click="ocultarListado('registrarEspecialidad')" class="btn btn-success">
                                    <i class="icon-plus"></i>&nbsp;Agregar Especialidad
                                </button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Universidad</th>
                                <th>Titulo / Especialidad</th>
                                <th>Grado Academico</th>
                                <th>Fecha</th>
                                <th>Ciudad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="titulo in arrayTitulos" :key="titulo.id">
                                <td><!--botones actualizar, eliminar-->
                                    <button type="button" @click="ocultarListado('mostrar',titulo)" class="btn btn-info btn-sm">
                                        <i class="icon-eye"></i>
                                    </button>
                                    <button type="button" @click="ocultarListado('modificar',titulo)"  class="btn btn-warning btn-sm">
                                        <i class="icon-pencil"></i>
                                    </button>
                                    <button type="button" @click="eliminarTitulo(titulo.id)" class="btn btn-danger btn-sm">
                                        <i class="icon-trash"></i>
                                    </button> &nbsp;
                                </td>
                                <!-- mostrar datos -->
                                <td v-text="titulo.universidad"></td>
                                <td v-text="titulo.nombre_titulo"></td>
                                <td v-text="titulo.grado"></td>
                                <td v-text="desde(titulo.fecha_titulo)"></td>
                                <td v-text="titulo.ciudad"></td>
                            </tr>
                        </tbody>
                    </table>
                </template>
                <!-- modal = 1 mostrar titulo -->
                <template v-if="modal==1">
                    <h4>{{tituloModal}} </h4> <br>
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Universidad </label>
                            <div class="col-md-3">
                                <input type="text" v-model="universidad" class="form-control" placeholder="Nombre de la Universidad">
                            </div>
                            <template v-if="tipo=='titulo'">
                                <label class="col-md-3 form-control-label" for="email-input">Titulo </label>
                                <div class="col-md-3">
                                    <select class="form-control" v-model="nombre_titulo">
                                        <option value="Químico Farmaceutico">Químico Farmaceutico</option>
                                        <option value="Bioquímico">Bioquímico</option>
                                        <option value="Bioquímico-Farmacéutico">Bioquímico-Farmacéutico</option>
                                        <option value="Farmacéutico">Farmacéutico</option>
                                    </select>
                                </div>
                            </template>
                            <template v-else>
                                <label class="col-md-3 form-control-label" for="email-input">Especialidad </label>
                                <div class="col-md-3">
                                    <input type="text" v-model="nombre_titulo" class="form-control" placeholder="Especialidad en :">
                                </div>
                            </template>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Fecha </label>
                            <div class="col-md-3">
                                <input type="date" v-model="fecha_titulo" class="form-control">
                            </div>

                            <label class="col-md-3 form-control-label" for="text-input">Numero </label>
                            <div class="col-md-3">
                                <input type="number" v-model="numero_titulo" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Ciudad </label>
                            <div class="col-md-3">
                                <input type="text" v-model="ciudad" class="form-control">
                            </div>
                            <label class="col-md-3 form-control-label" for="text-input">Pais </label>
                            <div class="col-md-3">
                                <input type="text" v-model="pais" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row" v-if="tipo=='titulo'">
                            <label class="col-md-3 form-control-label" for="text-input">Fecha Provision Nacional </label>
                            <div class="col-md-3">
                                <input type="date" v-model="fecha_prov" class="form-control">
                            </div>

                            <label class="col-md-3 form-control-label" for="text-input">Numero Provision Nacional </label>
                            <div class="col-md-3">
                                <input type="number" v-model="numero_prov" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row" v-if="tipo=='especialidad'">
                            <label class="col-md-3 form-control-label" for="text-input">Grado Academico</label>
                            <div class="col-md-3">
                                <select class="form-control" v-model="grado">
                                    <option value="DIPLOMADO">DIPLOMADO</option>
                                    <option value="ESPECIALIDAD">ESPECIALIDAD</option>
                                    <option value="MAESTRÍA">MAESTRÍA</option>
                                    <option value="DOCTORADO">DOCTORADO</option>
                                    <option value="POST-DOCTORADO">POST-DOCTORADO</option>
                                </select>
                            </div>
                        </div>

                        <div v-show="errorTitulo" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjTitulo" :key="error" v-text="error">
                                </div>
                            </div>
                        </div>
                    </form>
                    <button type="button" class="btn btn-secondary" @click="cerrarModal">Cerrar</button>
                    <button type="button" class="btn btn-primary" v-if="tipoAccion==1" @click="registrarTitulo()">Guardar</button>
                    <button type="button" class="btn btn-warning" v-if="tipoAccion==2" @click="actualizarTitulo()">Actualizar</button>
                </template>
                <template v-if="modal==2">

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th colspan="2">Grado Academico</th>
                                <td colspan="2" v-text="grado"></td>
                            </tr>
                            <tr>
                                <th>Universidad</th>
                                <td v-text="universidad"></td>
                                <th>Titulo / Especialidad</th>
                                <td v-text="nombre_titulo"></td>
                            </tr>
                            <tr>
                                <th>Fecha</th>
                                <td v-text="fecha_titulo"></td>
                                <th>Numero</th>
                                <td v-text="numero_titulo"></td>
                            </tr>
                            <tr>
                                <th>Ciudad</th>
                                <td v-text="ciudad"></td>
                                <th>Pais</th>
                                <td v-text="pais"></td>
                            </tr>
                            <tr v-if="grado=='LICENCIATURA'">
                                <th>Fecha, Provisión Nacional</th>
                                <td v-text="fecha_prov"></td>
                                <th>Numero, Provisión Nacional</th>
                                <td v-text="numero_prov"></td>
                            </tr>                 
                        </table>
                    </div>
                    <button type="button" class="btn btn-secondary" @click="cerrarModal">Cerrar</button>
                </template>
            </div>
        </div>
</template>

<script>
import moment from 'moment';
moment.locale('es');

    export default {
        data(){
            return {
                afiliado_id:0,
                nombre:'',
                descripcion:'',

                apellido_paterno:'',
                apellido_materno:'',
                nombres:'',
                ci:'',
                modalidad:'',
                fecha_modalidad:'',

                arrayTitulos:[],
                titulo_id:0,

                universidad:'',
                nombre_titulo:'',
                fecha_titulo:'',
                numero_titulo:0,
                ciudad:'',
                pais:'',
                fecha_prov:'',
                numero_prov:0,
                url_img:'prueba',
                tipo:'',
                grado:'',

                arrayTitulo:[],
                modal : 0,
                //modal para ocultar o mostrar el mismo
                tituloModal : '',
                tipoAccion:0,
                errorTitulo:0,
                errorMostrarMsjTitulo:[],

                offset:3,

            }
        },

        methods:{
        listarTitulos (id){
                let me=this;
                var url= '/titulos?id='+id;
                axios.get(url).then(function (response) {
                    me.apellido_paterno=response.data.afiliado[0].apellido_paterno;
                    me.apellido_materno=response.data.afiliado[0].apellido_materno;
                    me.nombres=response.data.afiliado[0].nombres;
                    me.ci=response.data.afiliado[0].ci;
                    me.modalidad=response.data.afiliado[0].modalidad;
                    me.fecha_modalidad=response.data.afiliado[0].fecha_modalidad;

                    me.arrayTitulos=response.data.titulos;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        registrarTitulo(){
            if(this.validarTitulo()){return;}
            let me = this;
            axios.post('/titulos/registrar',{
                    'afiliado_id':this.afiliado_id,
                    'universidad':this.universidad,
                    'nombre_titulo':this.nombre_titulo,
                    'fecha_titulo':this.fecha_titulo,
                    'numero_titulo':this.numero_titulo,
                    'ciudad':this.ciudad,
                    'pais':this.pais,
                    'fecha_prov':this.fecha_prov,
                    'numero_prov':this.numero_prov,
                    'url_img':this.url_img,
                    'tipo':this.tipo,
                    'grado':this.grado,
                })
            .then(function(response){
                me.listarTitulos(me.afiliado_id);
                me.cerrarModal();
            }).catch(function(error){
                console.log(error);
            });//fin axios
        },

        actualizarTitulo(){
            if(this.validarTitulo()){return;}
            let me = this;
            axios.post('/titulos/actualizar',{
                    'id':this.titulo_id,
                    'universidad':this.universidad,
                    'nombre_titulo':this.nombre_titulo,
                    'fecha_titulo':this.fecha_titulo,
                    'numero_titulo':this.numero_titulo,
                    'ciudad':this.ciudad,
                    'pais':this.pais,
                    'fecha_prov':this.fecha_prov,
                    'numero_prov':this.numero_prov,
                    'url_img':this.url_img,
                    'tipo':this.tipo,
                    'grado':this.grado,
                })
            .then(function(response){
                me.listarTitulos(me.afiliado_id);
                me.cerrarModal();
            }).catch(function(error){
                console.log(error);
            });//fin axios
        },
        eliminarTitulo(id){
            //if(this.validarTitulo()){return;}
            let me = this;
            axios.post('/titulos/eliminar',{
                    'id':id,
                })
            .then(function(response){
                me.listarTitulos(me.afiliado_id);
                me.cerrarModal();
            }).catch(function(error){
                console.log(error);
            });//fin axios
        },
        
        ocultarListado(accion,data=[]){
            switch(accion){
                case 'registrarTitulo':
                {
                    //ACCION = REGISTRAR
                    this.tituloModal='Registrar Titulo';
                    this.modal=1;

                    this.universidad='';
                    this.nombre_titulo='';
                    this.fecha_titulo='';
                    this.numero_titulo=0;
                    this.ciudad='';
                    this.pais='BOLIVIA';

                    this.fecha_prov='';
                    this.numero_prov=0;

                    this.tipo='titulo';
                    this.grado='LICENCIATURA';
                    this.url_img='prueba';

                    this.tipoAccion=1;//para mostrar boton agregar
                    break;
                }
                case 'registrarEspecialidad':
                {
                    //ACCION = REGISTRAR
                    this.tituloModal='Registrar Especialidad';
                    this.modal=1;
                    this.tipoAccion=1;//para mostrar boton agregar

                    this.universidad='';
                    this.nombre_titulo='';
                    this.fecha_titulo='';
                    this.numero_titulo=0;
                    this.ciudad='';
                    this.pais='BOLIVIA';

                    this.fecha_prov='';
                    this.numero_prov=0;

                    this.tipo='especialidad';
                    this.grado='';

                    this.url_img='prueba';
                    
                    break;
                }
                case 'modificar':
                {
                    //vamos a usar un solo Case para titulos y especialidades
                    this.tituloModal='Actualizar Datos Acadmicos';
                    this.modal=1;
                    this.tipoAccion=2;//para mostrar boton Acualizar
                    this.titulo_id = data['id'];
                    this.universidad=data['universidad'];
                    this.nombre_titulo=data['nombre_titulo'];
                    this.fecha_titulo=data['fecha_titulo'];
                    this.numero_titulo=data['numero_titulo'];
                    this.ciudad=data['ciudad'];
                    this.pais=data['pais'];
                    this.fecha_prov=data['fecha_prov'];
                    this.numero_prov=data['numero_prov'];
                    this.tipo=data['tipo'];
                    
                    this.grado=data['grado'];
                    
                    if(data['grado']=='LICENCIATURA'){
                        this.tipo='titulo';
                    }
                    else{
                        this.tipo='especialidad';
                    }
                    break;
                }
                case 'mostrar':
                {
                    this.tituloModal='Detalles de Titulo / Especialidad';
                    this.modal=2;
                    this.tipoAccion=3;//para No mostrar boton 
                    this.titulo_id = data['id'];
                    this.universidad=data['universidad'];
                    this.nombre_titulo=data['nombre_titulo'];
                    this.fecha_titulo=data['fecha_titulo'];
                    this.numero_titulo=data['numero_titulo'];
                    this.ciudad=data['ciudad'];
                    this.pais=data['pais'];
                    this.fecha_prov=data['fecha_prov'];
                    this.numero_prov=data['numero_prov'];
                    this.tipo=data['tipo'];

                    this.grado=data['grado'];
                    
                    if(data['grado']=='LICENCIATURA'){
                        this.tipo='titulo';
                    }
                    else{
                        this.tipo='especialidad';
                    }

                    break;
                }
            }
        },

        validarTitulo(){
            this.errorTitulo=0;
            this.errorMostrarMsjTitulo=[];

            if(!this.universidad) this.errorMostrarMsjTitulo.push("El Campo Universidad no puede estar vació");
            if(!this.nombre_titulo) this.errorMostrarMsjTitulo.push("Introducir el Título o Especialidad ");
            if(!this.fecha_titulo) this.errorMostrarMsjTitulo.push("El Campo Fecha no puede estar vació");
            if(!this.numero_titulo) this.errorMostrarMsjTitulo.push("El Numero de Titulo no puede estar vació");
            if(!this.ciudad) this.errorMostrarMsjTitulo.push("El Campo Ciudad no puede estar vació");
            if(!this.pais) this.errorMostrarMsjTitulo.push("El Campo Pais no puede estar vació");
            
            if(this.tipo=='especialidad') {
                if(!this.grado) this.errorMostrarMsjTitulo.push("Seleccione el Grado Academico");
            }
            else {
                if(!this.fecha_prov) this.errorMostrarMsjTitulo.push("Introducir la Fecha en Provisión Nacional ");
                if(!this.numero_prov) this.errorMostrarMsjTitulo.push("El Numero Provision Nacional no puede estar vació");
            }

            if(this.errorMostrarMsjTitulo.length) this.errorTitulo=1;
            return this.errorTitulo;
        },
        cerrarModal(){
            this.modal=0;
            this.titulo_id='';
            this.tituloModal='';
            this.universidad='';
            this.nombre_titulo='';
            this.fecha_titulo='';
            this.numero_titulo=0;
            this.ciudad='';
            this.pais='';
            this.fecha_prov='';
            this.numero_prov=0;
            this.tipo='';
            this.errorMostrarMsjTitulo=[];
            this.errorTitulo=0;
        },
        desde(date){
            return moment(date).format("D MMMM YYYY");
        }
    },

    
    mounted() {
    this.listado=1;
    this.afiliado_id = this.mensaje;//asignamos el iddonante
    this.listarTitulos(this.afiliado_id);
    },

    props: ['mensaje'] //como mensaje nos viene el id
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
        color:red !important;
        font-weight: bold;
    }
</style>

