<?php 
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	$access_level = 3;
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/allow.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/titulo.php";?>
		<script type="text/javascript" src="componentes/jquery-ui-1.11.4/external/jquery/jquery.js"></script>		
		<script>
			function act(){
				var mes = $('#listaMeses').find(":selected").val();
				var anio = $('#listaAnios').find(":selected").val();
				$.ajax ({
					url: 'modulos/estadisticas/tablaEstadisticas.php',	/* URL a invocar asíncronamente */
					type:  'post',											/* Método utilizado para el requerimiento */
					data: 	{ 'mes': mes, 'anio': anio },		/* Información local a enviarse con el requerimiento */
					success: 	function(request)
					{
						$('#container').html(request);
					}
				});
			}
		</script>		
	</head>	
	<body id="body">
		<?php
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/header.php";
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/menu.php";
		?>
		<div>
			<center>
				<a href="estadisticas.php"><input type='button' class="boton2" value="GRAFICOS"></a>
				<a href="estadisticas2.php"><input type='button' class="boton2" value="TABLAS"></a>
				<br><hr>
			</center>
		</div>
		<div>
			<center>
				<table id='table1'>
					<tr style='font-weight: bold;'>
						<td style='width: 350px;'>Ver el mes de&nbsp
							<select  style='width: 100px;' id="listaMeses" onchange="act()">
								<?php
									$hoy = getdate();
									$meses = array("NULL", "Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
									for($i=1;$i<=12;$i++){
										
										if($i == $hoy['mon']){
											$selected = "Selected";
										}
										else{
											$selected = "";
										}
										echo "<option value='$i' $selected>$meses[$i]</option>";
									}
								
									echo "</select>&nbsp de &nbsp<select  style='width: 70px;' id='listaAnios' onchange='act()'>";
								
									for($i=2017;$i<=$hoy['year'];$i++){
										if($i == $hoy['year']){
										echo "<option value='$i' Selected>$i</option>";
										}
										else{
											echo "<option value='$i'>$i</option>";
										}
									}	
							echo "";
								?>
						</select></td>
					</tr>
				</table>
			</center>
		</div>
		<div style="clear: both;" id='container'>
			<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/estadisticas/tablaEstadisticas.php"; ?>
		</div>
		<div id="footer" style="clear: both;">
			<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/footer.php"; ?>
		</div>
	</body>
</html>
