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

	  $examList = $dataExam->getExam($VidExamen);
	  $CantRespPosi = 4;
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
		 for ($i=0; $i <$examList[0]->CantEnunExamen ; $i++) { 
	  	$j=0;
		 	?>


	  <div class="accordion-item" >
	    <h2 class="accordion-header">
	      <button class="w-100 Enunciados" id="Enunciado<?php echo $i; ?>" type="button" data-bs-toggle="collapse"  aria-expanded="true" aria-controls="collapseOne">
	      	<label class="LblEnunciado" for="flexRadioDefault<?php echo $i.$j?>">

	      		<?php echo $i+1 . ". ".$examList[$cont]->DescripcionEnunciado; ?>
	      			
	      		</label>
	      </button>
	    </h2>
	    <div id="collapseOne" class="" data-bs-parent="#accordionExample">
	      <div class="accordion-body">

	      	<?php for ($j=0; $j < $CantRespPosi; $j++) { ?>

			    <div class="form-check">
					  <input class="form-check-input radioCheckRespuesta" type="radio" name="flexRadioDefault<?php echo $i;?>" id="flexRadioDefault<?php echo $i.$j?>" value="<?php echo $examList[$cont]->idRespuesta ?>">
					  <label type="text" class="" name="inputcheckRespuesta<?php echo $i ?>1" for="flexRadioDefault<?php echo $i.$j?>"><?php echo $examList[$cont]->DescripcionRespuesta; ?></label>
					</div>

				<?php 
					$cont++;	
	      	} ?>


	      </div>
	    </div>
	  </div>
		
		<?php } ?>
		<div id="divAlert"></div>
		<button type="submit" class="btn btn-primary m-2 ">Evaluar</button>
	</form>
	</div>
</div>