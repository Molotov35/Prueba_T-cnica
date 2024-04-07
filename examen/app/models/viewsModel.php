<?php 
	
	namespace app\models;

	/**
	 * MODELO DE CONTROLADOR DE VISTAS
	 */
	class viewsModel
	{
		

		protected function getModelViews($view)
		{
			$witheList = [	"HOME",
							"teacherInsert",
							"selExam",
							"datExam",
							"enunciados",
							"Examen",
							"enunciadosUpd"
						];


			if (in_array($view, $witheList) && is_file("app/views/content/".$view."-view.php")) {
				$content = "app/views/content/".$view."-view.php";
			}elseif ($view=="INDEX" || $view=="index") {
				$content = "HOME";
			}elseif (!is_file("app/views/content/".$view."-view.php")) {
				$content = "404";
			}elseif (!in_array($view, $witheList)) {
				$content = "403";
			}

			return $content;

		}
	}













 ?>