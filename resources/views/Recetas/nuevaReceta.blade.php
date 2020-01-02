<div class="modal fade " id="nuevaReceta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h4><strong>Añadir Receta</strong></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('createReceta')}}" method="POST">
                @csrf
                <input type="hidden" name="_method" value="POST">
                <input type="hidden" name="doctor_id" value="{{Auth::user()->doctor_id}}">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <select class="form-control" name="paciente_id">
                          <option selected value="">Añadir paciente (opcional)...</option>
                          @foreach($pacientes as $paciente)
                          <option value="{{$paciente->id}}" >{{$paciente->nombre.' '.$paciente->apellidos}}</option>
                          @endforeach
                        </select>
                        <div class="input-group-append">
                          <label class="input-group-text" for="inputGroupSelect02">Pacientes</label>
                        </div>
                    </div>
                </div>
                <label class="d-none d-md-block" >Seleccione una plantilla</label>
                <div class="row">
                    <div class="col-3 d-none d-md-block">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="plantilla_id" id="plantilla1" value="1" style="display:none" checked>
                            <label class="form-check-label" id="receta1" for="plantilla1"><img src="{{asset('recetas/plantilla1.png')}}" alt="" height="150" width="100" class="img-pointer"></label>

                        </div>
                    </div>
                    <div class="col-3 d-none d-md-block">
                        <div class="col-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="plantilla_id" id="plantilla2" value="2" style="display:none">
                                <label class="form-check-label" id="receta2" for="plantilla2"><img src="{{asset('recetas/plantilla2.png')}}" alt="" height="150" width="100" class="img-pointer"></label>
                            </div>
                        </div>
                    </div>
                   
                             
                <div class="col-3 d-none d-md-block">
                        <div class="col-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="plantilla_id" id="plantilla3" value="3" style="display:none" >
                                <label class="form-check-label" id="receta3" for="plantilla3"><img src="{{asset('recetas/plantilla3.png')}}" alt="" height="150" width="100" class="img-pointer"></label>
                            </div>
                        </div>
                  </div>             
             <div class="col-3 d-none d-md-block">
                <div class="col-3">
                    <div class="form-check">
                            <input class="form-check-input" type="radio" name="plantilla_id" id="plantilla5" value="5" style="display:none">
                            <label class="form-check-label" id="receta4" for="plantilla5"><img src="{{asset('recetas/plantilla5.png')}}" alt="" height="150" width="100" class="img-pointer"></label>
                    </div>
                </div>
             </div>
         </div>
             <br>
             
                {{-- <div class="form-group">
                    <select class="" >
                        @foreach ($pacientes as $paciente)
                        <option data-subtext="{{$paciente->id}}">{{$paciente->nombre.' '.$paciente->apellidos}}</option>
                        @endforeach
                    </select>
                </div> --}}
                <div class="form-group">
                    <label> Titulo de receta</label>
                    <input type="text" class="form-control" name="tituloReceta" id="titulo" placeholder="" required>
                </div>
                <div class="form-group">
                    <textarea class="form-control textarea receta" id="receta" name="descripcionReceta"  placeholder="Receta..." required></textarea>
                </div><br>

        </div>
        <div class="modal-footer">
                <div class="form-group pull-right">
                    <a href="{{route('pacientes.index')}}" class="btn  btn-secondary" data-dismiss="modal">Cancelar</a>
                    <button type="submit" class="btn  btn-primary"  >Guardar Receta</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>


