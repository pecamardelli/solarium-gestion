<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/titulo.php"; ?>
		<script type="text/javascript" src="componentes/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
		<script type="text/javascript" src="modulos/clientes/js/clientes.js"></script>
	</head>
	
	<body id="body">

		<?php
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/header.php";
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/menu.php";
		?>

		<div id='user1'>
			<?php 
				require $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/clientes/clientes.class.php";
				$c = new Clientes();
				$c->listarClientes();
			?>
		</div>
		<div id="footer">
			<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/footer.php"; ?>
		</div>
	</body>
</html>
