<?php 

	namespace app\controllers;
	use app\models\mainModel;
	use app\controllers\examController;

	class enunciadosController extends mainModel
	{


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

	 	 	$fieldsEnunciados =[ #CAMPOS DE REGISTRO DEL QUERY
	 	 		[
					"field_name"  =>"idExamen",
					"field_mark"  =>":MidExamen",
					"field_value" =>$registerExam[0]->idExamen
	 	 		],
	 	 		[
					"field_name"  =>"DescripcionEnunciado",
					"field_mark"  =>":MDescripcionEnunciado",
					"field_value" =>""
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
	 	 		$registerEnunciado=$this->queSP("SPEnunciados","Ins",$fieldsEnunciados);




	 	 		for ($j=0; $j < 4; $j++) { 

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
			 	 		],
			 	 		[
							"field_name"  =>"idRespuesta",
							"field_mark"  =>":MidRespuesta",
							"field_value" =>$Correcta
			 	 		]
			 	 	];

			 	 	

		 	 		$registerRespuestas=$this->queSP("SPRespuestas","Ins",$fieldsRespuestas);
	 	 		}

			}

	 	 	$Link = APP_URL."Examen/".$VidExam."/";

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

		public function EvaluarExamen()
		{


			$examController=new examController();
			$VidExam =$this->cleanString($_POST['idExam']);
			$Exam=$examController->getExam($VidExam);

			$Puntos=0;

			$CantidadEnunciados=$Exam[0]->CantEnunExamen;

			for ($i=0; $i < $CantidadEnunciados; $i++) { 
				$Input="flexRadioDefault".$i;

				if (!isset($_POST[$Input])) {

					$alert=[
						"type"  =>"msg",
						"title" =>"ERROR",
						"text"  =>"Debe Contestar todas las preguntas",
						"icon"  =>"danger",
						"focus" =>"Enunciado".$i
					];
					return json_encode($alert);
					exit();
				}

				foreach ($Exam as $Respuesta) {
					if ($Respuesta->idRespuesta==$_POST[$Input] && $Respuesta->CorrectaRespuesta) {
						$Puntos+=100/$CantidadEnunciados;
					}
				}
			}

			if ($Puntos<=50) {
				$icon="error";
				$text="";
			}elseif ($Puntos<=60) {
				$icon="warning";
				$text="";
			}elseif ($Puntos<100) {
				$icon="success";
				$text="";
			}else{
				$icon="success";
				$text="FELICIDADES!!";
			}

			$alert=[
				"type"     =>"pop-up",
				"title"    =>$text,
				"text"     =>$Puntos."/100",
				"icon"     =>$icon,
				"position" =>"center"
			];
			return json_encode($alert);
			exit();
	 	}

	 	public function updEnunciado()
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
	 	 	


	 	 	$registerExam=$this->queSP("SPExamenes","Get",$fieldsExamen);

	 	 	$fieldsExamen =[ #CAMPOS DE REGISTRO DEL QUERY
	 	 		[
					"field_name"  =>"idMaestro",
					"field_mark"  =>":MidMaestro",
					"field_value" =>""
	 	 		],
	 	 		[
					"field_name"  =>"NombreExamen",
					"field_mark"  =>":MNombreExamen",
					"field_value" =>$registerExam[0]->NombreExamen
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

	 	 	$cont=0;
			for ($i=0; $i < $registerExam[0]->CantEnunExamen; $i++) { 

				$fieldsEnunciados =[ #CAMPOS DE REGISTRO DEL QUERY
		 	 		[
						"field_name"  =>"idExamen",
						"field_mark"  =>":MidExamen",
						"field_value" =>0
		 	 		],
		 	 		[
						"field_name"  =>"DescripcionEnunciado",
						"field_mark"  =>":MDescripcionEnunciado",
						"field_value" =>$_POST['IEnunciado'.$i]
		 	 		],
		 	 		[
						"field_name"  =>"idEnunciado",
						"field_mark"  =>":MidEnunciado",
						"field_value" =>$registerExam[$cont]->idEnunciado
		 	 		]
		 	 	];
	 	 		$updEnunciado=$this->queSP("SPEnunciados","Upd",$fieldsEnunciados,false);




	 	 		for ($j=0; $j < 4; $j++) { 

	 	 			$Correcta = ($_POST['flexRadioDefault'.$i]==$i*10+$j)?true:false;

					$fieldsRespuestas =[ #CAMPOS DE REGISTRO DEL QUERY
			 	 		[
							"field_name"  =>"idEnunciado",
							"field_mark"  =>":MidEnunciado",
							"field_value" =>0
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
			 	 		],
			 	 		[
							"field_name"  =>"idRespuesta",
							"field_mark"  =>":MidRespuesta",
							"field_value" =>$registerExam[$cont]->idRespuesta
			 	 		]
			 	 	];

			 	 	

		 	 		$registerRespuestas=$this->queSP("SPRespuestas","Upd",$fieldsRespuestas,false);
		 	 		$cont++;
	 	 		}

			}

	 	 	$Link = APP_URL."Examen/".$VidExam."/";

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