<?php  
	
	require_once "config/app.php";
	require_once "autoload.php";
	require_once "app/views/inc/session_start.php";
	
	if (isset($_GET['views'])) {
		$url=explode("/", $_GET['views']);
	} else {
		$url=["HOME"];
	}

 ?>

 <!DOCTYPE html>
 <html lang="es" data-bs-theme="light">
 <head>
 	<?php require_once "app/views/inc/head.php"; ?>
 </head>
 <body class="text-white  bg-secondary">

 	<?php 

 		// echo '<pre>'; print_r($_SESSION); echo '</pre>';

 		use app\controllers\viewsController;
 		use app\controllers\maestrosController;

 		$insLogin = new maestrosController();
 		$viewsController = new viewsController();
 		
 		$view = $viewsController->getControllerViews($url[0]);

 		if ($view=="404" || $view=="403") {
 			require_once "app/views/content/".$view."-view.php";
 		} else {


 			require_once $view;
 		}

 	 	require_once "app/views/inc/script.php";

 	 ?>
 </body>
 </html>

