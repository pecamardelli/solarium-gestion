<?php
	require $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/ventas/ventas.class.php";

	$accion = $_POST['accion'];
	$args = $_POST['args'];
	$v = new Ventas();

	switch($accion){
		case 'agregar':
			$servIds = $_POST['servsIds'];
			$opIds = $_POST['opsIds'];
			$cants = $_POST['cantidades'];
			$precios = $_POST['precios'];
			$desc = $_POST['descuentos'];
			$subs = $_POST['subTotales'];

			$prodsIds = $_POST['prodIds'];
			$cantsProds = $_POST['cantsProd'];
			$preciosProds = $_POST['preciosProd'];
			$stocksProds = $_POST['stocksProd'];
			$descsProds = $_POST['descsProd'];
			$subsProds = $_POST['subsProd'];

			$cliente = $_POST['cliente'];
			$totalServ = $_POST['totServ'];
			$totalProd = $_POST['totProd'];
			$total = $totalServ + $totalProd;
			$fpago = $_POST['formapago'];
			$hay_serv = $_POST['hay_serv'];
			$hay_prod = $_POST['hay_prod'];
			$usar_bal = $_POST['usar_bal'];
			$bal = $_POST['bal'];

			$obs = $_POST['obs'];
			echo $v->formulario();
			break;
		case 'editar':
			echo $v->formulario($args["id"]);
			break;
		case 'borrar':
			echo "borrar";
			break;
		case 'guardar':
			echo $v->guardarCliente($args);
			break;
		case 'listar':
			echo $v->listarClientes();
			break;
		case 'filtrar':
			echo $v->filtrarClientes($args);
			break;
	}
?>
