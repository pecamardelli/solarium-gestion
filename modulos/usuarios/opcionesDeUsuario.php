<?php
	require $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/usuarios/usuario.class.php";

	$accion = $_POST['accion'];
	$args = $_POST['args'];

	switch($accion){
		case 'agregar':
			$u = new Usuario();
			echo $u->formulario();
			break;
		case 'editar':
			$u = new Usuario();
			echo $u->formulario($args["id"]);
			break;
		case 'borrar':
			echo "borrar";
			break;
		case 'cargar':
			#$args = explode(",", $args);
			#print_r($args);
			$u = new Usuario();
			echo $u->guardar($args);
			break;
		case 'listar':
			$u = new Usuario();
			echo $u->listarUsuarios();
			break;	
	}
?>
