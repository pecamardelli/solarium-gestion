		
<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	$month = $_REQUEST['mes'];
	$anio = $_REQUEST['anio'];
	$meses = array("NULL", "ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
	$dias = array("NULL", "Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
	$hoy = getdate();
	
	if(!$anio){
		$anio = $hoy['year'];
	}

	if(!$month){
		$month = $hoy['mon'];
		if($hoy['mon'] < 10){
			$mes = "0$hoy[mon]";
		}
		else{
			$mes = $hoy['mon'];
		}
		
	}
	else{
		if($month < 10){
			$mes = "0$month";
		}
		else{
			$mes = $month;
		}
	}

	if($month == $hoy['mon']){
		$dias = $hoy['mday'];
	}
	else{
		$dias = cal_days_in_month(CAL_GREGORIAN, $month, $anio);
	}

	$query = "SHOW COLUMNS FROM `turnos` LIKE 'estado'";
	$result = mysqli_query($dbcon, $query );
	$row = mysqli_fetch_array($result , MYSQLI_NUM );
	$regex = "/'(.*?)'/";
	preg_match_all( $regex , $row[1], $enum_array );
	$enum_fields = $enum_array[1];
	$fields = ((count($enum_fields)+1));

	echo "<div style='width: 40%; float: left;'><center>
				<table id='table1'>
				<tr style='font-weight: bold;'>
					<td colspan='$fields'>TURNOS DEL MES DE " .  $meses[$month] . " DE $anio</td>
				</tr>
				<tr style='font-weight: bold;'><td>FECHA</td>";

	foreach($enum_fields as $item){
		echo "<td>$item</td>";
		$items[$item] = 0;
	}

	echo "</tr>";

	for($k=1; $k<=$dias; $k++){
		if($k <= 9){
			$dia = "0$k";
		}
		else{
			$dia = $k;
		}

		$date = new DateTime($mes . '/' . $dia . '/' . $anio); // format: MM/DD/YYYY
		$date1 = (($date->format('U') * 1000));
		$date2 = (($date1 + 84600000));

		echo "<tr><td>$hoy[year]-$mes-$dia</td>";

		foreach($enum_fields as $item){
			$query="SELECT COUNT(*) AS cant FROM turnos WHERE start >= '$date1' AND start <= '$date2' AND estado='$item'";
			$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
			$fila = mysqli_fetch_array($result, MYSQLI_NUM);
			echo "<td style='width: 100px;'>$fila[0]</td>";
			$items[$item] = (($items[$item] + $fila[0]));
		}
		echo "</tr>";
	}

	/*if($items['TOMADO'] >= $items['CANCELADO']){
		$items['TOMADO'] = (($items['TOMADO'] - $items['CANCELADO']));
	}*/

	echo "<tr style='font-weight: bold;'>
					<td>TOTAL</td>";

	foreach($enum_fields as $item){
		echo "<td>$items[$item]</td>";
	}

	$query="SELECT idMaq AS id, marcaMaq AS marca FROM maquinas WHERE 1";
	$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
#							$fila = mysqli_fetch_array($result, MYSQLI_NUM);

	echo "</table>
				</center>
			</div>
			<div style='width: 30%; float: left;'>
				<center>
					<table id='table1' style='align: left'>
						<tr style='font-weight: bold;'>
							<td colspan='" . ((mysqli_num_rows($result)+1)) . "'>TURNOS POR MÁQUINA EN " .  $meses[$month] . " DE $anio</td>
						</tr>
						<tr style='font-weight: bold;'>
							<td style='width: 100px;'>FECHA</td>";
	$ids = array();

	while($fila = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		echo "<td style='width: 100px;'>$fila[marca]</td>";
		array_push($ids, $fila['id']);
	}

	echo "</tr>";

	for($k=1; $k<=$dias; $k++){
		if($k <= 9){
			$dia = "0$k";
		}
		else{
			$dia = $k;
		}

		$date = new DateTime($mes . '/' . $dia . '/' . $anio); // format: MM/DD/YYYY
		$date1 = (($date->format('U') * 1000));
		$date2 = (($date1 + 84600000));

		echo "<tr><td>$hoy[year]-$mes-$dia</td>";

		foreach($ids as $item){
			$query="SELECT
					SUM(CASE WHEN estado = 'TOMADO' THEN 1 ELSE 0 END) AS tom
					FROM turnos WHERE start >= '$date1' AND start <= '$date2' AND idMaq='$item'";
			$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
			$fila = mysqli_fetch_array($result, MYSQLI_ASSOC);

			if(!$fila['tom']){
				$fila['tom'] = 0;
			}

			echo "<td style='width: 100px;'>$fila[tom]</td>";
			$total[$item] = (($total[$item] + $fila['tom']));
		}
	}

	echo "</tr><tr style='font-weight: bold;'><td>TOTAL</td>";

	foreach($total as $item){
		echo "<td>$item</td>";
		$total_turnos = (($total_turnos + $item));
	}

	echo "</tr>
		  <tr style='font-weight: bold;'>
			<td colspan='3'>PROMEDIO DIARIO</td>
			<td colspan='2'>" . round((($total_turnos / $dias))*100)/100 . "</td>
		</tr>
	</table>
	</center>
</div>
<div style='width: 30%; float: right;'>
	<center>
		<table id='table1' style='align: left'>
			<tr style='font-weight: bold;'>
				<td colspan='3'>VENTAS DEL MES DE " .  $meses[$month] . " DE $anio</td>
			</tr>
			<tr style='font-weight: bold;'>
				<td>FECHA</td><td>CANTIDAD</td><td>TOTAL $</td>
			</tr>";


	$query="SELECT DATE(fechaVenta) AS fecha, COUNT(*) AS cantidad, SUM(montoTotal) AS total FROM ventas WHERE fechaVenta >= '$anio-$mes-01' AND fechaVenta <= '$anio-$mes-$dias 23:59:59' GROUP BY fecha";
	$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
	$total_gral = 0;
	while($fila = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		echo "<tr>
					<td style='width: 100px;'>$fila[fecha]</td>
					<td style='width: 100px;'>$fila[cantidad]</td>
					<td style='width: 100px;'>$$fila[total]</td>
				</tr>";
		$total_ventas = (($total_ventas + $fila[cantidad]));
		$total_gral = (($total_gral + $fila[total]));
	}

	echo "<tr style='font-weight: bold;'>
				<td>TOTAL</td>
				<td>$total_ventas</td>
				<td>$$total_gral</td>
			</tr>
			<tr style='font-weight: bold;'>
				<td>PROMEDIO</td>
				<td>" . round((($total_ventas/$dias))*100)/100 . "</td>
				<td>$" . round((($total_gral/$dias))*100)/100 . "</td>
			</tr>
			</table>
	</center>
	</div>";
?>
