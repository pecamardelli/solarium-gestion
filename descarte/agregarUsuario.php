<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	$access_level = 1;
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/allow.php";

	$nombre = $_REQUEST['nom'];
	$apellido = $_REQUEST['ap'];
	$dni = $_REQUEST['dni'];
	$dir = $_REQUEST['dir'];
	$celular = $_REQUEST['cel'];
	$rol = $_REQUEST['rol'];
	$email = $_REQUEST['email'];
	$user = $_REQUEST['user'];
	$pass = hash('sha256', $_REQUEST['pass']);
	$fecha = time();

	$query="SELECT * FROM usuarios WHERE userName='$user'";
	$check = mysqli_query($dbcon, $query);
	
	if(mysqli_num_rows($check) > 0){
		echo "EL USUARIO YA ESTA EN USO.";
		return false;
	}

	$query="INSERT INTO usuarios (idUsuario, username, password, usuarioNombre, usuarioApellido, usuarioDni, usuarioDir, usuarioCel, usuarioEmail, usuarioRol, fechaAlta, estado, observaciones)
			VALUES ('', '$user', '$pass', '$nombre', '$apellido', '$dni', '$dir', '$celular', '$email', '$rol', '$fecha', 'ACTIVO', '')";
	$result=mysqli_query($dbcon, $query);

	if(!$result){
		die('Consulta no válida: ' . mysqli_error($dbcon));
	}
	else{
		echo "OK";
	}
?>
