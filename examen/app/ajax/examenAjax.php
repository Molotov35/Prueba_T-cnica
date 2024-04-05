<?php 

	
	require_once "../../config/app.php";
	require_once "../views/inc/session_start.php";
	require_once "../../autoload.php";

	use app\controllers\examController;

	if (isset($_POST['register'])) {

		$examController=new examController();
		
		if($_POST['register']=="Ins"){
			echo $examController->insExam();
		}

	}



 ?>