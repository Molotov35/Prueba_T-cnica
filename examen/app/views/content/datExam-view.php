<div class="modal modal-sheet position-static d-block">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-dark">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Agregar Examen</h1>
      </div>
      <div class="row p-5 pt-0">
        <form class="g-3 AjaxForm" method="post" enctype="multipart/form-data" action="<?php echo APP_URL; ?>app/ajax/examenAjax.php" autocomplete="off">
          <input type="hidden" name="register" value="Ins">
          <label for="INombreExamen" class="form-label is-required">Nombre del Examen</label>
          <input type="text" class="form-control rounded-3 bg-dark text-white" name="INombreExamen" id="INombreExamen">
          <label for="ICantEnunExam" class="form-label is-required">Cantidad de Enunciados</label>
          <input type="number" class="form-control rounded-3 bg-dark text-white" name="ICantEnunExam" id="ICantEnunExam" max="5" min="1">
          <label for="ICantEnunExam" class="form-label text-white-50">(Máximo 5 Enunciados)</label>
          <br>
          <div id="divAlert"></div>
          <div class="hstack gap-2">
            <button type="submit" class="btn btn-primary mr-5">Ingresar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>