@extends('theme.lte.layout')
@section('contenido')
<div class="row justify-content-center">

    <div class="col-lg-8 col-md-12">
        @if (session('info'))
            <div class="alert alert-success">{{ session('info') }}</div>
        @endif
        <form method="POST" action="{{ route('users.update', $user->id) }}" >
            <div class="card mt-2">
                <div class="card-header">
                    <div class="row">
                        <div class="col">

                        </div>
                        <div class="col"><h4 class="text-right">Editar Usuario</h4></div>
                    </div>
                </div>
                <div class="card-body">

                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name}}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $user->username }}" required autocomplete="username">

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('password') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ $user->password }}" required autocomplete="password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="">Roles</label>
                            <div class="col-md-6">
                                <ul>
                                    @foreach ($roles as $key => $rol)
                                        <li>
                                        <label>
                                            <input type="checkbox" class="form-check-input" name="rol[]" value="{{ $rol->id }}"
                                                @foreach ($role_user as $hasRole)
                                                    @if ($hasRole->role_id==$rol->id)
                                                        checked
                                                    @endif
                                                @endforeach
                                            >
                                            {{ $rol->name }}
                                        </label>
                                        </li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>

                        <h3>Permisos</h3>
                        <div class="form-group">
                            <ul>
                                @foreach ($permisos as $permiso)
                                    <li>
                                        <label>
                                            <input type="checkbox" class="form-check-input" name="permisos[]" value="{{ $permiso->id }}"
                                            @foreach ($permisos_user as $check)
                                                @if ($check->permission_id == $permiso->id)
                                                    checked
                                                @endif
                                            @endforeach
                                            >
                                            {{ $permiso->name }}
                                            <em> ({{ $permiso->description }}) </em>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>



                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Editar
                                </button>
                                @if($doctor == false)
                                <a href="{{route('doctores.nuevo', $user->id)}}" class="btn btn-info">Nuevo doctor</a>
                                @endif
                            </div>
                        </div>

                    </div>
            </div>
        </form>
    </div>

</div>
@endsection
