<?php 
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	$access_level = 3;
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/allow.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/titulo.php";?>
		<script type="text/javascript" src="componentes/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
		<script type="text/javascript" src="modulos/configuraciones/js/configuraciones.js"></script>
	</head>
	
	<body id="body">

		<?php
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/header.php";
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/menu.php";
		?>

		<div id='contenedor'>
			<center>
				<table style="background-color:rgba(0, 0, 0, 0);">
					<tr>
						<td style="background-color:rgba(0, 0, 0, 0);">
							<a href='usuarios.php'>
								<img id='imgEffects' src='imagenes/boton_usuarios.png'>
							</a>
						</td>
						<td style="background-color:rgba(0, 0, 0, 0);">
							<img id='imgEffects' src='imagenes/boton_opciones.png' onClick='mostrarConfiguraciones()'>
						</td>
						<td style="background-color:rgba(0, 0, 0, 0);">
							<a href='newsletter.php'>
								<img id='imgEffects' src='imagenes/boton_newsletter.png'>
							</a>
						</td>
					</tr>
				</table>
			</center>
		</div>
		<div id="footer">
			<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/footer.php";?>
		</div>
	</body>
</html>
