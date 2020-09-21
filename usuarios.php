<?php 
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	$access_level = 3;
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/allow.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
	<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/titulo.php";?>
		<script type="text/javascript" src="componentes/jquery-1.5.2/jquery.min.js"></script>
		<script type="text/javascript" src="modulos/usuarios/js/usuarios.js"></script>
	</head>	
	<body id="body">
		<?php
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/header.php";
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/menu.php";
		?>
		<div id='user1'>
			<?php 
				require $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/usuarios/usuario.class.php";
				$users = new Usuario();
				$users->listarUsuarios();
			?>
		</div>
		<div id="footer">
			<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/footer.php"; ?>
		</div>
	</body>
</html>
