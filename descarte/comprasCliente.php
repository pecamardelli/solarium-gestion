<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";

	$idCliente = $_POST['idCliente'];
	$start = $_POST['start'];

	$query="SELECT detalleVentas.idDetalle,
				detalleVentas.idServicio,
				detalleVentas.idOpcion,
				servicios.descServ,
				opciones.descOp
				FROM detalleVentas
				INNER JOIN servicios ON detalleVentas.idServicio = servicios.idServ
				INNER JOIN opciones ON detalleVentas.idOpcion = opciones.idOpcion
				WHERE idCliente='$idCliente' AND (estadoVenta='NO TOMADO' OR estadoVenta='CANCELADO')";
	$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

	echo "<hr><table cellpadding='3px' id='table1'>";

	if(mysqli_num_rows($result)){
		echo "<tr><td colspan='4' style='font-weight: bold;'>SERVICIOS SIN TOMAR: " . mysqli_num_rows($result) . "</td></tr>";
		
		while($fila = mysqli_fetch_array($result, MYSQLI_NUM)){
			$query="SELECT idMaq, marcaMaq, modeloMaq FROM maquinas WHERE idServicio='$fila[1]' AND estado='VIGENTE'";
			$result2=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
			
			echo "<tr>
					<td id='$fila[0]-servicio' style='width: 150px;'>$fila[3]</td>
					<td id='$fila[0]-opcion' style='width: 150px;'>$fila[4]</td>
					<td id='$fila[0]-maquina' style='width: 150px;'>
						<select name='maq' id='$fila[0]-maqList'>";
			while($fila2 = mysqli_fetch_array($result2, MYSQLI_NUM)){
					echo "<option name='$fila2[0]'>$fila2[1] $fila2[2]</option>";
			}
			
			echo "		</select>
					</td>
					<td style='width: 150px;'><input type='button' onclick='agendar($fila[0])' value='Agendar' class='boton2'></td>
				</tr>";
		}
	}
	else{
		echo "<tr><td style='width: 400px;'>No hay compras pendientes de este cliente.</td></tr>";
	}
	echo "</table>";
?>
