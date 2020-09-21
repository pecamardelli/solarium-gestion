<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";

	$fecha = $_POST['fecha'];
	$cat = $_POST['cat'];
	$datos = $_POST['datos'];
	$obs = $_POST['obs'];

	$filtos = 0;
	$search = "";

	if($fecha != ""){
		$search = "fecha LIKE '%$fecha%'";
		$filtros++;
	}

	if($cat != "TODAS"){
		if($filtros > 0){
			$search = $search . " AND categoria='$cat'";
		}
		else{
			$search = $search . "categoria='$cat'";
		}
		$filtros++;
	}

	if($datos != ""){
		if($filtros > 0){
			$search = $search . " AND data LIKE '%$datos%'";
		}
		else{
			$search = $search . "data LIKE '%$datos%'";
		}
		$filtros++;
	}

	if($obs != ""){
		if($filtros > 0){
			$search = $search . " AND obs LIKE '%$obs%'";
		}
		else{
			$search = $search . "obs LIKE '%$obs%'";
		}
		$filtros++;
	}

	if($filtros == 0 && $cat == "TODAS"){
		$search = 1;
	}

	$query="SELECT * FROM log WHERE $search ORDER BY id DESC LIMIT 50";
	$result=mysqli_query($dbcon, $query);

	if(mysqli_num_rows($result)){
		while($fila = mysqli_fetch_array($result, MYSQLI_NUM)){
		$var = htmlspecialchars_decode($fila[4]);
		  echo "<tr class='reg'>
					<td>$fila[0]</td>
					<td>$fila[1]</td>
					<td>$fila[2]</td>
					<td>$fila[3]</td>
					<td>$var</td>
				</tr>";
		}
	}
?>