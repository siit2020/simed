@extends('theme.lte.layout')
@section('contenido')
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12" >
                    <div class="card">
                        <div class="card-header bg-primary">
                            Foto de pérfil
                        </div>
                        <div class="card-body p-0" >
                            <img src="{{asset($user->avatar)}}" class="img-fluid" width="100%" height="auto" alt="{{$user->name}}">
                            <form action="{{route('users.update', $user->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">
                                <div class="custom-file">
                                    <input type="file" name="input-avatar" class="custom-file-input" id="input-avatar">
                                    <label class="custom-file-label" for="customFile">Seleccionar</label>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary btn-block">Aceptar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" >
                    <div class="card">
                        <div class="card-header bg-primary">
                            Logo
                        </div>
                        <div class="card-body p-0" >
                            <img src="{{asset('adjuntosdoctor/'.$doctor->id.'-'.$doctor->apellidosDoctor.'/'.$doctor->logo)}}" class="img-fluid" width="100%" height="auto" alt="{{$user->name}}">
                            <form action="{{route('users.update', $user->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">
                                <div class="custom-file">
                                    <input type="file" name="input-logo" class="custom-file-input" id="input-logo">
                                    <label class="custom-file-label" for="customFile">Seleccionar</label>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary btn-block">Aceptar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" >
                    <div class="card">
                        <div class="card-header bg-primary">
                            Marca de agua
                        </div>
                        <div class="card-body p-0" >
                            <img src="{{asset('adjuntosdoctor/'.$doctor->id.'-'.$doctor->apellidosDoctor.'/logo2.png')}}" class="img-fluid" width="100%" height="auto" alt="{{$user->name}}">
                            <form action="{{route('users.update', $user->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">
                                <div class="custom-file">
                                    <input type="file" name="input-logo" class="custom-file-input" id="input-logo">
                                    <label class="custom-file-label" for="customFile">Seleccionar</label>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary btn-block">Aceptar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card shadow shadow-lg border border-primary">
                <div class="card-header bg-primary ">
                    Información de la cuenta
                </div>
                <div class="card-body">
                    <form action="{{route('users.update', $user->id)}}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="name">Nombre</label>
                                <div class="input-group">
                                    {{-- <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupName"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    </div> --}}
                                    <input type="text" class="form-control form-control-sm" name="name" id="name" aria-describedby="inputGroupName" value="{{$user->name}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                    <label for="username">Nombre de usuario</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" name="username" id="username" aria-describedby="inputGroupUsername" value="{{$user->username}}">
                                    {{--  <div class="invalid-feedback">
                                        Please choose a username.
                                        </div> --}}
                                    </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="password">Contraseña</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" name="password" id="password" aria-describedby="inputGroupNPassword" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="passwordconfirm">Confirmación de contraseña</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" name="passwordconfirm" id="passwordConfirm" aria-describedby="inputGroupNPasswordConfirm">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-primary pull-right">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card shadow shadow-lg border border-primary">
                <div class="card-header bg-primary">
                    Información personal
                </div>
                <div class="card-body">
                    <form action="{{route('doctores.update', $doctor->id)}}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control form-control-sm" value="{{$doctor->nombreDoctor}}">
                            </div>
                            <div class="col-md-6">
                                <label for="apellidos">Apellidos</label>
                                <input type="text" name="apellidos" id="apellidos" class="form-control form-control-sm" value="{{$doctor->apellidosDoctor}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="titulo">Título</label>
                                <input type="text" name="titulo" id="titulo" class="form-control form-control-sm" value="{{$doctor->tituloDoctor}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="jvpm">JVPM</label>
                                <input type="text" name="jvpm" id="jvpm" class="form-control form-control-sm" value="{{$doctor->codigoDoctor}}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-primary pull-right">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow shadow-lg border border-primary">
                <div class="card-header bg-primary">
                    Especialidades
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <label class="input-group-text" for="inputGroupSelect01">Especialidad</label>
                                </div>
                                <select class="form-control" id="inputGroupSelect01">
                                    <option value="">Seleccione</option>
                                    @foreach ($especialidades as $especialidad)
                                        <option value="{{$especialidad->id}}">{{$especialidad->specialty_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @foreach ($speciality as $especialidad)
                                <input type="text" disabled name="" class="form-control" value="{{$especialidad->id}}">
                            @endforeach
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-sm btn-primary pull-right">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card shadow shadow-lg border border-primary">
                <div class="card-header bg-primary">
                    Servicios y experiencia laboral
                </div>
                <div class="card-body">
                    <form action="{{route('doctores.update', $doctor->id)}}" method="POST">
                        @csrf
                        <label for="estudios">Estudios</label>
                        <textarea name="estudios" id="estudios" class="textarea form-control form-control-sm" cols="30" rows="10">{!!$informacion->estudios!!}</textarea>
                        <label for="experiencia">Experiencia</label>
                        <textarea name="experiencia" id="experiencia" class="textarea form-control form-control-sm" cols="30" rows="10">{!!$informacion->experiencia!!}</textarea>
                        <label for="servicios">Servicios</label>
                        <textarea name="servicios" id="servicios" class="textarea form-control form-control-sm" cols="30" rows="10">{!!$informacion->servicios!!}</textarea>
                        <label for="membrecias">Membrecías</label>
                        <textarea name="membrecias" id="membrecias" class="textarea form-control form-control-sm" cols="30" rows="10">{!!$informacion->membrecias!!}</textarea>
                    
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-primary pull-right">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow shadow-lg border border-primary">
                <div class="card-header bg-primary">
                    Hospital o clínica
                </div>
                <div class="card-body">
                    <form action="{{route('doctores.update', $doctor->id)}}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="nombreclinica">Nombre</label>
                                <input type="text" name="nombreclinica" id="nombreclinica" class="form-control form-control-sm" value="{{$clinica->nombreClinica}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="slogan">Eslogan</label>
                                <input type="text" name="slogan" id="slogan" class="form-control form-control-sm" value="{{$clinica->slogan}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="direccion">Dirección</label>
                                <input type="text" name="direccion" id="direccion" class="form-control form-control-sm" value="{{$clinica->direccion}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="telefonos">Teléfonos</label>
                                <input type="text" name="telefonos" id="telefonos" class="form-control form-control-sm" value="{{$clinica->telefonos}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="celular">Celular</label>
                                <input type="text" name="celular" id="celular" class="form-control form-control-sm" value="{{$clinica->celular}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="facebook">Facebook</label>
                                <input type="text" name="facebook" id="facebook" class="form-control form-control-sm" value="{{$clinica->facebook}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="instagram">Instagram</label>
                                <input type="text" name="instagram" id="instagram" class="form-control form-control-sm" value="{{$clinica->instagram}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="paginaweb">Página web</label>
                                <input type="text" name="paginaweb" id="paginaweb" class="form-control form-control-sm" value="{{$clinica->paginaWeb}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" class="form-control form-control-sm" value="{{$clinica->email}}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-primary pull-right">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
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
    </script>
@endsection