 <?php 
 	use app\controllers\examController;
 	$dataExam = new examController();

 	$VidExamen= (isset($url[1]) && $url[1]>0) ? (int) $url[1] : 0;

 	if ($VidExamen==0){
 		echo "<script>window.history.back()</script>";
 	}

	if(!isset($_SESSION["Maestro"]->NombreMaestro) || $_SESSION['Maestro']->NombreMaestro==""){
	  
	  $Título="No se encuentra ningún Usuario Registrado";

	}else{

	  $Título="<i>".$_SESSION['Maestro']->NombreMaestro."</i>";

	  $examList = $dataExam->ResponderExamen($VidExamen);
	  // echo '<pre>'; print_r($examList); echo '</pre>';

	  



}


  ?>
 <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light"><?php echo $examList[0]->NombreExamen; ?></h1>
        <p class="lead text-body-secondary"><?php echo $Título ?></p>
      </div>
    </div>
  </section>
          <div id="divAlert"></div>

<div class="m-5">
	<div class="accordion" id="accordionExample">
		<form class="g-3  AjaxForm" method="post" enctype="multipart/form-data" action="<?php echo APP_URL; ?>app/ajax/enunciadosAjax.php" autocomplete="off">
			<input type="hidden" name="register" value="Res">
			<input type="hidden" name="idExam" value="<?php echo $VidExamen; ?>">

		<?php
		$cont=0;
		 for ($i=0; $i <$examList[0]->CantEnunExamen ; $i++) { ?>


	  <div class="accordion-item">
	    <h2 class="accordion-header">
	      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
	      	<label><?php echo $i+1; ?> <?php echo $examList[$cont]->DescripcionEnunciado; ?></label>
	      </button>
	    </h2>
	    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
	      <div class="accordion-body">

	      	<?php for ($j=0; $j < 4; $j++) { ?>

			    <div class="form-check">
					  <input class="form-check-input radioCheckRespuesta" type="radio" name="flexRadioDefault<?php echo $i;  ?>" id="flexRadioDefault" value="<?php echo $i.$j ?>" checked>
					  <label type="text" class="" name="inputcheckRespuesta<?php echo $i ?>1"><?php echo $examList[$cont]->DescripcionRespuesta; ?></label>
					</div>

				<?php 
					$cont++;	
	      	} ?>


	      </div>
	    </div>
	  </div>
		
		<?php } ?>
		<button type="submit" class="btn btn-primary mr-5">Guardar</button>
	</form>
	</div>
</div>