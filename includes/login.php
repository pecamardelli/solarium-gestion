<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";
	$usuario = $_REQUEST["user"];
	$pass = hash('sha256', $_REQUEST["pass"]);

	$query = ("SELECT idUsuario, usuarioNombre, usuarioApellido, usuarioRol, usuarioTema, estado FROM usuarios WHERE userName='$usuario' AND password='$pass'");
	$result = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		if($row[5] == "ACTIVO"){
			session_start();
			$_SESSION['id'] = $row[0];
			$_SESSION['nombre'] = $row[1] . " " . $row[2];
			$_SESSION['user'] = $usuario;
			$_SESSION['rol'] = $row[3];
			$_SESSION['tema'] = $row[4];
			$_SESSION['logged'] = true;
			logger("SYSTEM","Usuario $usuario inicio sesion en el sistema");
			echo "OK";
		}
		else{
			logger("SYSTEM","Usuario $usuario en estado $row[5] intento acceder al sistema.");
			echo "EL USUARIO FUE $usuario";
		}
	}
	else{
		logger("WARNING","Usuario $usuario fallo el inicio de sesion.");
		echo "USUARIO O CONTRASEÑA INVÁLIDOS";
	}
?>
