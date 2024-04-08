<?php 

	namespace app\controllers;
	use app\models\mainModel;

	/**
	 * CONTROLADOR DE USUARIOS
	 */
	class maestrosController extends mainModel
	{

		/**
		 * OBTIENE LA LISTA DE USUARIOS DE LA DB
		 */

		public function logMaestro()
		{
			$VNombreMaestro     =$this->cleanString($_POST['INombreMaestro']);
			

			$fields =[ #CAMPOS DE REGISTRO DEL QUERY
	 	 		[
					"field_name"  =>"NombreMaestro",
					"field_mark"  =>":MNombreMaestro",
					"field_value" =>$VNombreMaestro
	 	 		]
	 	 	];

			////////////////////////////////////////
			///Verificación de campos obligatorio //
			////////////////////////////////////////

			if ($VNombreMaestro=="" || empty($VNombreMaestro)) {

				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"Escribe el nombre del maestro",
					"icon"  =>"danger",
					"focus" =>"INombreMaestro"
				];
				return json_encode($alert);
				exit();
			}

			///////////////////////////////
			///verificando datos válidos //
			///////////////////////////////

			if ($this->dataValid("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,20}",$VNombreMaestro)) {
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

			/**
			 * VERIFICANDO EL USUSARIO
			 */
			
		

			$maestroValidate=$this->queSP("SPMaestros","Whe",$fields);

			if (!empty($maestroValidate)) {
				$alert=[
					"type"     =>"redirect",
					"url"      =>APP_URL."selExam/"
				];
				$_SESSION['Maestro']=$maestroValidate[0];
				return json_encode($alert);
				exit();
			}else{
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"No se Encuentra al Maestro ".$VNombreMaestro,
					"icon"  =>"danger",
					"focus" =>"INombreMaestro"
				];
				return json_encode($alert);
				exit();
			}
		}


		/**
		 *	CONTROLADOR PARA REGISTRAR USUARIOS
		 */
		public function registerMaestro()
		{

			//////////////////////////////////////////
			/// ALMACENAMIENTO DE DATOS DE USUARIOS //
			//////////////////////////////////////////

			$VNombreMaestro     =$this->cleanString($_POST['INombreMaestro']);


			$fields =[ #CAMPOS DE REGISTRO DEL QUERY
	 	 		[
					"field_name"  =>"NombreMaestro",
					"field_mark"  =>":MNombreMaestro",
					"field_value" =>$VNombreMaestro
	 	 		]
	 	 	];

			////////////////////////////////////////
			///Verificación de campos obligatorio //
			////////////////////////////////////////

			if ($VNombreMaestro=="" || empty($VNombreMaestro)) {

				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"Escribe el nombre del maestro",
					"icon"  =>"danger"
				];
				return json_encode($alert);
				exit();
			}

			///////////////////////////////
			///verificando datos válidos //
			///////////////////////////////

			if ($this->dataValid("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,20}",$VNombreMaestro)) {
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

			/**
			 * VERIFICANDO EL USUSARIO
			 */
			
		

			$maestroValidate=$this->queSP("SPMaestros","Whe",$fields);

			if (!empty($maestroValidate)) {
				$alert=[
					"type"  =>"msg",
					"title" =>"ERROR",
					"text"  =>"El MAESTRO que intenta registrar ya existe",
					"icon"  =>"warning",
					"focus" =>"INombreMaestro"
				];
				return json_encode($alert);
				exit();
			}


			

	 	 	$registerMaestro=$this->queSP("SPMaestros","Ins",$fields);

	 	 	if (empty($registerMaestro)) {
	 	 		$alert=[
					"type"     =>"pop-up",
					"title"    =>"ERROR",
					"text"     =>"No se ha podido registrar el usuario, intente nuevamente",
					"icon"     =>"error",
					"position" =>"center-end" ,
					"timer"    =>5
				];

				return json_encode($alert);
				exit();
	 	 	}

	 	 	$alert=[
					"type"     =>"redirect",
					"url"    =>APP_URL,
				];
			return json_encode($alert);
			exit();
		}


		public function updExamen()
		{
			$VidExam      =$this->cleanString($_POST['idExam']);
			$NombreExamen =$this->cleanString($_POST['INombreExamen']);


			$fieldsExamen =[ #CAMPOS DE REGISTRO DEL QUERY
	 	 		[
					"field_name"  =>"idMaestro",
					"field_mark"  =>":MidMaestro",
					"field_value" =>0
	 	 		],
	 	 		[
					"field_name"  =>"NombreExamen",
					"field_mark"  =>":MNombreExamen",
					"field_value" =>$NombreExamen
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

	 	 	$updExam=$this->queSP("SPExamenes","Upd",$fieldsExamen,false);

	 	 	$Link = APP_URL."selExam";

	 	 	$alert=[
					"type"  =>"redirect",
					"title"  =>"Guardado",
					"text" => "Datos GUardados Satisfactoriamente",
					"icon" =>"success",
					"url" => $Link
				];
			return json_encode($alert);
			exit();
		}
	 	 	
	}

	
 ?>