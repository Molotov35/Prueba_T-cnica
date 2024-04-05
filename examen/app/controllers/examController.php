<?php 

	namespace app\controllers;
	use app\models\mainModel;

	/**
	 * CONTROLADOR DE USUARIOS
	 */
	class examController extends mainModel
	{

		/**
		 * OBTIENE LA LISTA DE USUARIOS DE LA DB
		 */

		public function selExam($VidMaestro)
		{
			$fields =[ #CAMPOS DE REGISTRO DEL QUERY
	 	 		[
					"field_name"  =>"idMaestro",
					"field_mark"  =>":MidMaestro",
					"field_value" =>$VidMaestro
	 	 		],
	 	 		[
					"field_name"  =>"NombreExamen",
					"field_mark"  =>":MNombreExamen",
					"field_value" =>""
	 	 		],
	 	 		[
					"field_name"  =>"CantEnunExam",
					"field_mark"  =>":MCantEnunExam",
					"field_value" =>""
	 	 		],
	 	 		[
					"field_name"  =>"idExam",
					"field_mark"  =>":MidExam",
					"field_value" =>0
	 	 		]
	 	 	];
	 	 	$registerExam=$this->queSP("SPExamenes","Whe",$fields);


	 	 	return $registerExam;

		}

		/**
		 * OBTIENE LA LISTA DE USUARIOS DE LA DB
		 */

		public function Exam($VidExam)
		{
			$fields =[ #CAMPOS DE REGISTRO DEL QUERY
	 	 		[
					"field_name"  =>"idMaestro",
					"field_mark"  =>":MidMaestro",
					"field_value" =>""
	 	 		],
	 	 		[
					"field_name"  =>"NombreExamen",
					"field_mark"  =>":MNombreExamen",
					"field_value" =>""
	 	 		],
	 	 		[
					"field_name"  =>"CantEnunExam",
					"field_mark"  =>":MCantEnunExam",
					"field_value" =>""
	 	 		],
	 	 		[
					"field_name"  =>"idExam",
					"field_mark"  =>":MidExam",
					"field_value" =>$VidExam
	 	 		]
	 	 	];
	 	 	$registerExam=$this->queSP("SPExamenes","WId",$fields);


	 	 	return $registerExam;

		}


		/**
		 *	CONTROLADOR PARA REGISTRAR USUARIOS
		 */
		public function insExam()
		{

			//////////////////////////////////////////
			/// ALMACENAMIENTO DE DATOS DE USUARIOS //
			//////////////////////////////////////////

			$VNombreExamen =$this->cleanString($_POST['INombreExamen']);
			$VCantEnunExam =(int)($this->cleanString($_POST['ICantEnunExam']));

			if(!isset($_SESSION["Maestro"]->NombreMaestro) || $_SESSION['Maestro']->NombreMaestro==""){
  
			  $VidMaestro=0;

			}else{

				$VidMaestro    =$this->cleanString($_SESSION['Maestro']->idMaestro);

			}

			// echo '<pre>'; print_r($_POST); echo '</pre>';

			$fields =[ #CAMPOS DE REGISTRO DEL QUERY
	 	 		[
					"field_name"  =>"idMaestro",
					"field_mark"  =>":MidMaestro",
					"field_value" =>$VidMaestro
	 	 		],
	 	 		[
					"field_name"  =>"NombreExamen",
					"field_mark"  =>":MNombreExamen",
					"field_value" =>$VNombreExamen
	 	 		],
	 	 		[
					"field_name"  =>"CantEnunExam",
					"field_mark"  =>":MCantEnunExam",
					"field_value" =>$VCantEnunExam
	 	 		],
	 	 		[
					"field_name"  =>"idExam",
					"field_mark"  =>":MidExam",
					"field_value" =>0
	 	 		]
	 	 	];

			////////////////////////////////////////
			///Verificación de campos obligatorio //
			////////////////////////////////////////

			if ($VNombreExamen=="" || empty($VNombreExamen)) {

				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"Escribe el nombre del examen",
					"icon"  =>"danger"
				];
				return json_encode($alert);
				exit();
			}
			if ($VCantEnunExam=="" || empty($VCantEnunExam)) {

				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"Escribe la cantidad de Enunciados que desea",
					"icon"  =>"danger"
				];
				return json_encode($alert);
				exit();
			}
			if ($VidMaestro==0) {

				$alert=[
					"type"     =>"pop-up",
					"title"    =>"ERROR",
					"text"     =>"No hay ningún Maestro Registrado",
					"icon"     =>"error",
					"position" =>"center-end" ,
					"timer"    =>5
				];
				return json_encode($alert);
				exit();
			}

			///////////////////////////////
			///verificando datos válidos //
			///////////////////////////////

			if ($this->dataValid("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,20}",$VNombreExamen)) {
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"El NOMBRE no coincide con el formato establecido (No ingrese números)",
					"icon"  =>"danger",
					"focus" =>"INombreMaestro"
				];
				return json_encode($alert);
				exit();
			}

			if ($VCantEnunExam>5 || $VCantEnunExam<1) {
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"La cantidad no coincide con el formato establecido",
					"icon"  =>"danger",
					"focus" =>"ICantEnunExam"
				];
				return json_encode($alert);
				exit();
			}


	 	 	$registerExam=$this->queSP("SPExamenes","Ins",$fields);

	 	 	if (empty($registerExam)) {
	 	 		$alert=[
					"type"     =>"pop-up",
					"title"    =>"ERROR",
					"text"     =>"No se ha podido registrar el Examen, intente nuevamente",
					"icon"     =>"error",
					"position" =>"center-end" ,
					"timer"    =>5
				];

				return json_encode($alert);
				exit();
	 	 	}

	 	 	$alert=[
					"type"     =>"redirect",
					"url"    =>APP_URL."enunciados/".$registerExam[0]->idExamen
				];
			return json_encode($alert);
			exit();
		}

		public function ResponderExamen($VidExam)
		{

	 	 	$DatosExamen=$this->execQue("Select * from examenes ex JOIN enunciados en ON ex.idExamen=en.idExamen JOIN respuestas r on r.idEnunciado=en.idEnunciado where ex.idExamen=".$VidExam);


	 	 	return $DatosExamen;

		}
	 	 	
	}

	
 ?>