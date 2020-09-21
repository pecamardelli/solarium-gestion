<?php
	function logger($cat = "INFO", $data = "LOG VACIO", $obs = ""){
		global $dbcon;
		
		/*
		$query = "SHOW COLUMNS FROM `log` LIKE 'categoria'";
		$results = mysqli_query($dbcon, $sql);
		$row = mysqli_fetch_array($results, MYSQLI_ASSOC);
		
		if ($sentencia = mysqli_prepare($dbcon, $query)) {

			
			mysqli_stmt_execute($sentencia);

			mysqli_stmt_bind_result($sentencia, $columna);

			$row=mysqli_stmt_fetch_array($sentencia);
		}
		
		$type = $row['Type'];
		preg_match('/enum\((.*)\)$/', $type, $matches);
		$vals = explode(',', $matches[1]);

		foreach($vals as $item){
			$item=trim($item, "'");
			if($item == $cat){
				$cat_ok = true;
				break;
			}
		}
		*/
		$cat_ok = false;
		$query = " SHOW COLUMNS FROM `log` LIKE 'categoria' ";
		$result = mysqli_query($dbcon, $query );
		$row = mysqli_fetch_array($result , MYSQLI_NUM );
		#extract the values
		#the values are enclosed in single quotes
		#and separated by commas
		$regex = "/'(.*?)'/";
		preg_match_all( $regex , $row[1], $enum_array );
		$enum_fields = $enum_array[1];

		foreach($enum_fields as $item){
			if( $item == $cat){
				$cat_ok = true;
				break;
			}
		}

		if(!$cat_ok){
			$obs = "Categoria desconocida ($cat).";
			$cat = "WARNING";
		}

		$query="INSERT INTO log (categoria, data, obs) VALUES ('$cat','$data','$obs')";
		mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
	}
?>