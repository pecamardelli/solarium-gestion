<?php
	require $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/newsletter/newsletter.class.php";

	$accion = $_POST['accion'];
	$args = $_POST['args'];
	$n = new Newsletter();
	
	switch($accion){
		case 'cargar':
			echo $n->cargarNewsletter($args["id"]);
			break;
		case 'editar':
			echo $n->mostrarEditor();
			break;
		case 'enviar':
			echo $n->enviarNewsletter($args);
			break;
	}
?>
