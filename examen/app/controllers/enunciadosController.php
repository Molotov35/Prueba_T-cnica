<?php 

	namespace app\controllers;
	use app\models\mainModel;

	/**
	 * CONTROLADOR DE USUARIOS
	 */
	class enunciadosController extends mainModel
	{

		/**
		 * OBTIENE LA LISTA DE USUARIOS DE LA DB
		 */

		// public function selExam($VidMaestro)
		// {
		// 	$fields =[ #CAMPOS DE REGISTRO DEL QUERY
	 	//  		[
		// 			"field_name"  =>"idMaestro",
		// 			"field_mark"  =>":MidMaestro",
		// 			"field_value" =>$VidMaestro
	 	//  		],
	 	//  		[
		// 			"field_name"  =>"NombreExamen",
		// 			"field_mark"  =>":MNombreExamen",
		// 			"field_value" =>""
	 	//  		],
	 	//  		[
		// 			"field_name"  =>"CantEnunExam",
		// 			"field_mark"  =>":MCantEnunExam",
		// 			"field_value" =>""
	 	//  		],
	 	//  		[
		// 			"field_name"  =>"idExam",
		// 			"field_mark"  =>":MidExam",
		// 			"field_value" =>0
	 	//  		]
	 	//  	];
	 	//  	$registerExam=$this->queSP("SPExamenes","Whe",$fields);


	 	//  	return $registerExam;

		// }

		/**
		 * OBTIENE LA LISTA DE USUARIOS DE LA DB
		 */

		// public function Exam($VidExam)
		// {
		// 	$fields =[ #CAMPOS DE REGISTRO DEL QUERY
	 	//  		[
		// 			"field_name"  =>"idMaestro",
		// 			"field_mark"  =>":MidMaestro",
		// 			"field_value" =>""
	 	//  		],
	 	//  		[
		// 			"field_name"  =>"NombreExamen",
		// 			"field_mark"  =>":MNombreExamen",
		// 			"field_value" =>""
	 	//  		],
	 	//  		[
		// 			"field_name"  =>"CantEnunExam",
		// 			"field_mark"  =>":MCantEnunExam",
		// 			"field_value" =>""
	 	//  		],
	 	//  		[
		// 			"field_name"  =>"idExam",
		// 			"field_mark"  =>":MidExam",
		// 			"field_value" =>$VidExam
	 	//  		]
	 	//  	];
	 	//  	$registerExam=$this->queSP("SPExamenes","WId",$fields);


	 	//  	return $registerExam;

		// }

		public function insEnunciados()
		{




			$VidExam =$this->cleanString($_POST['idExam']);

			$fieldsExamen =[ #CAMPOS DE REGISTRO DEL QUERY
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
	 	 	
	 	 	$registerExam=$this->queSP("SPExamenes","WId",$fieldsExamen);
	 	 	// echo '<pre>'; print_r($registerExam); echo '</pre>';

			for ($i=0; $i < $registerExam[0]->CantEnunExamen; $i++) { 

				$fieldsEnunciados =[ #CAMPOS DE REGISTRO DEL QUERY
		 	 		[
						"field_name"  =>"idExamen",
						"field_mark"  =>":MidExamen",
						"field_value" =>$registerExam[0]->idExamen
		 	 		],
		 	 		[
						"field_name"  =>"DescripcionEnunciado",
						"field_mark"  =>":MDescripcionEnunciado",
						"field_value" =>$_POST['IEnunciado'.$i]
		 	 		],
		 	 		[
						"field_name"  =>"idEnunciado",
						"field_mark"  =>":MidEnunciado",
						"field_value" =>0
		 	 		]
		 	 	];
	 	 		$SelectEnunciados=$this->queSP("SPEnunciados","Sel",$fieldsEnunciados);

				if (!empty($SelectEnunciados)) {

					$alert=[
						"type"  =>"msg",
						"title" =>"ERROR",
						"text"  =>"Este examen ya tiene datos",
						"icon"  =>"danger"
					];
					return json_encode($alert);
					exit();
				}


	 	 		$registerEnunciado=$this->queSP("SPEnunciados","Ins",$fieldsEnunciados);




	 	 		for ($j=1; $j <= 4; $j++) { 

	 	 			$Correcta = ($_POST['flexRadioDefault'.$i]==$i*10+$j)?true:false;

					$fieldsRespuestas =[ #CAMPOS DE REGISTRO DEL QUERY
			 	 		[
							"field_name"  =>"idEnunciado",
							"field_mark"  =>":MidEnunciado",
							"field_value" =>$registerEnunciado[0]->idEnunciado
			 	 		],
			 	 		[
							"field_name"  =>"DescripcionRespuesta",
							"field_mark"  =>":MDescripcionRespuesta",
							"field_value" =>$_POST['inputcheckRespuesta'.$i.$j]
			 	 		],
			 	 		[
							"field_name"  =>"CorrectaRespuesta",
							"field_mark"  =>":MCorrectaRespuesta",
							"field_value" =>$Correcta
			 	 		]
			 	 	];

			 	 	

		 	 		$registerRespuestas=$this->queSP("SPRespuestas","Ins",$fieldsRespuestas);
	 	 		}





			}

		 	 	$Link = APP_URL."Menunciados/".$VidExam."/";

		 	 	$alert=[
						"type"  =>"redirect",
						"title"  =>"Guardado",
						"text" => "Datos GUardados Satisfactoriamente",
						"icon" =>"success",
						"url" => $Link
					];
				return json_encode($alert);
				exit();

		// 	$VNombreExamen =$this->cleanString($_POST['INombreExamen']);
		// 	$VCantEnunExam =(int)($this->cleanString($_POST['ICantEnunExam']));

		// 	if(!isset($_SESSION["Maestro"]->NombreMaestro) || $_SESSION['Maestro']->NombreMaestro==""){
  
		// 	  $VidMaestro=0;

		// 	}else{

		// 		$VidMaestro    =$this->cleanString($_SESSION['Maestro']->idMaestro);

		// 	}

		// 	// echo '<pre>'; print_r($_POST); echo '</pre>';

		// 	$fields =[ #CAMPOS DE REGISTRO DEL QUERY
	 	//  		[
		// 			"field_name"  =>"idMaestro",
		// 			"field_mark"  =>":MidMaestro",
		// 			"field_value" =>$VidMaestro
	 	//  		],
	 	//  		[
		// 			"field_name"  =>"NombreExamen",
		// 			"field_mark"  =>":MNombreExamen",
		// 			"field_value" =>$VNombreExamen
	 	//  		],
	 	//  		[
		// 			"field_name"  =>"CantEnunExam",
		// 			"field_mark"  =>":MCantEnunExam",
		// 			"field_value" =>$VCantEnunExam
	 	//  		],
	 	//  		[
		// 			"field_name"  =>"idExam",
		// 			"field_mark"  =>":MidExam",
		// 			"field_value" =>0
	 	//  		]
	 	//  	];

		// 	////////////////////////////////////////
		// 	///Verificación de campos obligatorio //
		// 	////////////////////////////////////////

		// 	if ($VNombreExamen=="" || empty($VNombreExamen)) {

		// 		$alert=[
		// 			"type"  =>"msg",
		// 			"title" =>"ERROR",
		// 			"text"  =>"Escribe el nombre del examen",
		// 			"icon"  =>"danger"
		// 		];
		// 		return json_encode($alert);
		// 		exit();
		// 	}
		// 	if ($VCantEnunExam=="" || empty($VCantEnunExam)) {

		// 		$alert=[
		// 			"type"  =>"msg",
		// 			"title" =>"ERROR",
		// 			"text"  =>"Escribe la cantidad de Enunciados que desea",
		// 			"icon"  =>"danger"
		// 		];
		// 		return json_encode($alert);
		// 		exit();
		// 	}
		// 	if ($VidMaestro==0) {

		// 		$alert=[
		// 			"type"     =>"pop-up",
		// 			"title"    =>"ERROR",
		// 			"text"     =>"No hay ningún Maestro Registrado",
		// 			"icon"     =>"error",
		// 			"position" =>"center-end" ,
		// 			"timer"    =>5
		// 		];
		// 		return json_encode($alert);
		// 		exit();
		// 	}

		// 	///////////////////////////////
		// 	///verificando datos válidos //
		// 	///////////////////////////////

		// 	if ($this->dataValid("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,20}",$VNombreExamen)) {
		// 		$alert=[
		// 			"type"  =>"msg",
		// 			"title" =>"ERROR",
		// 			"text"  =>"El NOMBRE no coincide con el formato establecido (No ingrese números)",
		// 			"icon"  =>"danger",
		// 			"focus" =>"INombreMaestro"
		// 		];
		// 		return json_encode($alert);
		// 		exit();
		// 	}

		// 	if ($VCantEnunExam>5 || $VCantEnunExam<1) {
		// 		$alert=[
		// 			"type"  =>"msg",
		// 			"title" =>"ERROR",
		// 			"text"  =>"La cantidad no coincide con el formato establecido",
		// 			"icon"  =>"danger",
		// 			"focus" =>"ICantEnunExam"
		// 		];
		// 		return json_encode($alert);
		// 		exit();
		// 	}


	 	//  	$registerExam=$this->queSP("SPExamenes","Ins",$fields);

	 	//  	if (empty($registerExam)) {
	 	//  		$alert=[
		// 			"type"     =>"pop-up",
		// 			"title"    =>"ERROR",
		// 			"text"     =>"No se ha podido registrar el Examen, intente nuevamente",
		// 			"icon"     =>"error",
		// 			"position" =>"center-end" ,
		// 			"timer"    =>5
		// 		];

		// 		return json_encode($alert);
		// 		exit();
	 	//  	}

	 	//  	$alert=[
		// 			"type"     =>"redirect",
		// 			"url"    =>APP_URL."enunciados/".$registerExam[0]->idExamen
		// 		];
		// 	return json_encode($alert);
		// 	exit();
		}
	 	 	
	}

	
 ?>