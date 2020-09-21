<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";
	
	session_start();

	$id = $_REQUEST['userId'];
	$nombre = $_REQUEST['nom'];
	$apellido = $_REQUEST['ap'];
	$dni = $_REQUEST['dni'];
	$dir = $_REQUEST['dir'];
	$celular = $_REQUEST['cel'];
	$email = $_REQUEST['email'];
	$rol = $_REQUEST['rol'];
	$tema = $_REQUEST['tema'];
	$estado = $_REQUEST['estado'];
	$pass = $_REQUEST['pass'];
	$usuario = $_REQUEST['user'];

	if($pass != "NULL"){
		$passChg = "password='" . hash('sha256', $pass) . "',";
	}
	else{
		$passChg = "";
	}

	if($id == $_SESSION['id']){
		$_SESSION['nombre'] = $nombre . " " . $apellido;
		$_SESSION['tema'] = $tema;
	}
	
	$query = "SELECT COUNT(*) FROM usuarios WHERE idUsuario != $id AND userName = '$usuario'";
	$result=mysqli_query($dbcon, $query);

	if(!$result){
		die('Consulta no válida: ' . mysqli_error($dbcon));
		logger("ERROR", "Consulta no válida: " . mysqli_error($dbcon));
	}
	else{
		$fila = mysqli_fetch_array($result);
		if($fila[0] == 0){
			$query = "UPDATE usuarios SET
				$passChg
				userName='$usuario',
				usuarioNombre='$nombre',
				usuarioApellido='$apellido',
				usuarioDni='$dni',
				usuarioDir='$dir',
				usuarioCel='$celular',
				usuarioEmail='$email',
				usuarioTema='$tema',
				usuarioRol='$rol',
				estado='$estado'
				WHERE idUsuario='$id'";
			$result=mysqli_query($dbcon, $query);

			if(!$result){
				die('Consulta no válida: ' . mysqli_error($dbcon));
				logger("ERROR", "Consulta no válida: " . mysqli_error($dbcon));
			}
			else{
				logger("INFO", $_SESSION['user'] . " cambio datos de $usuario: $nombre, $apellido, $dni, $dir, $celular, $email, $tema, $rol, $estado");
				echo "OK";
			}
		}
		else{
			echo "EL USUARIO YA ESTÁ EN USO";
		}
	}
?>
