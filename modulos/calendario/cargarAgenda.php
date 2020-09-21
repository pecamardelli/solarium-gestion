<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php");
require $_SERVER['DOCUMENT_ROOT'] . "sistema/clases/db.class.php";
$db = new DB();
$dbcon = $db->connect();
$hoy = getdate();
$date = new DateTime();
$date->modify("-1 month");
$start = (($date->format('U') * 1000));

$query="SELECT turnos.idTurno AS idturno,
			turnos.idDetalle AS iddetalle,
			turnos.start AS start,
			turnos.end AS end,
			turnos.estado AS est,
			turnos.idMaq,
			turnos.observaciones AS turnosObs,
			detalleVentas.idServicio AS idserv,
			detalleVentas.idOpcion,
			servicios.idServ AS idServ,
			servicios.eventColor AS color,
			servicios.descServ AS descr,
			clientes.nombreCliente AS nombre,
			clientes.apellidoCliente AS apellido,
			clientes.balance AS bal,
			(SELECT marcaMaq FROM maquinas WHERE idMaq = turnos.idMaq) AS maqMar,
			(SELECT modeloMaq FROM maquinas WHERE idMaq = turnos.idMaq) AS maqMod,
			(SELECT color FROM maquinas WHERE idMaq = turnos.idMaq) AS maqColor,
			opciones.nombreOp AS mins
			FROM turnos
			INNER JOIN detalleVentas ON turnos.idDetalle = detalleVentas.idDetalle
			INNER JOIN servicios ON detalleVentas.idServicio = servicios.idServ
			INNER JOIN clientes ON detalleVentas.idCliente = clientes.idCliente
			INNER JOIN opciones ON detalleVentas.idOpcion = opciones.idOpcion
			WHERE (turnos.estado='AGENDADO' OR turnos.estado='TOMADO') AND turnos.start>='$start'";
$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

if(mysqli_num_rows($result)){
	$event_array = array();
	while($fila = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		$var = $fila['start']/1000;
		$dt = new DateTime("@$var");
		$dt_start=$dt->format('Y-m-d\TH:i:s');
		$var = $fila['end']/1000;
		$dt = new DateTime("@$var");
		$dt_end=$dt->format('Y-m-d\TH:i:s');


		if($fila['nombre'] == "GENERICO"){
			$client = "SIN PAGO - " . $fila['turnosObs'];
		}
		else{
			$client = $fila['nombre'] . " " . $fila['apellido'];
		}

		if($fila['est'] == 'TOMADO'){
			$titulo = $client . " " . $fila['est'];
			$maqMar = $fila['maqMar'];
			$maqMod = $fila['maqMod'];
			$eventColor = '#' . $fila['maqColor'];
		}
		else{
			$titulo = $client;
			$maqMar = "";
			$maqMod = "";
			$eventColor = '#' . $fila['color'];
		}

		$event_array[] = array(
			'id' => $fila['idturno'],
			'title' => $titulo,
			'start' => $dt_start,
			'end' => $dt_end,
			'color' => $eventColor,
			'cliente' => $client,
			'desc' => $fila['descr'],
			'maqMar' => $maqMar,
			'maqMod' => $maqMod,
			'mins' => $fila['mins'],
			'iddetalle' => $fila['iddetalle'],
			'balance' => $fila['bal'],
			'idServ' => $fila['idServ'],
			'estado' => $fila['est']
			);
	}
echo json_encode($event_array);
}
?>
