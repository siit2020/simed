@extends('theme.lte.layout')

@section('styles')
    <style>
        table > tbody > tr {
            cursor: pointer;
        }
        table > tbody > tr:hover{
            background-color: #99ccff;
        }
        .idpaciente{
            display: none;
        }
         @media screen and (max-width: 1225px) and (min-width: 1045px) {

}

@media screen and (max-width: 1045px) and (min-width: 835px) {

}

@media screen and (max-width: 565px) and (min-width: 300px) {
    .priority-1{
            display:none;

    }

}

@media screen and (max-width: 300px) {


}   
    </style>
@endsection
@section('contenido')
    <div class="container">
        @include('pacientes.Notificaciones.success')
        <div class="card shadow-lg card-primary card-outline">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-2 "><a href="" class="btn btn-primary" data-toggle="modal" data-target="#nuevoPaciente">Nuevo Paciente</a></div>
                    <div class="col-md-10 d-none d-md-block"><h5 class="pull-right">LISTA DE PACIENTES</h5></div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive table-sm">
                    <table  id="pacientes" style="width:100%" class="table table-bordered display">
                        <thead class="bg-info">
                            <tr >
                                <th class="priority-1"></th>
                                @if (Auth::user()->hasPermission('grabar_proc'))
                                @if($posee->equipoLocal=='si')
                                <th></th>
                                @endif
                                @endif
                                <th class="priority-1 text-center ">DUI</th>
                                <th class="priority-2">Nombre</th>
                                <th class="priority-3">Apellidos</th>
                                <th class="priority-4 text-center ">Sexo</th>
                                <th class="priority-5 text-center">Edad</th>
                                <th class="priority-1 text-center ">Fecha de registro</th>
                                <th class="priority-3 text-center ">Opciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
 @include('pacientes.nuevoPaciente')


@endsection

@section('scripts')
<script>


    $(document).ready(function() {
        
        $("#siposee").click(function() {  
            document.getElementById('asegurados').style.display = "block";
        });

        $("#noposee").click(function() {  
            document.getElementById('asegurados').style.display = "none";
            document.getElementById('companiaseguro').value = "";
            document.getElementById('nopoliza').value = "";
            document.getElementById('nocarnet').value = "";
        });
        
        
        $('#pacientes').DataTable( {
            language: {
               "decimal": "",
               "emptyTable": "No hay información",
               "info": "Mostrando _START_ a _END_ de _TOTAL_ Pacientes",
               "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
               "infoFiltered": "(Filtrado de _MAX_ total Pacientes)",
               "infoPostFix": "",
               "thousands": ",",
               "lengthMenu": "Mostrar _MENU_ Pacientes",
               "loadingRecords": "Cargando...",
               "processing": "Procesando...",
               "search": "Buscar:",
               "zeroRecords": "Sin resultados encontrados",
               "paginate": {
                   "first": "Primero",
                   "last": "Ultimo",
                   "next": "Siguiente",
                   "previous": "Anterior"
               }
           },

            "processing": true,
            "serverSide": true,
            "ajax": "{{url('listadoPacientes')}}",
            "columns": [
                { "data": "id", "visible":true, className: "idpaciente" },
                @if (Auth::user()->hasPermission('grabar_proc'))
                    @if($posee->equipoLocal=='si')
                        { "orderable": false, "data": "grab", className: " priority-1" },
                    @endif
                @endif
                { "data": "dui", "orderable":false, className: "text-center paciente priority-1" },
                { "data": "nombre", className: "nombre paciente"},
                { "data": "apellidos", className: "apellidos paciente"},
                { "orderable": false, "data": "sexo", className: "text-center paciente"},
                { "orderable":false, "data": "nacimiento", className: "text-center paciente priority-1"},
                {  "data": "created_at","orderable":false, className: "text-center paciente priority-1"},
                { "orderable": false,"data": "btn", className: "text-center" },
            ],
        } );

        $('#pacientes tbody').on('click', '.paciente', function () {
            var codigo = $(this).siblings('.idpaciente').html();
            window.location="{{route('pacientes.index')}}"+'/'+codigo;
        } );

        $('#pacientes tbody').on('click', '.grabar', function () {
            var get=$(this).parent();
            var parametro = $(get).siblings('.nombre').html() + ' ' + $(get).siblings('.apellidos').html();
            var idpaciente = $(get).siblings('.idpaciente').html();
            window.location.assign("appurl://:" + idpaciente + ':' + parametro);
        } );

        /* $('#pacientes tbody').on('click', 'tr', function () {
        var codigo = $('td', this).eq(0).text();
        window.location="{{route('pacientes.index')}}"+'/'+codigo;

        } ); */
    } );
</script>

@endsection
