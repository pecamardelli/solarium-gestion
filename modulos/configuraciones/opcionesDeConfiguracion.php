<?php
	require $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "sistema/clases/aplicaciones.class.php";

	$accion = $_POST['accion'];
	$args = $_POST['args'];

	switch($accion){
		case 'mostrar':
			$a = new Aplicaciones();
			echo $a->mostrarConfig();
			break;
		case 'guardar':
			$a = new Aplicaciones();
			echo $a->guardarConfig($args);
			break;
	}
?>
