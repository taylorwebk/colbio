<!DOCTYPE html>
<html lang="en">
<head>

    <title>Perfil</title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.875rem;
            font-weight: normal;
            line-height: 1.5;
            color: #151b1e;           
        }
        .table {
            display: table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }
        .table-bordered {
            border: 1px solid #c2cfd6;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #c2cfd6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #c2cfd6;
        }
        .table-bordered thead th, .table-bordered thead td {
            border-bottom-width: 2px;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #c2cfd6;
        }
        th, td {
            display: table-cell;
            vertical-align: inherit;
        }
        th {
            font-weight: bold;
            text-align: -internal-center;
            text-align: left;
        }
        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .izquierda{
            float:left;
        }
        .derecha{
            float:right;
        }
    </style>
    
</head>
<body>
    <div>
        <h3>Perfil de Afiliado</h3>
    </div>
    <table class="table table-bordered" >
        <tr>
            <th>Apellido Paterno</th>
            <td> {{$afiliado->apellido_paterno}} </td>
            <th>Apellido Materno</th>
            <td> {{$afiliado->apellido_materno}} </td>
        </tr>
        <tr>
            <th>Nombres</th>
            <td> {{$afiliado->nombres}} </td>
            <th>Fecha de Nacimiento</th>
            <td> {{$afiliado->fecha_nac}} </td>
        </tr>
        <tr>
            <th>Lugar de Nacimiento</th>
            <td> {{$afiliado->lugar_nac}} </td>
            <th>Estado Civil</th>
            <td> {{$afiliado->estado_civil}} </td>
        </tr>
        <tr>
            <th>C.I</th>
            <td> {{$afiliado->ci}} </td>
            <th>Expedido</th>
            <td> {{$afiliado->departamento}} </td>
        </tr>
        <tr>
            <th>Nacionalidad</th>
            <td> {{$afiliado->nacionalidad}} </td>
            <th>Telefono</th>
            <td> {{$afiliado->telefono}} </td>
        </tr>
        <tr>
            <th>Celular</th>
            <td> {{$afiliado->celular}} </td>
            <th>E-mail</th>
            <td> {{$afiliado->email}} </td>
        </tr>
        <tr>
            <th>Fecha, Registro Min. Salud y Deportes</th>
            <td> {{$afiliado->fecha_min_salud}} </td>
            <th>Numero de Registro Matricula</th>
            <td> {{$afiliado->matricula}} </td>
        </tr>
        <tr>
            <th>Lugar de Trabajo</th>
            <td> {{$afiliado->lugar_trabajo}} </td>
            <th>Dirección</th>
            <td> {{$afiliado->direccion_trabajo}} </td>
        </tr>
        <tr>
            <th>Modalidad de Ingreso</th>
            <td> {{$afiliado->modalidad}} </td>
            <th>Fecha de Inicio de Pago</th>
            <td> {{$afiliado->fecha_modalidad}} </td>
        </tr>
        <tr>
            <th>Codigo Unico </th>
            <td> {{$afiliado->codigounico}} </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <br>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Universidad</th>
                <th>Titulo / especialidad</th>
                <th>Grado Academico</th>
                <th>Fecha</th>
                <th>Ciudad</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($titulos as $t)
            <tr>
                <td> {{$t->universidad}} </td>
                <td> {{$t->nombre_titulo}} </td>
                <td> {{$t->grado}} </td>
                <td> {{$t->fecha_titulo}} </td>
                <td> {{$t->ciudad}} </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </table>
</body>
</html>