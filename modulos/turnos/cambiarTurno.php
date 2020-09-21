<?php
	#require_once($_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php");
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";
	require $_SERVER['DOCUMENT_ROOT'] . "sistema/clases/db.class.php";
	$db = new DB();
	$dbcon = $db->connect();

	$idTurno = $_REQUEST['id'];
	$state = $_REQUEST['estado'];
	$idDet = $_REQUEST['iddet'];
	$musica = $_REQUEST['musica'];
	$maqId = $_REQUEST['maqId'];
	$momento = date('Y-m-d H:i:s');
	$con_maq = "";

	$sql="SELECT	turnos.idCliente AS idCli,
					turnos.start AS start,
					turnos.idDetalle AS detalle,
					turnos.idMaq AS maq,
					clientes.nombreCliente AS nomcli,
					clientes.apellidoCliente AS apcli,
					maquinas.marcaMaq AS marcaMaq,
					maquinas.controller AS controller,
					maquinas.controllerOpt AS controllerOpt,
					config.charValue AS estadoMaq
					FROM turnos
					INNER JOIN clientes ON turnos.idCliente = clientes.idCliente
					INNER JOIN maquinas ON maquinas.idMaq = '$maqId'
					INNER JOIN config ON config.descConfig = 'estado_id_$maqId'
					WHERE turnos.idTurno='$idTurno'";
	$res = mysqli_query($dbcon, $sql) or die(mysqli_error($dbcon));
	$data = mysqli_fetch_array($res, MYSQLI_ASSOC);

	if($state == "TOMADO"){
		if(substr($data["estadoMaq"], 0, 11) == "FUNCIONANDO"){
			echo "BUSSY";
			exit(0);
		}
		
		$sql="SELECT	detalleVentas.idOpcion,
						opciones.nombreOp AS nombre
						FROM detalleVentas
						INNER JOIN opciones ON detalleVentas.idOpcion = opciones.idOpcion
						WHERE detalleVentas.idDetalle = $idDet";
		$res2 = mysqli_query($dbcon, $sql) or die(mysqli_error($dbcon));
		$data2 = mysqli_fetch_array($res2, MYSQLI_ASSOC);

		$query="SELECT intValue FROM config WHERE descConfig = 'tiempo_ventilacion'";
		$result=mysqli_query($dbcon, $query);
		$vent = mysqli_fetch_array($result, MYSQLI_NUM);

		$query="SELECT intValue FROM config WHERE descConfig = 'tiempo_iluminacion'";
		$result=mysqli_query($dbcon, $query);
		$ilum = mysqli_fetch_array($result, MYSQLI_NUM);

		$query="SELECT intValue FROM config WHERE descConfig = 'espera_turno'";
		$result=mysqli_query($dbcon, $query);
		$esp = mysqli_fetch_array($result, MYSQLI_NUM);
		$con_maq = "idMaq='$maqId',";
		switch($data['controller']){
			case "ARDUINO":
				$command = $_SERVER['DOCUMENT_ROOT'] . "sistema/asc/./asc turno $data2[nombre] $vent[0] $ilum[0] 1 $data[controllerOpt] $esp[0]";
				$output = shell_exec($command);
				logger("ARDUINO", $output . " - ID turno: " . $idTurno);

				if(strncmp($output, "ERROR", 5) == 0)
				{
					echo "NO SE ACTIVO EL TURNO\n\nRespuesta de Arduino:\n$output";
					exit(0);
				}
				else
				{
					#$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
					echo "TURNO TOMADO\nRespuesta de Arduino:\n$output";
				}
				break;
			case "RASPBERRY":
				$command = "ssh pi@$data[controllerOpt] 'bash /home/pi/Solarium/Scripts/turno.sh -d $data2[nombre] -v $vent[0] -i $ilum[0] -e $esp[0] -c $data[idCli] -t $idTurno'";
				#$output = shell_exec($command);
				#$output = "PANIC";
				logger("RASPBERRY", $data['controllerOpt'] . " - " . $output . " - ID turno: " . $idTurno);

				if(strncmp($output, "ERROR", 5) == 0)
				{
					echo "NO SE ACTIVO EL TURNO\n\nRespuesta de Raspberry:\n\n$command";
					exit(0);
				}
				else
				{
					#$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
					echo "TURNO TOMADO\n\nRespuesta de Raspberry:\n\n$output";
				}
				break;
			case "NINGUNO":
				echo "TURNO DE MASAJES TOMADO\n";
				break;
		}
	}
	else if($state == "CAMBIO-AGENDADO"){
		$command = "ssh pi@$data[controllerOpt] 'bash /home/pi/Solarium/Scripts/panic.sh'";
		$output = shell_exec($command);
		logger("RASPBERRY", $data['controllerOpt'] . " - " . $data['marcaMaq'] . " - " . $output . " - ID turno: " . $idTurno);
		$state = "AGENDADO";
	}

	if($state == "CANCELADO"){
		$query="DELETE FROM turnos WHERE idTurno='$idTurno'";
	}
	else{
		$query="UPDATE turnos SET $con_maq estado='$state', ultimoCambio='$momento', observaciones='Turno cambiado a $state en la fecha $momento' WHERE idTurno='$idTurno'";
	}
	
	$result=mysqli_query($dbcon, $query) or die('Consulta no válida: ' . mysqli_error($dbcon));
	$query = ("UPDATE detalleVentas SET estadoVenta='$state' WHERE idDetalle='$idDet'");
	$result=mysqli_query($dbcon, $query) or die('Consulta no válida: ' . mysqli_error($dbcon));
	logger("INFO", $_SESSION['user'] . " cambio el estado del turno del cliente " . $data['nomcli'] . " " . $data['apcli'] . " de la hora " . strftime("%R del dia %d-%m-%Y", ($data['start']/1000)) . " al estado " . $state);
?>
