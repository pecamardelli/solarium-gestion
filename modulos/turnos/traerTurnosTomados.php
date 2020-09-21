<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php");
require $_SERVER['DOCUMENT_ROOT'] . "sistema/clases/db.class.php";

$db = new DB();
$dbcon = $db->connect();

$clientId = $_REQUEST['idClient'];

$query="SELECT turnos.idTurno AS idturno,
			turnos.idDetalle AS iddetalle,
			turnos.start AS start,
			turnos.estado AS est,
			turnos.idMaq AS idMaq,
			turnos.observaciones AS turnosObs,
			turnos.ultimoCambio AS ultimoCambio,
			detalleVentas.idServicio AS idserv,
			detalleVentas.idOpcion AS idOp,
			servicios.descServ AS descr,
			clientes.nombreCliente AS nombre,
			clientes.apellidoCliente AS apellido,
			maquinas.marcaMaq AS maqMar,
			opciones.nombreOp AS mins
			FROM turnos
			INNER JOIN detalleVentas ON turnos.idDetalle = detalleVentas.idDetalle
			INNER JOIN servicios ON detalleVentas.idServicio = servicios.idServ
			INNER JOIN clientes ON clientes.idCliente = $clientId
			INNER JOIN maquinas ON turnos.idMaq = maquinas.idMaq
			INNER JOIN opciones ON detalleVentas.idOpcion = opciones.idOpcion
			WHERE (turnos.estado='AGENDADO' OR turnos.estado='TOMADO') AND turnos.idCliente='$clientId'
			ORDER BY turnos.idTurno DESC";
$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

	if(mysqli_num_rows($result) > 0){
		echo "<tr><td colspan='8'>TOTAL DE TURNOS TOMADOS: " . mysqli_num_rows($result) . "</td></tr>";
		while($fila = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$hora = new Datetime('@' . ($fila["start"]/1000));
			echo "<tr>
					<td>$fila[idturno]</td>
					<td>$fila[nombre] $fila[apellido]</td>
					<td>" . $hora->format('d-m-Y H:i:s') . "</td>
					<td>$fila[descr]</td>
					<td>$fila[maqMar]</td>
					<td>$fila[est]</td>
					<td>$fila[ultimoCambio]</td>
					<td>$fila[turnosObs]</td>
				</tr>";
		}
	}
	else{
		echo "EMPTY";
	}
?>
