<?php 

	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";

	use app\controllers\maestrosController;

	if (isset($_POST['register'])) {

		$maestrosController=new maestrosController();
		
		if($_POST['register']=="Ins"){
			echo $maestrosController->registerMaestro();
		}

		if($_POST['register']=="Sel"){
			echo $maestrosController->logMaestro();
		}
		if($_POST['register']=="Upd"){
			echo $maestrosController->updExamen();
		}


		

	}



 ?>