@extends('theme.lte.layout')
@section('styles')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="sweetalert2.all.min.js"></script>
<style>
  
 table > tbody > tr {
    cursor: pointer;    
}

table > tbody > tr:hover{
            background-color: #99ccff;
        }
.idinventario{
    display: none;
}
</style>
@endsection
@section('contenido')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header border-primary">
                <div class="row">
                    <div class="col">
                          <a href="" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#nuevoMedicamento">NUEVO MEDICAMENTO/INSUMO</a>
                          <a href="{{route('inventarios.ventamenu')}}" class="btn btn-sm btn-primary">CREAR VENTA</a>
                    </div>
                    <div class="col">
                        <h5 class="pull-right text-uppercase">
                           Inventario
                        </h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($inventario->count()>0)
                <div class="table-responsive">
                  <table class="table table-sm table-bordered" width="30.3cm" id="inventario" >
                    <thead class="text-uppercase bg-info">
                        <tr>
                            <th style="display:none">id</th>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Concentracion</th>
                            <th>Fabricante</th>
                            <th>Stock</th>
                            <th>Costo</th>
                            <th>precio</th>
                            <th>precio con IVA</th>
                            <th>Fecha expiracion</th>
                            <th >Acciones</th>
                        </tr>
                    </thead>                                               
                </table>
                </div>
                @endif               
            </div>
        </div>
    </div>
    @include('Inventario.nuevoMedicamento')
    @include('Inventario.agregarstock')  
