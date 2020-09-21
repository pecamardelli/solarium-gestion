<?php 
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";

	$query="SELECT idMaq AS id, marcaMaq AS marca, controller AS cont, controllerOpt AS contOpt FROM maquinas WHERE (controller='ARDUINO' OR controller='RASPBERRY') AND estado='VIGENTE'";
	$result1=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

	echo "<table id='status_table' style='margin-top: 17px;'>";

	while($fila1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)){

		$query="SELECT charValue FROM config WHERE descConfig='estado_id_$fila1[id]'";
		$result2=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
		$data = "";

		while($fila2 = mysqli_fetch_array($result2, MYSQLI_NUM)){
			if(strncmp($fila2[0], "ERROR", 5) == 0){
				$data = array(
					0 => "ERROR",
					1 => "00:00",
					2 => "00:00",
					3 => "00:00",
					4 => "00:00"
				);
			}
			else{
				$data = explode(",", $fila2[0]);
			}
			echo"<tr>
					<td style='width: 100px; height: 20px; background:rgba(0,0,0,0); font-weight: bold;'>$fila1[marca]</td>
					<td style='width: 100px; height: 20px; background:rgba(0,0,0,0);'>$data[0]</td>
					<td style='width: 200px; height: 20px; background:rgba(0,0,0,0);'>TURNO $data[1] - $data[2]</td>
					<td style='width: 200px; height: 20px; background:rgba(0,0,0,0);'>VENT. $data[3] - $data[4]</td>";
			if($fila1['cont'] == "RASPBERRY"){
					$ip = explode(".", $fila1['contOpt']);
					echo "<td style='width: 100px; height: 20px; background:rgba(0,0,0,0);'><input type='button' onclick='power_off($ip[0],$ip[1],$ip[2],$ip[3])' value='Apagar' class='boton2'></td>";
			}
			echo "</tr>";
		}
	}

	echo "</table>";
?>
