<?php 

	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";

	use app\controllers\enunciadosController;

	if (isset($_POST['register'])) {

		$enunciadosController=new enunciadosController();
		
		if($_POST['register']=="Ins"){
			echo $enunciadosController->insEnunciados();
		}
		if($_POST['register']=="Res"){
			echo $enunciadosController->EvaluarExamen();
		}

	}



 ?>