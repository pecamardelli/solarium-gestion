<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";

	$id = $_POST['ids'];
	$tipo = $_POST['tipo'];
	$accion = $_POST['accion'];
	
	switch ($tipo) {
		case "servicios":
			$tabla = "servicios";
			$ident = "idServ";
			$est = "VIGENTE";
			break;
		case "productos":
			$tabla = "productos";
			$ident = "idProd";
			$est = "VIGENTE";
			break;
		case "opciones":
			$tabla = "opciones";
			$ident = "idOpcion";
			$est = "VIGENTE";
			break;
		case "clientes":
			$tabla = "clientes";
			$ident = "idCliente";
			$est = "ACTIVO";
			break;
		case "maquinas":
			$tabla = "maquinas";
			$ident = "idMaq";
			$est = "VIGENTE";
			break;
	}
	
	if($accion == "recuperar"){
		$query = ("UPDATE $tabla SET estado='$est' WHERE $ident='$id'");
		$result=mysqli_query($dbcon, $query);
		logger("INFO", $_SESSION['user'] . " recupero de $tabla el elemento con id $id");
		$action = "RECUPERADO";
	}
	else{
		$query = ("DELETE FROM $tabla WHERE $ident='$id'");
		$result=mysqli_query($dbcon, $query);
		logger("INFO", $_SESSION['user'] . " elimino definitivamente de $tabla el elemento con id $id");
		$action = "ELIMINADO";
	}

	if (!$result) {
		die('Consulta no válida: ' . mysqli_error($dbcon));
	}
	else{
		echo "ELEMENTO $action CORRECTAMENTE";
	}
?>
