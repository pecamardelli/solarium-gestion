<?php
	require $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/clientes/clientes.class.php";

	$accion = $_POST['accion'];
	$args = $_POST['args'];
	$c = new Clientes();

	switch($accion){
		case 'agregar':
			echo $c->formulario();
			break;
		case 'editar':
			echo $c->formulario($args["id"]);
			break;
		case 'borrar':
			echo "borrar";
			break;
		case 'guardar':
			echo $c->guardarCliente($args);
			break;
		case 'listar':
			echo $c->listarClientes();
			break;
		case 'filtrar':
			echo $c->filtrarClientes($args);
			break;
		case 'buscar':
			echo $c->buscarCliente($args["nom"], $args["dni"]);
			break;
	}
?>
