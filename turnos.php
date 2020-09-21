<?php require $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/titulo.php"; ?>
		<script type="text/javascript" src="componentes/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
		<script type="text/javascript" src="modulos/turnos/js/turnos.js"></script>
	</head>
	
	<body id="body">
			<?php
				include "includes/header.php";
				include "includes/menu.php";
				echo "<input type='hidden' id='start' value='" . $_REQUEST['start'] . "'>
						<input type='hidden' id='end' value='" . $_REQUEST['end'] . "'>";
			?>
				<center>
				<table cellpadding="3px" id="table1">
					<tr>
						<td colspan='3' style="font-weight: bold;">ASIGNACIÓN DE TURNO</td>
					</tr>
		        	<tr>
						<td>Seleccionar Cliente</td>
						<td style='width: 400px;'>
		              	NOMBRE: <input type="text" id="name" name="nombreCli" size="16" maxlength="24" value="" onKeyPress='return enter(event)'>
		            	DNI: <input type="text" id="dni" name="doc" size='10' maxLength="16" value="" onKeyPress='return enter(event)'>
		          	</td>
		          	<td>
							<input type="button" value="buscar" class='boton2' onClick="buscar()">
						</td>
					</tr>
		          <tr>
		              <td colspan='3'>
		                  <div id="encontrado"></div>
		              </td>
		          </tr>
		      </table>

			<div id='comprasCliente'></div>

			</center>		

			<div id="footer">
				<?php
					include "includes/footer.php";
				?>
			</div>
	</body>
</html>