@endsection
@section('scripts')
  <script>        
      $(document).ready(function() {
        $('#inventario').DataTable( {
            language: {
               "decimal": "",
               "emptyTable": "No hay información",
               "info": "Mostrando _START_ a _END_ de _TOTAL_  Medicamentos",
               "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
               "infoFiltered": "(Filtrado de _MAX_  total  Medicamentos)",
               "infoPostFix": "",
               "thousands": ",",
               "lengthMenu": "Mostrar _MENU_  Medicamentos",
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
            "ajax": "{{route('inventarios.listatable')}}",
            "columns": [
                { "data": "id", "visible":true, className: "idinventario" },               
                { "data": "codigo", "orderable":false, className: "text-center inventario priority-1" },
                { "data": "nombre", className: "nombre inventario"},
                { "data": "Consentracion", className: "Consentracion inventario"},
                { "data": "fabricante", className: "apellidos inventario"},
                { "orderable": false, "data": "stock", className: "text-center inventario"},
                {  "data": "costo","orderable":false, className: "text-center inventario priority-1"},
                { "orderable":false, "data": "precio", className: "text-center inventario priority-1"},
                { "orderable":false, "data": "precioiva", className: "text-center inventario priority-1"},                
                {  "data": "fecha_exp","orderable":false, className: "text-center inventario priority-1"},
                { "orderable": false,"data": "btn", className: "text-center" },
            ],
        } );

        $('#inventario tbody').on('click', '.inventario', function () {
         
            var codigo = $(this).siblings('.idinventario').html();                   
            window.location="{{route('inventarios.index')}}"+'/'+codigo;
        } );    
       
    });
    function test(valor){              
       $("#agregarstock").modal("show");        
       $("#medicamento_id").val(valor);
      }
    function probando(){ 
        var cantidad = $('#cantidad').val();
        if(cantidad != ""){
        document.getElementById('cantidad').classList.remove("is-invalid");
        var proveedor = $('#proveedor').val();
        if(proveedor != ""){
            document.getElementById('proveedor').classList.remove("is-invalid");
            var fechain = $('#fechain').val();
            if(fechain != ""){
                document.getElementById('fechain').classList.remove("is-invalid");
                var fechaout = $('#fechaexp1').val();
                if(fechaout != ""){
                        var fechaexpp =document.getElementById('fechaexp1').value;
                        var dato = moment(fechaexpp);    
                        var now = moment();
                        var compare = moment(dato).isAfter(now);
                    if(compare == true){
                        document.getElementById('fechaexp1').classList.remove("is-invalid");
                        var fechainn =document.getElementById('fechain').value;
                        var fecha = moment(fechainn);    
                        var ahora = moment();
                        var compare2 = moment(fecha).isAfter(ahora);
                      if(compare2 == true){
                        $('#addstock').submit();
                      }else{
                        document.getElementById('fechain').focus;
                        document.getElementById('fechain').classList.add("is-invalid"); 
                      }
                }else{
                    document.getElementById('fechaexp1').focus;
                    document.getElementById('fechaexp1').classList.add("is-invalid"); 
                    }
                }else{
                    document.getElementById('fechaexp1').focus;
                    document.getElementById('fechaexp1').classList.add("is-invalid");
                }
            }else{
                document.getElementById('fechain').focus;
                document.getElementById('fechain').classList.add("is-invalid");
            }
        }else{
            document.getElementById('proveedor').focus;
            document.getElementById('proveedor').classList.add("is-invalid")
        }
        }else{
        document.getElementById('cantidad').focus;
        document.getElementById('cantidad').classList.add("is-invalid");
        }
    }
    function envio(){
     var  cod = $('#codigomedicamento').val();
       if(cod != ""){
        document.getElementById('codigomedicamento').classList.remove("is-invalid"); 
          var nombre = $('#nombremedicamento').val();
        if(nombre != ""){
          document.getElementById('nombremedicamento').classList.remove("is-invalid"); 
            var concentracionp = $('#nombremedicamento').val();
          if(concentracionp != ""){
            document.getElementById('concentracionc').classList.remove("is-invalid"); 
              var fabri = $('#fabricantemedicamento').val();
            if(fabri != ""){
              document.getElementById('fabricantemedicamento').classList.remove("is-invalid"); 
                  var tock = $('#stock').val();
              if(tock != ""){
                document.getElementById('stock').classList.remove("is-invalid"); 
                       var coss = $('#costo').val();
                  if(coss != ""){
                    document.getElementById('costo').classList.remove("is-invalid"); 
                           var precioinput = $('#precio').val();
                      if(precioinput != ""){
                        document.getElementById('precio').classList.remove("is-invalid"); 
                               var fechaexpp = $('#fechaexp').val();                               
                          if(fechaexpp != ""){
                              var dato = moment(fechaexpp);                        
                              var now = moment();
                              var compare = moment(dato).isAfter(now);
                              if(compare == true){
                                  document.getElementById('fechaexp').classList.remove("is-invalid"); 
                                  var numero = $('#concentracionc').val();
                                  var medida = $('#concentracionm').val();
                                  var concentracion = numero+" "+medida;
                                  document.getElementById('concentracion').value = concentracion; 
                                  var porcentaje = $('#precio').val();        
                                  var porreal = porcentaje /100; 
                                  if(porreal == 1){
                                      document.getElementById('precio').focus;
                                      document.getElementById('precio').classList.add("is-invalid");
                                      document.getElementById('precio').value = "";
                                      Swal.fire({
                                        position: 'top-end',
                                        icon: 'error',
                                        title: 'Porcentaje no valido',
                                        showConfirmButton: false,
                                        timer: 1000
                                    });
                                  }else{
                                  var costo = $('#costo').val();  
                                  var precio = costo/(1-porreal);
                                  var precioreal = precio.toFixed(2);
                                  if(precioreal <0){
                                    precioreal = precioreal*-1;
                                  }                                 
                                  document.getElementById('precio').value = precioreal;
                                  var poriva = precioreal*1.13;
                                  var porivareal = poriva.toFixed(2);
                                  document.getElementById('precioiva').value = porivareal;                                                                                        
                                  $('#addmedicamento').submit();
                                }
                              }else{
                                document.getElementById('fechaexp').focus();
                                document.getElementById('fechaexp').classList.add("is-invalid"); 
                              }
                          }else{
                            document.getElementById('fechaexp').focus();
                            document.getElementById('fechaexp').classList.add("is-invalid"); 
                          }
                      }else{
                        document.getElementById('precio').focus();
                        document.getElementById('precio').classList.add("is-invalid"); 
                      }     
                  }else{
                    document.getElementById('costo').focus();
                    document.getElementById('costo').classList.add("is-invalid"); 
                  }
              }else{
                document.getElementById('stock').focus();
                document.getElementById('stock').classList.add("is-invalid"); 
              }    
            }else{
              document.getElementById('fabricantemedicamento').focus();
              document.getElementById('fabricantemedicamento').classList.add("is-invalid"); 
            }
          }else{
            document.getElementById('concentracionc').focus();
            document.getElementById('concentracionc').classList.add("is-invalid"); 
          }
        }else{
          document.getElementById('nombremedicamento').focus();
          document.getElementById('nombremedicamento').classList.add("is-invalid"); 
        }
       }else{
         document.getElementById('codigomedicamento').focus();
         document.getElementById('codigomedicamento').classList.add("is-invalid"); 
       }
      }
  </script>
@endsection