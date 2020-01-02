<form action="{{route('recetaPaciente')}}" method="POST" id="formularioReceta" target="_blank">
    @csrf
  <div class="modal fade" id="nuevaReceta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header modal-header-info">
          <h5 class="modal-title" id="exampleModalLabel">Crear Receta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="doctor_id" value="{{Auth::user()->doctor_id}}" >
            <input type="hidden" name="paciente_id" id="paciente_id" value="{{$paciente->id}}">
            <label >Seleccione una plantilla</label>
            <div class="row">
                <div class="col-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="plantilla_id" id="plantilla1" value="1" checked style="display:none">
                        <label class="form-check-label" id="receta1" for="plantilla1"><img src="{{asset('recetas/plantilla1.png')}}" alt="" height="150" width="100" class="img-pointer"></label>

                    </div>
                </div>
                <div class="col-3">
                    <div class="col-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="plantilla_id" id="plantilla2" value="2" style="display:none">
                            <label class="form-check-label receta2" id="receta2" for="plantilla2"><img src="{{asset('recetas/plantilla2.png')}}" alt="" height="150" width="100" class="img-pointer"></label>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="col-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="plantilla_id" id="plantilla3" value="3" style="display:none">
                            <label class="form-check-label receta3" id="receta3" for="plantilla3"><img src="{{asset('recetas/plantilla3.png')}}" alt="" height="150" width="100" class="img-pointer"></label>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="col-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="plantilla_id" id="plantilla5" value="5" style="display:none">
                            <label class="form-check-label" id="receta4" for="plantilla5"><img src="{{asset('recetas/plantilla5.png')}}" alt="" height="150" width="100" class="img-pointer"></label>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <div class="form-group">
              <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Titulo de la receta" required>
            </div>
            <div class="form-group">
              <textarea class="form-control textarea receta" id="receta" name="receta"  placeholder="Receta..." required></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <div class="form-group pull-right">
            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-sm btn-primary" onclick="enviado()">Guardar Receta</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
