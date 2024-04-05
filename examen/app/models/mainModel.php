<?php 
	
	namespace app\models;
	use \PDO;

	if(file_exists(__DIR__."/../../config/server.php")){
		require_once __DIR__."/../../config/server.php";
	}

	/**
	 * MODELOS PRINCIPALES
	 */
	class mainModel
	{

		private $server = DB_SERVER;
		private $db = DB_NAME;
		private $user = DB_USER;
		private $pass = DB_PASS;
		private $port = DB_PORT;

		
		protected function conect()
		{
			
			try {
				$link = new PDO("mysql:hos=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
			    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
			    die("Connection failed: " . $e);
			}
		    
		    return $link;

		}

		protected function execQue($query,$dataReturn=true)
		{
			$sql=$this->conect()->prepare($query);
			$sql->execute();

			if ($dataReturn) {
				return $sql -> fetchAll(PDO::FETCH_CLASS);
			} else {
				return $sql;
			}

		}


		public function cleanString($string)
		{
			$blackList = ["<script>","</script>","<script src","<script type=","SELECT * FROM","SELECT "," SELECT ","DELETE FROM","INSERT INTO","DROP TABLE","DROP DATABASE","TRUNCATE TABLE","SHOW TABLES","SHOW DATABASES","<?php","?>","--","^","<",">","==","=",";","::","EXECUTE","EXEC"];

			$string = trim($string);
			$string = stripcslashes($string);

			foreach ($blackList as $word) {
				$string = str_ireplace($word, "", $string);
			}

			$string = trim($string);
			$string = stripcslashes($string);

			if(empty($string)){
				$string="";
			}

			return $string;

		}

		protected function dataValid($filter, $string)
		{
			if (preg_match("/^".$filter."$/", $string)) {
				return false;
			} else {
				return true;
			}
			
		}


		protected function queSP($SP,$type,$fields,$dataReturn=true)
		{
			$SP=$this->cleanString($SP);
			foreach ($fields as $field) {
				$field["field_value"]=$this->cleanString($field["field_value"]);
			}

			$query="Call $SP ('$type' ";

			$cont=0;
			foreach ($fields as $field) {
				$query.= ",".$field["field_mark"];
			}

			$query.=")";
			
			$sql=$this->conect()->prepare($query);

			foreach ($fields as $field) {
				$sql->bindParam($field["field_mark"],$field["field_value"]);
			}

			$sql->execute();

			if ($dataReturn) {
				return $sql -> fetchAll(PDO::FETCH_CLASS);
			} else {
				return $sql;
			}
			
		}
}
 ?>