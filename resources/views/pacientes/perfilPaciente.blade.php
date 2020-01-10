@extends('theme.lte.layout')
@section('styles')
<link href="{{asset('css/fileinput.css')}}" media="all" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{asset("assets/plugins/font-awesome/css/font-awesome.min.css")}}">
<style type="text/css">
    .main-section{
        margin:0 auto;
        padding: 20px;
        margin-top: 100px;
        background-color: #fff;
        box-shadow: 0px 0px 20px #c1c1c1;
    }
    .img-pointer{
        cursor: pointer;      
    },
    .fileinput-upload{
        display: none;
    }
    .badge{
        cursor: pointer;
        margin-left: 5px;
        font-size: 15px;
        font-weight: normal;
    },
    

</style>
@endsection
@section('contenido')
<section class="content row justify-content-center">
    <div class="col-md-12 col-xl-11 col-sm-12">
            @if (Session::has('exito'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">
                    &times;
                </button>
                {{Session::get('exito')}}
            </div>
        @endif
        
        {{-- <div class="row">
            <div class="col-md-12 col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb ">
                        <li class="breadcrumb-item active pull-right" ><a href="{{route('home')}}" title="Ir a inicio">INICIO</a></li>
                        <li class="breadcrumb-item active pull-right" ><a href="{{route('pacientes.index')}}" title="Ir a lista de pacientes">LISTA DE PACIENTES</a></li>
                        <li class="breadcrumb-item active" aria-current="page">PERFIL DEL PACIENTE</li>
                    </ol>
                </nav>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="row text-center">
                            <div class="col-8 ">
                                <a href="{{route('adjuntos.verperfil',$paciente->id)}}" target="_blank">
                                    <img src="{{asset('img/loading.gif')}}" class="profile-user-img img-fluid img-circle  pull-right" alt="" id="cargando" style="display:none">
                                    <img  class="profile-user-img img-fluid img-circle  pull-right" id="avatarProfile" src="{{$paciente->getAvatarUrl()}}" alt="User profile picture" style="display:block">
                                </a>
                            </div>
                            <div class="col-4">
                                <label for="inputProfile"><i class="fa fa-camera-retro fa-2x change pull-left"  aria-hidden="true"  title="Cambiar foto de perfil"></i></label>
                                <div id="formperfil" style="display:none">
                                    <img src="" alt="" id="avatar">
                                    <form action="{{route('changeProfile')}}"  method="POST" id="formProfile" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="paciente" value="{{$paciente->id}}">
                                        <input type="file" name="photo" id="inputProfile"  accept="image/*" onchange="cambiar()">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12" style="display:none" id="divoculto">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" id="barraProfile">0 %</div>
                                </div>
                            </div>
                        </div>
                        <h6 class="profile-username text-center">{{$paciente->apellidos}}, {{$paciente->nombre}}</h6>
                        <p class="text-muted text-center">{{$paciente->codigo}}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Registro:</b> <a class="float-right">{{ \Carbon\Carbon::parse($paciente->created_at)->format('d/m/Y - h:i a')}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>DUI:</b> <a class="float-right">{{$paciente->dui}} </a>
                            </li>
                            <li class="list-group-item">
                                <b>Edad:</b> <a class="float-right">{{$paciente->getAgeAttribute()}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Sexo:</b> <a class="float-right">{{$paciente->sexo}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Teléfono:</b> <a class="float-right">{{$paciente->telefono}}</a>
                            </li>
                            
                            <li class="list-group-item">
                                <b>Email:</b> <a class="float-right">{{$paciente->email}} </a>
                            </li>
                            <li class="list-group-item text-center" id="limostrar">
                               <button type="button" class="btn btn-sm btn-primary" style="width:100%" id="mostrarMas" onclick="mostrardatos()">Mostrar más datos</button>
                            </li>
                            <li class="list-group-item masdatos" style="display:none" >
                                <b>Teléfono del trabajo:</b> <a class="float-right">{{$paciente->teltrabajo}}</a>
                            </li>
                            <li class="list-group-item masdatos" style="display:none" >
                                <b>Celular del trabajo:</b> <a class="float-right">{{$paciente->celtrabajo}}</a>
                            </li>
                            <li class="list-group-item masdatos" style="display:none" >
                                <b>Asegurado:</b> <a class="float-right">{{$paciente->asegurado}}</a>
                            </li>
                            @if($paciente->asegurado=='si')
                            <li class="list-group-item masdatos" style="display:none" >
                                <b>Compañia de seguro:</b> <a class="float-right">{{$paciente->companiaseguro}}</a>
                            </li>
                            <li class="list-group-item masdatos" style="display:none" >
                                <b>Número de póliza</b> <a class="float-right">{{$paciente->nopoliza}}</a>
                            </li>
                            <li class="list-group-item masdatos" style="display:none" >
                                <b>Número de carné:</b> <a class="float-right">{{$paciente->nocarnet}}</a>
                            </li>
                            @endif
                            <li class="list-group-item masdatos" style="display:none" >
                                <b>Estado civil:</b> <a class="float-right">{{$paciente->civil}}</a>
                            </li>
                            @if($historico != null)
                            <li class="list-group-item masdatos" style="display:none">
                                <b>Peso:</b> <a class="float-right">{{$historico->peso}} Libras</a>
                            </li>
                            <li class="list-group-item masdatos" style="display:none">
                                <b>Estatura:</b> <a class="float-right">{{$historico->estatura}} metros</a>
                            </li>
                            @endif
                             @if($paciente->direccion != null)
                            <li class="list-group-item masdatos" style="display:none">
                                <b>Dirección:</b><p>{{$paciente->direccion}}</p>
                            </li>
                            @endif
                            @if(Auth::user()->hasPermission('create_consultas_proc'))
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-xl-5"><a title="Nueva consulta" class="btn btn-info btn-block btn-sm" href="{{route('consultas.create',$paciente->id)}}" ><i class="fa fa-book" aria-hidden="true"></i> CONSULTA</a></div>
                                    <div class=" d-none d-md-block col-xl-7"><a title="Nuevo procedimiento" class="btn btn-info btn-block btn-sm" href="{{ route('procedimiento.tipo', $paciente->id) }}" ><i class="fa fa-camera" aria-hidden="true"></i> PROCEDIMIENTO</a></div>
                                </div>
                            </li>
                            @endif
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Notas</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool"  data-toggle="modal" data-target="#notas" title="editar notas"><i class="fa fa-pencil fa-2x"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {!! $paciente->notas !!}
                                </div>
                            </div>

                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <a title="editar perfil" class="btn btn-primary btn-block btn-sm" href="#" data-toggle="modal" data-target="#editarPaciente"><i class="fa fa-pencil" aria-hidden="true"></i> EDITAR</a>
                                    </div>
                                    <div class="col-xl-6 ">
                                        @if(Auth::user()->hasPermission('delete_pacient'))
                                        <form action="{{route('pacientes.destroy', $paciente->id)}}" method="POST" id="formDelete">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class=" btn btn-danger btn-block btn-sm" type="submit"  title="Eliminar Paciente">
                                                <i class="fa fa-trash" aria-hidden="true"></i> ELIMINAR
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-xs-12">
                <div class="card card-primary card-outline">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-lg-9 col-md-12 col-sm-12">
                                <ul class="nav nav-pills  p-2">
                                    <li class="nav-item"><a class=" nav-link nav-link-sm active" href="#Historial" data-toggle="tab" title="Historial del paciente {{$paciente->nombre}}">
                                        <i class="fa fa-address-book-o" aria-hidden="true"></i> Historial</a>
                                    </li>
                                    <li class="nav-item "><a class="nav-link nav-link-sm " href="#adjuntos"  data-toggle="tab" title="Historial de Archivos del paciente {{$paciente->nombre}}">
                                        <i class="fa fa-paperclip" aria-hidden="true"></i> Adjuntos</a>
                                    </li>
                                    <li class="nav-item d-none d-sm-block" ><a class="nav-link nav-link-sm " href="#recetas"  data-toggle="tab" title="Historial recetas del paciente {{$paciente->nombre}}">
                                        <img src="{{asset('/assets/img/reseta.png')}}" alt="" width="25px" height="25px"> Recetas</a>
                                    </li>
                                    @if($doctor->equipoLocal=='si')
                                    <li class="nav-item"><a class="nav-link nav-link-sm " href="http://localhost/siimedlocal/index.php?cod={{ $paciente->nombre.' '.$paciente->apellidos }}" target="_blank"  title="Historial de Archivos del paciente {{$paciente->nombre}}">
                                        <i class="fa fa-paperclip" aria-hidden="true"></i> Videos y Fotos</a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-lg-3 col-md-0   d-none d-lg-block">
                                <div class="dropdown mt-2 pull-right">
                                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        + Opciones
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @if(Auth::user()->hasPermission('create_recetas'))
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#nuevaReceta"  title="Nueva receta para el paciente {{$paciente->nombre}}">
                                            <i class="fa fa-plus-circle" aria-hidden="true">&nbsp;Receta</i>
                                        </a>
                                        @endif
                                        <a class="dropdown-item" href="#"  data-toggle="modal" data-target="#adjunto" title="Adjuntar archivo al paciente {{$paciente->nombre}}">
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Adjunto</a>
                                        @if(Auth::user()->hasPermission('create_anexos'))
                                        <a class="dropdown-item" href=" {{route('citas.paciente',['procedimiento',$paciente->id])}} "  title="Nueva cita para el paciente {{$paciente->nombre}}">
                                            <i class="fa fa-plus-circle" aria-hidden="true">&nbsp;Citas de procedimiento</i></a>
                                        <a class="dropdown-item" href="{{route('citas.paciente',['consulta', $paciente->id])}}"  title="Nueva cita para el paciente {{$paciente->nombre}}">
                                            <i class="fa fa-plus-circle" aria-hidden="true">&nbsp;Citas de consulta</i></a>
                                        <a class="dropdown-item" href="{{route('anexos.paciente', [$paciente->id, 'tipo' => 'alta'])}}" aria-hidden="true">
                                            <i class="fa fa-plus-circle" aria-hidden="true">&nbsp;Hoja de alta</i></a>
                                        <a class="dropdown-item" href="{{route('anexos.paciente', [$paciente->id, 'tipo' => 'incapacidad'])}}" aria-hidden="true">
                                            <i class="fa fa-plus-circle" aria-hidden="true">&nbsp;Hoja de incapacidad</i></a>
                                        </a>
                                        @endif
                                        <a class="dropdown-item" href="{{route('inventario.addventaperfil', [$paciente->id])}}" aria-hidden="true">
                                            <i class="fa fa-plus-circle" aria-hidden="true">&nbsp;Agregar medicamentos/insumos</i></a>
                                            <form id="formlistas" action="{{route('inventario.listaventas')}}">
                                            <input type="hidden" value="{{$paciente->id}}" id="idlista" name="idlista">
                                                @csrf
                                        <a class="dropdown-item" href="#" aria-hidden="true" onclick="listaventass()">
                                            </form>
                                        
                                            <i class="fa fa-plus-circle" aria-hidden="true">&nbsp;Listado de  medicamentos/insumos</i></a>
                                        <a href="{{route('pacientes.historico', $paciente->id)}}" class="dropdown-item">
                                            <i class="fa fa-plus-circle" aria-hidden="true">&nbsp;Historial de peso</i></a>
                                        </a>
                                        <a href="{{route('pacientes.historico', $paciente->id)}}" class="dropdown-item">
                                            <i class="fa fa-plus-circle" aria-hidden="true">&nbsp;Historial de peso</i></a>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                    <div class="tab-content">
                        @if($cantidad>0)
                            <div class="tab-pane active" id="Historial">
                                <ul class="timeline timeline-inverse">
                                    @foreach ($historial as $historial)
                                        @if ($historial->consulta_id!=null)
                                            <li class="time-label ">
                                                <span class="bg-info">
                                                    {{ \Carbon\Carbon::parse($historial->created_at)->format('d/m/Y - h:i a')}}
                                                </span>
                                            </li>
                                            <li>
                                                <div class="timeline-item shadow-lg p-3 mb-5 bg-white rounded">
                                                    <div class=" row timeline-header " style="color:#000;font-family:Verdana, Geneva, Tahoma, sans-serif">
                                                        <div class="col-md-7 col-sm-12">
                                                            <p>{{$historial->tituloConsulta}}</p>
                                                        </div>
                                                        <div class="col-md-5 col-sm-12 ">
                                                            <div class="form-group pull-right">
                                                                    @if($historial->receta!=null)<a id="reporte" href="{{route('imprimirReceta', $historial->receta)}}" target="_blank"><i class="fa fa-print " aria-hidden="true">Receta Médica</i></a>@endif |
                                                                    <a id="reporte" href="{{route('reporteConsulta',$historial->id)}}"  target="_blank"><i class="fa fa-print " aria-hidden="true">Consulta</i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="collapse" id="collapseExample{{$historial->id}}">
                                                        <div class="card card-body">
                                                           <strong>DETALLE:</strong> {!!$historial->detalleConsulta!!}
                                                            <br>
                                                           @if($historial->diagnostico)<strong>DIAGNOSTICO:</strong>  {!!$historial->diagnostico!!}@endif
                                                            <br>
                                                        @if($historial->prescripcion!=null)<strong>PRESCRIPCION:</strong> {!!$historial->prescripcion!!}@endif
                                                        </div>
                                                    </div>
                                                    <div class="timeline-footer ">
                                                            <form action="{{route('consultas.destroy', $historial->consulta_id)}} " method="POST" >
                                                                @csrf
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button type="button" class="btn btn-sm  btn-primary " data-toggle="collapse" href="#collapseExample{{$historial->id}}" role="button" aria-expanded="false"  >
                                                                ver más
                                                            </button>
                                                            @if(Auth::user()->hasPermission('edit_consultas'))
                                                            <a href="{{route('consultas.edit', $historial->consulta_id)}}" class="btn btn-sm btn-info " >Editar</a>
                                                            @endif
                                                            @if(Auth::user()->hasPermission('delete_consultas'))
                                                            <button class="btn btn-sm btn-danger deleteconsulta" type="submit">Eliminar </button>
                                                            @endif
                                                        </form>
                                                    </div>
                                                </div>
                                            </li>
                                        @elseif($historial->procedimiento_id!=null)
                                            <li class="time-label">
                                                <span class="bg-info">
                                                    {{ \Carbon\Carbon::parse($historial->created_at)->format('d/m/Y - h:i a')}}
                                                </span>
                                            </li>
                                            <li>
                                                <div class="timeline-item shadow-lg p-3 mb-5 bg-white rounded">
                                                    <h3 class="timeline-header " style="color:blue">
                                                        Procedimiento de {{ $historial->procedimiento_nombre }}
                                                    </h3>
                                                    <div class="timeline-body">
                                                            <a href="{{route('procedimiento.show',$historial->id)}}" target="_blank" title="ver procedimiento" class="btn btn-sm btn-primary"> &nbsp; Ver &nbsp;</a>
                                                            @if(Auth::user()->hasPermission('edit_procedimientos')) 
                                                                <a href="{{route('procedimiento.edit',$historial->id)}}" title="editar procedimiento" class="btn btn-sm btn-info">Editar</a>
                                                            @endif
                                                            @if(Auth::user()->hasPermission('delete_procedimientos'))
                                                                <span class="btn btn-sm btn-danger   eliminarProcedimientoBtn">Eliminar</span>
                                                               <form action="{{route('procedimiento.destroy',$historial->id)}}" method="POST">
                                                                @csrf
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                </form>
                                                            @endif
                                                    </div>
                                                </div>
                                            </li>
                                        @elseif($historial->anexo_id!=null)
                                            <li class="time-label">
                                                <span class="bg-info">
                                                    {{ \Carbon\Carbon::parse($historial->created_at)->format('d/m/Y - h:i a')}}
                                                </span>
                                            </li>
                                            <li>
                                                <div class="timeline-item shadow-lg p-3 mb-5 bg-white rounded">
                                                    <h3 class="timeline-header " style="color:blue">
                                                       Hoja de {{ $historial->tipo }}
                                                    </h3>
                                                    <div class="timeline-body">
                                                        <a href="{{route('anexos.show',$historial->anexo_id)}}" target="_blank" title="imprimir anexo" class="btn btn-sm btn-primary"> Imprimir</a>
                                                            
                                                        @if(Auth::user()->hasPermission('seeting_anexos'))
                                                        <a href="{{route('anexos.edit',$historial->anexo_id)}}" title="editar Anexo" class="btn btn-sm btn-info">Editar</a>
                                                
                                                        <span class="btn btn-sm btn-danger " onclick="event.preventDefault();document.getElementById('deleteAnexo').submit();">Eliminar</span>
                                                        <form action="{{route('anexos.destroy',$historial->anexo_id)}}" method="POST" id="deleteAnexo">
                                                        @csrf
                                                            <input type="hidden" name="_method" value="DELETE">
                                                        </form>
                                                        @endif
                                                           
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>

                        @else
                            <div class="tab-pane active" id="Historial">
                                <div class="mensaje">
                                    <p>
                                        ¡Vaya al parecer el paciente aún no tiene ninguna historia!
                                        @if(Auth::user()->hasPermission('create_consultas_proc'))
                                            <a href="{{route('consultas.create',$paciente->id)}}" class=" btn btn-primary btn-sm" ><i class=" fa fa-plus-circle" aria-hidden="true"></i>&nbsp;añadir una Consulta</a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if ($cantidadAdjuntos>0)
                            <div class=" tab-pane"  id="adjuntos">
                                <a class="btn btn-sm btn-primary" href="#"  data-toggle="modal" data-target="#adjunto" title="Adjuntar archivo al paciente {{$paciente->nombre}}">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; Nuevo Archivo
                                </a><br><br>
                                <ul class="timeline timeline-inverse">
                                    @foreach ($adjuntos as $adjunto)
                                        <li class="time-label">
                                            <span class="bg-info">
                                                {{ \Carbon\Carbon::parse($adjunto->created_at)->format('d/m/Y H:i:s')}}
                                            </span>
                                        </li>
                                        <li>
                                            <div class="timeline-item shadow-lg p-3 mb-5 bg-white rounded">
                                                <div class="timeline-body">
                                                    <p id="description">{!! $adjunto->descripcion !!}</p>
                                                    <div id="mostrarImg" class="row ">
                                                        @if ($adjunto->extenAdjunto()=='imagen')
                                                            <a id="imagen" href="{{route('obtener.ruta',['solicitud' => 'watch', $paciente->id, $adjunto->adjunto])}}" target="_blank">
                                                                <img class="rounded image"   width="200" height="200"
                                                                    src="{{asset('adjuntospaciente/'.'paciente'.$paciente->id.'/'.$adjunto->adjunto)}}" ></a>
                                                        @elseif($adjunto->extenAdjunto()=='word')
                                                            <a id="imagen" href="{{route('obtener.ruta',['solicitud' => 'watch', $paciente->id, $adjunto->adjunto])}}" target="_blank">
                                                                <img  class="imgHistorial  image"
                                                                    src="{{asset('assets/img/docs.png')}}"  ></a>
                                                        @elseif($adjunto->extenAdjunto()=='pdf')
                                                        <a id="imagen" href="{{route('obtener.ruta',['solicitud' => 'watch', $paciente->id, $adjunto->adjunto])}}" target="_blank">
                                                            <img  class="imgHistorial  image"
                                                                src="{{asset('assets/img/pdf.png')}}"  ></a>
                                                        @elseif($adjunto->extenAdjunto()=='excel')
                                                        <a id="imagen" href="{{route('obtener.ruta',['solicitud' => 'watch', $paciente->id, $adjunto->adjunto])}}" target="_blank">
                                                            <img  class="imgHistorial  image"
                                                                src="{{asset('assets/img/excel.png')}}"  ></a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="timeline-footer ">
                                                    <a href="{{route('obtener.ruta',['solicitud' => 'print', $paciente->id, $adjunto->adjunto])}}" class="btn btn-sm btn-primary " target="_blank "> Imprimir</a>
                                                    <a href="{{route('obtener.ruta',[$paciente->id,'solicitud' => 'download', $adjunto->adjunto])}}" class="btn btn-sm btn-primary  "> Descargar </a>
                                                    <a href="{{route('obtener.ruta', ['solicitud' => 'delete', $paciente->id, $adjunto->adjunto])}}" class="btn btn-sm btn-danger  deleteadjunto">Eliminar</a>
                                                </div>
                                            </div>
                                       </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else

                            <div class="tab-pane " id="adjuntos">
                                <p>no hay nada que mostrar
                                    <a class="btn btn-sm btn-primary " href="#"  data-toggle="modal" data-target="#adjunto" title="Adjuntar archivo al paciente {{$paciente->nombre}}">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; Nuevo Archivo
                                    </a>
                                </p>
                            </div>

                        @endif
                        @if($cantidadRecetas>0)
                        <div class=" tab-pane"  id="recetas">
                            @if(Auth::user()->hasPermission('create_recetas'))
                            <a class="btn btn-sm btn-primary +" href="#" data-toggle="modal" data-target="#nuevaReceta"  title="Nueva receta para el paciente {{$paciente->nombre}}">
                                <i class="fa fa-plus-circle" aria-hidden="true"> Nueva Receta</i>
                            </a><br><br>
                            @endif
                            <ul class="timeline timeline-inverse">
                                @foreach ($recetas as $receta)
                                    <li class="time-label">
                                        <span class="bg-info">
                                            {{ \Carbon\Carbon::parse($receta->created_at)->format('d/m/Y H:i:s')}}
                                        </span>
                                    </li>
                                    <li>
                                        <div class="timeline-item shadow-lg p-3 mb-5 bg-white rounded">
                                            <div class="pull-right mr-1"><i class="fa fa-print" aria-hidden="true"><a id="archivo" href="{{route('imprimirReceta',$receta->id)}}" target="_blank"> Imprimir</a></i></div>
                                            {{-- <div class="pull-right mr-1"><i class="fa fa-eye" aria-hidden="true"><a id="imagen" href="" target="_blank"> Ver</a></i></div> --}}
                                            <br>
                                            <div class="timeline-body">
                                                {!!$receta->tituloReceta!!}
                                                <hr size="10" />
                                                {!! $receta->descripcionReceta !!}
                                            </div>
                                                <div class="row timeline-footer">
                                                    <div class="col-md-12 col-sm-12">
                                                        <a href="{{route('recetas.edit', $receta->id)}}" class="btn btn-sm btn-info">Editar</a>
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="event.preventDefault();document.getElementById('formdeletereceta').submit();">
                                                        Eliminar
                                                    </button>
                                                    </div>
                                                    <form action="{{route('recetas.destroy', $receta->id)}}" method="POST" id="formdeletereceta">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="DELETE">
                                                    </form>
                                                </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @else
                            <div class="tab-pane" id="recetas">
                                <p>no hay nada que mostrar
                                    @if(Auth::user()->hasPermission('create_recetas'))
                                    <a class="btn btn-sm btn-primary " href="#" data-toggle="modal" data-target="#nuevaReceta"  title="Nueva receta para el paciente {{$paciente->nombre}}">
                                        <i class="fa fa-plus-circle" aria-hidden="true"> Nueva Receta</i>
                                    </a>
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    @include('pacientes.notas')
    @include('Recetas.recetaPaciente')
    @include('pacientes.editarPaciente')
    @include('pacientes.adjuntos')




@endsection
@section('scripts')
<script>
    function mostrardatos(){
        $('#limostrar').hide();
        $(".masdatos").show();
    }
    
    $(document).ready(function() {

        $("#siposee").click(function() {  
            document.getElementById('asegurados').style.display = "block";
            document.getElementById('companiaseguro').value = "{{$paciente->companiaseguro}}";
            document.getElementById('nopoliza').value = "{{$paciente->nopoliza}}";
            document.getElementById('nocarnet').value = "{{$paciente->nocarnet}}";
        });

        $("#noposee").click(function() {  
            document.getElementById('asegurados').style.display = "none";
            document.getElementById('companiaseguro').value = "";
            document.getElementById('nopoliza').value = "";
            document.getElementById('nocarnet').value = "";
        });

    });

    toastr.options = {
        "positionClass": "toast-bottom-right",
    }

@if(Session::has('info'))
    @if(Session::get('info') == 'El archivo ha sido eliminado correctamente!')
         $('a[href="#adjuntos"]').click();
        toastr.success('Se elimino el archivo correctamente');
    @elseif(Session::get('info') == 'La receta se eliminó correctamente')
            $('a[href="#recetas"]').click();
            toastr.success('La receta se elimino correctamente');
    @elseif(Session::get('info') == 'El adjunto se subio correctamente')
        $('a[href="#adjuntos"]').click();
        toastr.success('el archivo se subio con exito');
    @elseif(Session::get('info') == 'ok')
        toastr.success('La foto de perfil se cambio con exito');
    @elseif(Session::get('info') == 'receta exito')
        $('a[href="#recetas"]').click();
    @elseif(Session::get('info') == '¡La consulta ha sido eliminada!')
        toastr.success('Se ha eliminado la consulta');
    @endif
@endif

//para el textarea
$(function () {
        // bootstrap WYSIHTML5 - text editor
        $('.textarea').wysihtml5({
            toolbar: { fa: true,
                "image" : false,
                "link" : false,
                "font-styles" : false,
            },
            useLineBreaks : true,
        })
    })

//comfirmar para eliminar un paciente
    $('#formDelete').on('submit', function(e){
        if(!confirm('Desea eliminar al paciente?')){
            e.preventDefault();
        }
    });
//para formulario de receta
    $('#formReceta').on()
//ara formulario de adjuntos
   /*  $('#file-3').fileinput({
        theme: 'fa',
        maxFileSize:5000,
        overwriteInitial: false,
        maxFilesNum: 1,
        slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
    }); */
//para formularios de procedimientos
document.addEventListener('DOMContentLoaded', (event) => {      
        $('#plantilla1').click(function(){
            $('#receta1').addClass('border border-primary');
            $('#receta2').removeClass('border border-primary');
            $('#receta3').removeClass('border border-primary');
            $('#receta4').removeClass('border border-primary');
        });
        $('#plantilla2').click(function(){
            $('#receta1').removeClass('border border-primary');
            $('#receta2').addClass('border border-primary');
            $('#receta3').removeClass('border border-primary');
            $('#receta4').removeClass('border border-primary');
        });
        $('#plantilla3').click(function(){
            $('#receta1').removeClass('border border-primary');
            $('#receta2').removeClass('border border-primary');
            $('#receta3').addClass('border border-primary');
            $('#receta4').removeClass('border border-primary');
        });
        $('#plantilla5').click(function(){
            $('#receta1').removeClass('border border-primary');
            $('#receta2').removeClass('border border-primary');
            $('#receta3').removeClass('border border-primary');
            $('#receta4').addClass('border border-primary');
        });
    });
    $(document).ready(function(){
        $('.eliminarProcedimientoBtn').click(function(){
            if (confirm('Desea eliminar el procedimiento')){
                $(this).siblings('form').submit();
            }
        });
    });

    $(document).ready(function(){
        $('.deleteconsulta').click(function(){
            if (confirm('¿Desea eliminar la consulta?')){
                $(this).siblings('form').submit();
            }
        });
    });


    function showPreview(){
        file = document.getElementById('file').files[0];
        preview = document.getElementById('prueba');
        label = document.getElementById('nombrefile');
        name = document.getElementById('file').files[0].name;

        reader = new FileReader();

        reader.addEventListener("load", function() {
            preview.src = reader.result;
        },false);

        reader.readAsDataURL(file);
        label.innerHTML = name;
    }


    function compressAndUpload(archivo) {
        extensiones =['.png','.jpg','.jpeg','.gif','.tif'];
        extensionesDos =['.doc','.docx','.xls','.xlsx','.pdf'];
        extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();

        for (var i = 0; i < extensiones.length; i++) {
            if (extensiones[i] == extension) {
                var formAdjuntos = $('#adjuntoss');
                var inputFile = $('#file');

                src_img = document.getElementById("prueba");
                target_img = document.createElement("IMG");
                target_img.src = compress(src_img,25,'jpg').src;

                blob = dataURItoBlob(target_img.src);
                blob.filename="demofile.png";

                var formData = new FormData();
                peticion = new XMLHttpRequest();
                peticion.upload.addEventListener("progress", function(e){
                    var barra = document.getElementById("barraProgreso");
                    var oculto =  document.getElementById("progreso");
                    oculto.style.display = "block";
                    var p = Math.round((e.loaded/e.total)*100);
                    barra.style.width = p + '%';
                    barra.innerHTML = p + "%";
                });
                formData.append('file', blob,"demofile.png".replace(/\.[^/.]+$/, ".jpg"));
                url= formAdjuntos.attr('action') + '?' + formAdjuntos.serialize();
                method = formAdjuntos.attr('method');
                peticion.open(method,url);
                peticion.send(formData);

                peticion.onreadystatechange = function() {
                    if (this.readyState == 4){
                        if (this.status == 200) {
                            var array = JSON.parse(this.responseText);
                            if(array["resultado"] == "1")
                            {
                                window.location = "{{route('adjuntos.mensajes', $paciente->id)}}";
                            }else if(array["resultado"] == "algo salio mal")
                            {
                                $('#adjuntos').modal('hide');
                                document.getElementById("adjuntoss").reset();
                                toastr.danger('fallo');
                            }
                        }else if (this.status >= 400) {
                            $('#adjuntos').modal('hide');
                            document.getElementById("adjuntoss").reset();
                            alert('intentelo de nuevo');
                        }
                    }
                }
            }
        }

        for (var i = 0; i < extensionesDos.length; i++) {
            if (extensionesDos[i] == extension) {
                var formAdjuntos = $('#adjuntoss');
                var formData = new FormData();
                var file = document.getElementById('file').files[0];
                peticion = new XMLHttpRequest();
                peticion.upload.addEventListener("progress", function(e){
                    var barra = document.getElementById("barraProgreso");
                    var oculto =  document.getElementById("progreso");
                    oculto.style.display = "block";
                    var p = Math.round((e.loaded/e.total)*100);
                    barra.style.width = p + '%';
                    barra.innerHTML = p + "%";
                });
                formData.append('file', file);
                url= formAdjuntos.attr('action') + '?' + formAdjuntos.serialize();
                method = formAdjuntos.attr('method');
                peticion.open(method,url);
                peticion.send(formData);

                peticion.onreadystatechange = function() {
                    if (this.readyState == 4){
                        if (this.status == 200) {
                            window.location = "{{route('adjuntos.mensajes', $paciente->id)}}";
                        }else if (this.status >= 400) {
                            $('#adjuntoss').modal('hide');
                            document.getElementById('adjuntoss').reset();
                            alert('intentelo de nuevo');
                        }
                    }
                }
            }
        }
    }
    

    /* formulario = $('#formularioReceta').submit();
        window.location = "{{route('recetas.mensaje', $paciente->id)}}"; */
   function enviado(){
       if($("#receta").val().length >0){
            formulario = $('#formularioReceta').submit();
            window.location = "{{route('recetas.mensaje', $paciente->id)}}"
       }else{
           $("#invalid-textarea").show();
       }
   }

   function cambiar(){
        carga = document.getElementById('cargando');
        input = document.getElementById('inputProfile').files[0];
        profile = document.getElementById('avatarProfile');
        avatar = document.getElementById('avatar');
        form1  = $('formperfil');
        reader = new FileReader();
        reader.addEventListener("load", function(){
            avatar.src = reader.result;
        });

        reader.addEventListener("progress", function(){
            carga.style.display = "block";
            profile.style.display = "none";
        });

        reader.readAsDataURL(input);

        reader.onload = function(event) {
            elemento = document.createElement('IMG');
            elemento.src = compress(avatar,15,'jpg').src;
            blob = dataURItoBlob(elemento.src);
            blob.filename="imagen.jpg";

            var formulario  = $('#formProfile');

            formdata = new FormData();
            peticion = new XMLHttpRequest();
            peticion.upload.addEventListener("progress", function(e){
                var barra = document.getElementById("barraProfile");
                var oculto =  document.getElementById("divoculto");
                oculto.style.display = "block";
                var p = Math.round((e.loaded/e.total)*100);
                barra.style.width = p + '%';
                barra.innerHTML = p + "%";
            });
            formdata.append('photo', blob,"imagen.jpg".replace(/\.[^/.]+$/, ".jpg"));
            url = formulario.attr('action') + '?' + formulario.serialize();
            method = formulario.attr('method');
            function reqListener () {
                if(this.responseText == 200)
                {
                    window.location = "{{route('adjuntos.cambioperfil', $paciente->id)}}"
                }
            }
            peticion.addEventListener("load", reqListener);
            peticion.open(method,url);
            peticion.send(formdata);
        };
   }
   function listaventass(){      
       $('#formlistas').submit();     
   }
   
</script>
@endsection
