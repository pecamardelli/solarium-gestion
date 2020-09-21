<?php
// DB.class.php
	class DB {

		protected $db_name = 'solarium';
		protected $db_user = 'solarium';
		protected $db_pass = 'solarium';
		protected $db_host = 'localhost';

		// Open a connect to the database.
		// Make sure this is called on every page that needs to use the database.

		public function connect(){
			$dbcon = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);

			if (mysqli_connect_errno()){
				printf("Connection failed: %s", mysqli_connect_error());
				exit();
			}
			
			return $dbcon;
		}
		
		public function showColumns($from, $like){
			$dbcon = $this->connect();
			$sql = "SHOW COLUMNS FROM `$from` LIKE '$like'";
			$result = mysqli_query($dbcon, $sql) or die('Consulta no válida: ' . mysqli_error($dbcon));
			$row = mysqli_fetch_array($result , MYSQLI_NUM);
			$regex = "/'(.*?)'/";
			preg_match_all($regex , $row[1], $enum_array);
			return $enum_array[1];			
		}
		
		public function getConfig($tipo, $donde){
			$dbcon = $this->connect();
			$sql = "SELECT $tipo FROM config WHERE $donde";
			$result = mysqli_query($dbcon, $sql) or die('Consulta no válida: ' . mysqli_error($dbcon));
			
			if(mysqli_num_rows($result) > 0){
				$row = mysqli_fetch_array($result , MYSQLI_NUM);
				return $row[0];
			}
			else{
				return "ERROR: No se encontró la configuración solicitada.";
			}
		}
		
		public function setConfig($tipo, $valor, $descConfig){
			$dbcon = $this->connect();
			$sql = "UPDATE config SET $tipo='$valor' WHERE descConfig='$descConfig'";
			$result = mysqli_query($dbcon, $sql) or die('Consulta no válida: ' . mysqli_error($dbcon));
			return "OK";
		}
	}
?>
