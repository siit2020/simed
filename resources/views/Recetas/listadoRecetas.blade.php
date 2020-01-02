@extends('theme.lte.layout')
@section('styles')

<style type="text/css">
   
    .img-pointer{
        cursor: pointer;      
    },      
</style>
@endsection
@section('contenido')

    <div class="container">
        <div class="card">
            <div class="card-header border-primary">
                <div class="row">
                    <div class="col">
                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#nuevaReceta">Nueva Receta</a>
                    </div>
                    <div class="col">
                        <h5 class="pull-right text-uppercase">
                            Listado de recetas
                        </h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($recetas->count()>0)
                    <table class="table table-sm">
                        <thead class="text-uppercase">
                            <tr>
                                <th>Titulo Receta</th>
                                <th >Detalle de receta</th>
                                <th class="text-center">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recetas as $receta)
                            <tr>
                                <td>{{$receta->tituloReceta}}</td>
                                <td width="650" >{!!$receta->descripcionReceta!!}</td>
                                <td  class="text-center">
                                    <a href="{{route('imprimirReceta', $receta->id)}}" target="_blank" class="btn btn-sm btn-primary">Imprimir</a>
                                    @if(Auth::user()->hasPermission('delete_recetas'))
                                    <button type="button" class="btn btn-sm btn-danger"
                                    onclick="event.preventDefault();
                                                    document.getElementById('delete-receta').submit();">
                                        {{ __('Eliminar') }}
                                    </button>
                                    <form action="{{route('recetas.destroy',$receta->id)}}" method="POST" id="delete-receta">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$recetas->links()}}
                @endif
            </div>
        </div>
    </div>


    @include('Recetas.nuevaReceta')
@endsection
@section('scripts')
<script>
 $(function () {
          // bootstrap WYSIHTML5 - text editor
          $('.textarea').wysihtml5({
          toolbar: { fa: true },
          useLineBreaks : true,
          })
      });
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

</script>
@endsection
