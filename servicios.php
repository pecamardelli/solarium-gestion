<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<script type="text/javascript" src="componentes/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
	<script type="text/javascript" src="modulos/servicios/js/opcionesDeServicio.js"></script>
	<script type="text/javascript">
		function check(datos){ 
			if(datos.nombre.value == "" ||
				datos.desc.value == "" ||
			  	datos.tipoServ.selectedIndex == 0){
				alert('COMPLETAR NOMBRE, DESCRIPCION Y TIPO.');
				return false;
			}
		}

		function del(id) {
			var rol = "<?php echo $_SESSION['rol']; ?>";
			if(rol > 2){
				alert("ERROR: No tiene permisos para eliminar elementos." );
				return false;
			}

			var nombre = document.getElementById(id + '-servName').innerHTML;
			var descripcion = document.getElementById(id + '-servDesc').innerHTML;
			if (confirm('ATENCION! SE BORRARA EL SIGUIENTE SERVICIO:\n\n' + nombre + ' - ' + descripcion + '\n\nCONTINUAR?')) {
				$.ajax({
					url: "modulos/servicios/borrarServicio.php",
					type: "POST",
					data: { 'ids': id },                   
					success: function(request)
								{
									alert(request);
									window.location = "servicios.php";
								}
				});
			}
		}
	</script>
	<script type="text/javascript" src="componentes/jscolor/jscolor.js"></script>
	<head>
		<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/titulo.php";?>
	</head>
	
	<body id="body">

		<?php
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/header.php";
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/menu.php";
		?>

		<center>
			<?php
				require $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/servicios/servicios.class.php";
				$serv = new Servicio();
				echo $serv->formulario();
				
				echo "<hr>";
				
				echo $serv->listarServicios();
			
			?>
		</center>
		
		<div id="footer">
			<?php
				include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/footer.php";
			?>
		</div>
	</body>
</html>
