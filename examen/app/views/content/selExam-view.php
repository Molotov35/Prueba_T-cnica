<?php 

use app\controllers\examController;
$dataExam= new examController;

if(!isset($_SESSION["Maestro"]->NombreMaestro) || $_SESSION['Maestro']->NombreMaestro==""){
  
  $Título="No se encuentra ningún Usuario Registrado";

}else{

  $Título="Bienvenido <i>".$_SESSION['Maestro']->NombreMaestro."</i>";

  $examList = $dataExam->selExam($_SESSION['Maestro']->idMaestro);

}
 ?>

<main>
  <section class="py-4 text-center <?php echo CONFIG_FORM; ?>">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">EXAMENES</h1>
        <p class="lead text-body-secondary"><?php echo $Título; ?></i> </p>
        <p>
          <a href="<?php echo APP_URL?>datExam/" class="btn NExamen"><i class="bi bi-plus-lg"></i> Nuevo Examen</a>
        </p>
      </div>
    </div>
  </section>

  <div class="album py-4 bg-body-tertiary">
    <div class="<?php echo CONFIG_FORM; ?>">

      <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 g-4">
        <?php foreach ($examList as $exam) {
          ?>

          <div class="col">
            <div class="card shadow-sm">
              <svg class="bd-placeholder-img card-img-top" width="100%" height="225" role="img" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em"><?php echo $exam->NombreExamen;  ?></text></svg>
              <div class="card-body">
                <p class="card-text">Actualizado: <u><?php echo date("d-m-Y h:i A",strtotime($exam->FechaActuExamen))?></u></p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <a href="<?php echo APP_URL."renameExam/".$exam->idExamen; ?>" class="btn btn-sm btn-outline-secondary">Renombrar</a>
                    <a href="<?php echo APP_URL."enunciadosUpd/".$exam->idExamen; ?>" class="btn btn-sm btn-outline-secondary">Modificar</a>
                    <!-- <a href="<?php echo APP_URL."Examen/".$exam->idExamen; ?>" class="btn btn-sm btn-outline-secondary">PDF</a> -->
                    <a href="<?php echo APP_URL."Examen/".$exam->idExamen; ?>" class="btn btn-sm btn-outline-secondary">Compartir</a>
                  </div>
                  <small class="text-body-secondary">X Terminados</small>
                </div>
              </div>
            </div>
          </div>

        <?php } ?>
      </div>


    </div>
  </div>

</main>
