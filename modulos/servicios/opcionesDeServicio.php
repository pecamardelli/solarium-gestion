<?php
	require $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/servicios/servicios.class.php";

	$accion = $_POST['accion'];
	$args = $_POST['args'];
	$s = new Servicio();

	switch($accion){
		case 'agregar':
			echo $s->guardar($args);
			break;
		case 'editar':
			echo $s->formulario($args["id"]);
			break;
		case 'borrar':
			echo "borrar";
			break;
		case 'cargar':
			echo $s->guardar($args);
			break;
		case 'listar':
			echo $s->listarServicios();
			break;	
	}
?>
