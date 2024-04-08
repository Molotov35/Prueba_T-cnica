<?php 
  
  $VidExamen= (isset($url[1]) && $url[1]>0) ? (int) $url[1] : 0;

  if ($VidExamen==0){
    echo "<script>window.history.back()</script>";
  }
?>
<div class="modal modal-sheet position-static d-block">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-dark">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Nuevo Nombre</h1>
      </div>
      <div class="row p-5 pt-0">
        <form class="g-3 AjaxForm" method="POST" enctype="multipart/form-data" action="<?php echo APP_URL; ?>app/ajax/maestrosAjax.php" autocomplete="off">
          <input type="hidden" name="register" value="Upd">
          <input type="hidden" name="idExam" value="<?php echo $VidExamen; ?>">
          <input type="text" class="form-control rounded-3 bg-dark text-white" name="INombreExamen" id="INombreExamen" maxlength="20">
          <br>
          <div id="divAlert"></div>
          <div class="hstack gap-2">
            <button type="submit" class="btn btn-primary mr-5">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>