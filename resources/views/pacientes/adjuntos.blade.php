<form id="adjuntoss" method="POST" action="{{route('subirAdjuntos')}}" enctype="multipart/form-data">
@csrf
<div class="modal fade modal-xl" id="adjunto" tabindex="-1" role="dialog" aria-labelledby="adjuntos" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Subir Archivo</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="paciente_id"  value="{{$paciente->id}}">
                <div class="form-group">
                        <textarea name="descripcion" class="form-control textarea"  cols="30" rows="10"></textarea>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="file" id="file" required onchange="showPreview()" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf">
                            <label class="custom-file-label" name="file" id="nombrefile" for="labelName">Seleccionar Archivo</label>
                        </div>
                </div>
                <div style="display:none" id="progreso">
                    <p>Por favor espere mientas se sube el archivo</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" id="barraProgreso">0 %</div>
                    </div>
                </div>
                <img src="" class="rounded" width="200" height="200" alt="" id="prueba"/>
          </div>
          <div class="modal-footer">
              <div class="form-group">
                  <a href="{{route('pacientes.show', $paciente->id)}}" class="btn btn-secondary btn-sm" >Cancelar</a>
                  <button type="button" class="btn btn-sm btn-primary " id="submit" onclick="compressAndUpload(this.form.file.value)">Guardar</button>
              </div>
          </div>
        </div>
      </div>
</form>
