<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/titulo.php"; ?>
		<script type="text/javascript" src="componentes/jquery-1.5.2/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="componentes/lightbox/themes/default/jquery.lightbox.css" />
		<script type="text/javascript" src="componentes/lightbox/jquery.lightbox.min.js"></script>
		<script>
			$(document).ready(function(){
				$('.lightbox').lightbox();
			  });
		</script>
		<script>
			function buscarVentasCliente(){
				$(".filaServ").remove();
				$(".filaRep").remove();
				var tipo = $('input[type="radio"]:checked').val();
				clientId = $('.clienteSeleccionado').attr('id');
				
				if(clientId > 0){
					if(tipo == "rep"){
						$.ajax ({
							url: 'modulos/ventas/traerVentasCliente.php',		/* URL a invocar asíncronamente							*/
							type:  'post',						/* Método utilizado para el requerimiento 				*/
							data: 	{ 'idClient': clientId },	/* Información local a enviarse con el requerimiento 	*/

							success: 	function(request)
							{
								if(request == "EMPTY"){
									alert("No se encontraron ventas para este cliente.")
								}
								else{
									$("#tablaVentas").append(request).end();
								}
							}
						});
					}
					else if (tipo == "turnos"){
						$.ajax ({
							url: 'modulos/turnos/traerTurnosTomados.php',		/* URL a invocar asíncronamente							*/
							type:  'post',						/* Método utilizado para el requerimiento 				*/
							data: 	{ 'idClient': clientId },	/* Información local a enviarse con el requerimiento 	*/

							success: 	function(request)
							{
								if(request == "EMPTY"){
									alert("No se encontraron turnos tomados de este cliente.")
								}
								else{
									$("#turnosBody").html(request);
								}
							}
						});
					}
					else{
						$.ajax ({
							url: 'modulos/servicios/traerServiciosCliente.php',	/* URL a invocar asíncronamente */
							type:  'post',											/* Método utilizado para el requerimiento */
							data: 	{ 'idClient': clientId },		/* Información local a enviarse con el requerimiento */

							success: 	function(request)
							{
								if(request == "EMPTY"){
									alert("No se encontraron ventas para este cliente.")
								}
								else{
									$("#tablaServicios").append(request).end();
								}
							}			
						});
					}
				}
				else{
					alert("SELECCIONE CLIENTE POR FAVOR.");
				}
			}
			
			function cambiarTablas(id){
				var rep = document.getElementById("tablaVentas");
				var serv = document.getElementById("tablaServicios");
				var turnos = document.getElementById("tablaTurnos");
				
				$(".filaServ").remove();
				$(".filaRep").remove();
				$(".filaTurno").remove();
				
				if(id == "rep"){
					rep.style.display = "table";
					serv.style.display = "none";
					turnos.style.display = "none";
				}
				else if(id == "turnos"){
					rep.style.display = "none";
					serv.style.display = "none";
					turnos.style.display = "table";
				}
				else{
					rep.style.display = "none";
					serv.style.display = "table";
					turnos.style.display = "none";
				}
			}
			
			function cambiarProd(){
				var checkboxes = $('input:checkbox:checked');
				var servId = $('#1-servList').find(":selected").val();
				var servName = $('#1-servList').find(":selected").text();
				var opId = $('#1-opDef').find(":selected").attr('id');
				var opName = $('#1-opDef').find(":selected").text();
				var opPrecio = $('#1-opDef').find(":selected").val();
				
				if(servId == 0 || opId == 0){
					alert("ELEGIR SERVICIO AL QUE SE VA A CAMBIAR.");
					exit;
				}
				
				if(checkboxes.length == 0){
					alert("MARCAR SERVICIOS A CAMBIAR.");
					exit;
				}
				
				var servs = new Array();
				var ventas = new Array();
				var total1 = 0;
				var monto;
				var descnt;
				
				for(i=0;i<checkboxes.length;i++){
					servs[i] = checkboxes[i].value;
					ventas[i] = $('#' + servs[i] + '-venta').html();
					monto = $('#' + servs[i] + '-monto').html();
					monto = monto.slice(1);
					descnt = $('#' + servs[i] + '-descuento').html();
					descnt = (100-parseInt(descnt))/100;
					total1 = total1 + (opPrecio - parseInt(monto)) * descnt;
					//alert(monto + " " + descnt + " " + total1);return false;
				}

				//var diferencia = opPrecio * checkboxes.length - total1;
				total1 = Math.floor(total1);
				
				JSON.stringify(servs);
				JSON.stringify(ventas);
				var idCli = $('.clienteSeleccionado').attr('id');
				var cliente = $('.clienteSeleccionado').html() + "(ID:" + idCli + ")";
				
				if(confirm("SE CAMBIARAN " + checkboxes.length + " SERVICIOS POR:\n" + servName + " - " + opName + "\n\nATENCION: La diferencia a abonar es de $" + total1)){
					//alert(servs);
					
					$.ajax ({
						url: 'modulos/productos/cambiarProducto.php',	/* URL a invocar asíncronamente */
						type:  'post',											/* Método utilizado para el requerimiento */
						data: 	{
									'idCli': idCli,
									'idServ': servId,
									'idOp': opId,
									'precioOp': opPrecio,
									'cliente': cliente,
									'servName': servName,
									'opName': opName,
									'dif': total1,
									'servs': servs,
									'ventas': ventas
								},
						success: 	function(request)
						{
							alert(request);
							window.location.replace("reportes.php");
						},
						error: function(request) {
							alert(request.statusText);
						}
					});
				}
			}
		</script>
		<script text="javascript" src="modulos/clientes/js/clientes.js">
			buscarVentasCliente();
		</script>
		<script text="javascript" src="modulos/servicios/js/servicios.js"></script>
		<script>
			function enter(e){
				if(e.keyCode == 13){
					acciones('buscar');
				}
			}
		</script>
	</head>
	
	<body id="body">

		<?php
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/header.php";
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/menu.php";
		?>

		<div id="user1">
			<center>
				<table cellpadding="3px" id="table1">
					<tr>
						<td colspan='3' style="font-weight: bold;">VENTAS POR CLIENTE</td>
					</tr>
					<tr>
						<td>Seleccionar Cliente</td>
						<td style='width: 400px;'>
						NOMBRE: <input type="text" id="buscarNombre" name="nombreCli" size="16" maxlength="24" value="" onKeyPress='return enter(event)'>
						DNI: <input type="text" id="buscarDni" name="doc" size='10' maxLength="16" value="" onKeyPress='return enter(event)'>
						</td>
						<td>
							<input type="button" value="buscar" class='boton2' onClick="acciones('buscar')">
						</td>
					</tr>
					<tr>
						<td colspan='2'>
							<div id="encontrado"></div>
						</td>
						<td>
							<input type="button" value="Ver" class='boton2' onClick="buscarVentasCliente()">
						</td>
					</tr>
					<tr style="font-weight: bold;">
						<td colspan="3">
							<input type="radio" name="grupo1" id='rep' value="rep" onClick="cambiarTablas(this.id)" checked> Ver reportes &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							<input type="radio" name="grupo1" id='serv' value="serv" onClick="cambiarTablas(this.id)"> Ver servicios disponibles &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							<input type="radio" name="grupo1" id='turnos' value="turnos" onClick="cambiarTablas(this.id)"> Ver turnos tomados
						</td>
					</tr>
				</table>
				<hr>
				<table id="tablaVentas" style="display: table;">
					<tr id="1-filaVenta" style="font-weight: bold;">
						<td style='width: 50px;'>N°</td>
						<td style='width: 150px;'>FECHA</td>
						<td style='width: 200px;'>CLIENTE</td>
						<td>MONTO</td>
						<td>FORMA DE PAGO</td>
						<td>ESTADO</td>
						<td style='width: 200px;'>OBSERVACIONES</td>
						<td colspan='2'>OPCIONES</td>
					</tr>
				</table>
				
				<table id="tablaTurnos" style="display: none;">
					<thead>
						<tr id="1-filaTurnos" style="font-weight: bold;">
							<td style='width: 50px;'>N°</td>
							<td style='width: 150px;'>CLIENTE</td>
							<td style='width: 150px;'>HORA DEL TURNO</td>
							<td>SERVICIO</td>
							<td>MAQUINA</td>
							<td>ESTADO</td>
							<td style='width: 150px;'>ULTIMO CAMBIO</td>
							<td style='width: 200px;'>OBSERVACIONES</td>
						</tr>
					</thead>
					<tbody id='turnosBody'>
					
					</tbody>
				</table>
				
				<table id="tablaServicios" style="display: none;">
					<tr id="1-filaServ">
						<td style="font-weight: bold;">
							Cambiar por:
						</td>
						<td colspan='2'>
							<select  name='1-selectServ' id="1-servList" class="servList" onchange="showOpts(this)">
								<option name='none' value='0'> - Elegir Servicio - </option>
								<?php
									include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
									$query="SELECT * FROM servicios WHERE estado='VIGENTE'";
									$result=mysqli_query($dbcon, $query);
									$i=0;
									while($fila = mysqli_fetch_array($result, MYSQLI_NUM)){
										echo "<option value='$fila[0]'>$fila[2]</option>";
										$query="SELECT * FROM opciones WHERE idServ='$fila[0]' AND estado='VIGENTE'";
										$ops[$i]=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
										$ids[$i]=$fila[0];
										$i++;
									}
								?>
							</select>
						</td>
						<td style='width: 200px;' colspan='2'>
							<select name='1-selectOpt' id='1-opDef' class='opDef' style='width: 180px;'>
								<option name='none' value='0'> - Elegir Opcion -</option>
							</select>
						</td>
						<td colspan='2'>
							<input type='button' value='Cambiar' class='boton2' onClick='cambiarProd()'>
						</td>
					</tr>
					<tr id="2-filaServ" style="font-weight: bold;">
						<td style='width: 50px;'>ID</td>
						<td style='width: 50px;'>N° Venta</td>
						<td style='width: 200px;'>SERVICIO</td>
						<td style='width: 150px;'>OPCION</td>
						<td style='width: 100px;'>PRECIO ABONADO</td>
						<td style='width: 100px;'>DESCUENTO (%)</td>
						<td style='width: 80px;'>MARCAR</td>
					</tr>
				</table>
			</center>
		</div>
		<div id="footer">
			<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/footer.php"; ?>
		</div>
	</body>
</html>
