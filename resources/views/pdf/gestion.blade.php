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
        <h3>Reporte Inscritos en la Gestion {{$gestion}}</h3>
    </div>
    <strong>Total de Ingresados : </strong>{{ 1*$cantNuevos + 1*$cantTraspaso }} <br>
    <strong>Cantidad de Ingresados como NUEVO : </strong> {{$cantNuevos}} <br>
    <strong>Cantidad de Ingresados como TRASPASO : </strong>{{$cantTraspaso}} 
    <table class="table table-bordered table-striped" >
        <thead>
            <tr>
                <th>Numero</th>
                <th>Paterno</th>
                <th>Materno</th>
                <th>Nombres</th>
                <th>C.I.</th>
                <th>Tipo de Ingreso</th>
                <th>Fecha de Ingreso</th>
                <th>Codigo Colegio</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
        <?php $c = 0  ?>
        @foreach ($afiliados as $a)
        
            <tr>
                <td> {{$c = $c + 1 }} </td>
                <td> {{$a->apellido_paterno}} </td>
                <td> {{$a->apellido_materno }}</td>
                <td> {{$a->nombres}} </td>
                <td> {{$a->ci}} </td>
                <td> {{$a->modalidad}} </td>
                <td> {{$a->fecha_modalidad}} </td>
                <td> {{$a->codigounico}} </td>
                <td> {{$a->estado}} </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </table>
</body>
</html>