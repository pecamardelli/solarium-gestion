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
		<script>
			function act(){
				var mes = $('#listaMeses').find(":selected").val();
				var anio = $('#listaAnios').find(":selected").val();
				var graficos = "<center><br>";
				graficos = graficos + "<img src='modulos/estadisticas/graficos/MensualCantidadTurnos.php?mes=" + mes + "&anio=" + anio + "'  alt='' class='pChartPicture'/>";
				graficos = graficos + "<br><br><br>";
				graficos = graficos + "<img src='modulos/estadisticas/graficos/MensualCantidadVentas.php?mes=" + mes + "&anio=" + anio + "'  alt='' class='pChartPicture'/>";
				graficos = graficos + "<br><br><br>";
				graficos = graficos + "<img src='modulos/estadisticas/graficos/MensualTurnosPorMaquina.php?mes=" + mes + "&anio=" + anio + "'alt='' class='pChartPicture'/>";
				graficos = graficos + "<br><br><br>";
				graficos = graficos + "<img src='modulos/estadisticas/graficos/MensualPorcentajeUsoDiario.php?mes=" + mes + "&anio=" + anio + "'alt='' class='pChartPicture'/>";
				graficos = graficos + "<br></center>";
				$('#container').html(graficos);
			}
			
			function act2(){
				var anio = $('#listaAnios2').find(":selected").val();
				var graficos = "<center>";
				graficos = graficos + "<br>";
				graficos = graficos + "<img src='modulos/estadisticas/graficos/AnualPorcentajeUsoMensual.php?anio=" + anio + "' alt='' class='pChartPicture'/>";
				graficos = graficos + "<br><br><br>";
				graficos = graficos + "<img src='modulos/estadisticas/graficos/AnualIngresosTotales.php?anio=" + anio + "' alt='' class='pChartPicture'/>";
				graficos = graficos + "<br><br><br>";
				graficos = graficos + "<img src='modulos/estadisticas/graficos/AnualTurnosVendidos.php?anio=" + anio + "' alt='' class='pChartPicture'/>";
				graficos = graficos + "<br><br><br>";
				graficos = graficos + "<img src='modulos/estadisticas/graficos/AnualTurnosTomadosPorMes.php?anio=" + anio + "'  alt='' class='pChartPicture'/>";
				graficos = graficos + "<br><br><br>";					
				graficos = graficos + "<img src='modulos/estadisticas/graficos/AnualTurnosTotalesPorMaquina.php?anio=" + anio + "' alt='' class='pChartPicture'/>";
				graficos = graficos + "<br>";
				graficos = graficos + "</center>";
				$('#container').html(graficos);
			}
			
			function act3(){
				var graficos = "<center>";
				graficos = graficos + "<br>";
				graficos = graficos + "<img src='modulos/estadisticas/graficos/clientesPorZona.php' alt='' class='pChartPicture'/>";
				graficos = graficos + "<br><br><br>";
				graficos = graficos + "<img src='modulos/estadisticas/graficos/clientesKnownBy.php' alt='' class='pChartPicture'/>";
				graficos = graficos + "<br><br><br>";
				graficos = graficos + "<img src='modulos/estadisticas/graficos/ClientesActivosPorMes.php' alt='' class='pChartPicture'/>";
				graficos = graficos + "<br><br><br>";
				graficos = graficos + "<img src='modulos/estadisticas/graficos/clientesTopTen.php'  alt='' class='pChartPicture'/>";
				/*graficos = graficos + "<br><br><br>";					
				graficos = graficos + "<img src='graficos/AnualTurnosTotalesPorMaquina.php?anio=" + anio + "' alt='' class='pChartPicture'/>";*/
				graficos = graficos + "<br>";
				graficos = graficos + "</center>";
				$('#container').html(graficos);
			}
			
			function act4(){
				var graficos = "<center>";
				graficos = graficos + "<br>";
				graficos = graficos + "<img src='modulos/estadisticas/graficos/TotalesDepreciacionTubos.php' alt='' class='pChartPicture'/>";
				/*graficos = graficos + "<br><br><br>";
				graficos = graficos + "<img src='graficos/clientesKnownBy.php' alt='' class='pChartPicture'/>";
				graficos = graficos + "<br><br><br>";
				graficos = graficos + "<img src='graficos/AnualTurnosVendidos.php?anio=" + anio + "' alt='' class='pChartPicture'/>";
				graficos = graficos + "<br><br><br>";
				graficos = graficos + "<img src='graficos/AnualTurnosTomadosPorMes.php?anio=" + anio + "'  alt='' class='pChartPicture'/>";
				graficos = graficos + "<br><br><br>";					
				graficos = graficos + "<img src='graficos/AnualTurnosTotalesPorMaquina.php?anio=" + anio + "' alt='' class='pChartPicture'/>";*/
				graficos = graficos + "<br>";
				graficos = graficos + "</center>";
				$('#container').html(graficos);
			}
			
			function change(caller){
				var graficos;
				if(caller == "ultimos30"){
					$('#listaMeses').prop('disabled', true);
					$('#listaAnios').prop('disabled', true);
					$('#listaAnios2').prop('disabled', true);
					graficos = "<center>";
					graficos = graficos + "<br>";
					graficos = graficos + "<img src='modulos/estadisticas/graficos/Ultimos30CantidadTurnos.php' alt='' class='pChartPicture'/>";
					graficos = graficos + "<br><br><br>";
					graficos = graficos + "<img src='modulos/estadisticas/graficos/Ultimos30CantidadVentas.php' alt='' class='pChartPicture'/>";
					graficos = graficos + "<br><br><br>";
					graficos = graficos + "<img src='modulos/estadisticas/graficos/Ultimos30TurnosPorMaquina.php' alt='' class='pChartPicture'/>";
					graficos = graficos + "<br><br><br>";
					graficos = graficos + "<img src='modulos/estadisticas/graficos/Ultimos30PorcentajeMaquinas.php' alt='' class='pChartPicture'/>";
					graficos = graficos + "<br>";
					graficos = graficos + "</center>";
					$('#container').html(graficos);
				}
				else if(caller == "mensual"){
					$('#listaMeses').prop('disabled', false);
					$('#listaAnios').prop('disabled', false);
					$('#listaAnios2').prop('disabled', true);
					act();
				}
				else if(caller == "anual"){
					$('#listaMeses').prop('disabled', true);
					$('#listaAnios').prop('disabled', true);
					$('#listaAnios2').prop('disabled', false);
					act2();
				}
				else if(caller == "clientes"){
					$('#listaMeses').prop('disabled', true);
					$('#listaAnios').prop('disabled', true);
					$('#listaAnios2').prop('disabled', true);
					act3();
				}
				else if(caller == "totales"){
					$('#listaMeses').prop('disabled', true);
					$('#listaAnios').prop('disabled', true);
					$('#listaAnios2').prop('disabled', true);
					act4();
				}
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
				<table id='table1'>
					<tr style='font-weight: bold;'>
						<td style='width: 160px;'><input type="radio" name="group1" id='ultimos30' onClick="change(this.id)" checked='checked'/>Últimos 30 días</td>
						<td style='width: 350px;'>
							<input type="radio" name="group1" id='mensual' onClick="change(this.id)"/>Mensual:&nbsp
							<select  style='width: 100px;' id="listaMeses" onchange="act()" disabled>
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
										
										if($i < 10){
											$mes = "0$i";
										}
										else{
											$mes = $i;
										}
										
										echo "<option value='$mes' $selected>$meses[$i]</option>";
									}
								
									echo "</select>&nbsp&nbspAño:&nbsp
										<select  style='width: 70px;' id='listaAnios' onchange='act()' disabled>";
								
									for($i=2017;$i<=$hoy['year'];$i++){
										if($i == $hoy['year']){
										echo "<option value='$i' Selected>$i</option>";
										}
										else{
											echo "<option value='$i'>$i</option>";
										}
									}	
							echo "</select>
						</td>
						<td style='width: 160px;'><input type='radio' name='group1' id='anual' onClick='change(this.id)'  />Anual&nbsp
							<select  style='width: 70px;' id='listaAnios2' onchange='act2()' disabled>";
							for($i=2017;$i<=$hoy['year'];$i++){
								if($i == $hoy['year']){
									echo "<option value='$i' Selected>$i</option>";
								}
								else{
									echo "<option value='$i'>$i</option>";
								}
							}
						?>
						</td>
						<td style='width: 120px;'><input type="radio" name="group1" id='totales' onClick="change(this.id)" />Totales</td>
						<td style='width: 120px;'><input type="radio" name="group1" id='clientes' onClick="change(this.id)" />Clientes</td>
					</tr>
				</table>
			</center>
		</div>
		<div id='container'>
			<center>
				<br>
				<img src='modulos/estadisticas/graficos/Ultimos30CantidadTurnos.php' alt='' class='pChartPicture'/>
				<br><br><br>
				<img src='modulos/estadisticas/graficos/Ultimos30CantidadVentas.php' alt='' class='pChartPicture'/>
				<br><br><br>
				<img src='modulos/estadisticas/graficos/Ultimos30TurnosPorMaquina.php' alt='' class='pChartPicture'/>
				<br><br><br>
				<img src='modulos/estadisticas/graficos/Ultimos30PorcentajeMaquinas.php' alt='' class='pChartPicture'/>
				<br>
			</center>
		</div>
		<div id="footer" style="clear: both;">
			<?php include $_SERVER['DOCUMENT_ROOT'] . "includes/footer.php"; ?>
		</div>
	</body>
</html>
