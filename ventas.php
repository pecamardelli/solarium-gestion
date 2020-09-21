<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/titulo.php";?>
		<script type="text/javascript" src="componentes/jquery-ui-1.11.4/external/jquery/jquery.js"></script>		
		<script text="javascript">
			function calcTotalGral(){
				var totalServ = parseInt(document.getElementById('total').innerHTML);
				var totalProd = parseInt(document.getElementById('totalProd').innerHTML);
				document.getElementById('totalGral').innerHTML = (totalServ + totalProd);
			}
		</script>		
		<script text="javascript" src="modulos/ventas/js/buscarCliente.js"></script>
		<script text="javascript" src="modulos/ventas/js/servicios.js"></script>
		<script text="javascript" src="modulos/ventas/js/productos.js"></script>
		<script text="javascript" src="modulos/ventas/js/ventas.js"></script>
		<script>
			function enter(e){
				if(e.keyCode == 13){
					buscar();
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
			<form name="datos" action="" method="POST" enctype="multipart/form-data">
				<center>
					<table cellpadding="3px" id="table1">
			<tr>
				<td colspan='3' style="font-weight: bold;">NUEVA VENTA</td>
			</tr>
			<tr>
				<td>Seleccionar Cliente</td>
				<td style='width: 400px;'>
				NOMBRE: <input type="text" id="buscarNombre" size="16" maxlength="24" value="" onKeyPress='return enter(event)'>
				DNI: <input type="text" id="buscarDni" size='10' maxLength="16" value="" onKeyPress='return enter(event)'>
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
		<hr>
		<table id='table1'>
			<tr>
				<td colspan='4' style="font-weight: bold; width: 350px;'">TOTAL GENERAL DE LA VENTA $</td>
				<td id="totalGral" style="font-weight: bold; width: 120px;">0</td>
				<td rowspan='3'><input type="button" class='boton' value="CARGAR" onclick="acciones('cargar')"></td>
			</tr>
			<tr>
				<td><strong>FORMA DE PAGO</strong></td>
				<td><input type="radio" name="pago" class='formaPago' value="EFECTIVO" checked />Pago en efectivo</td>
				<td><input type="radio" name="pago" class='formaPago' value="TARJETA" />Pago con tarjeta</td>
				<td><input type="radio" name="pago" class='formaPago' value="CTACTE" />Cuenta corriente</td>
				<td><input type="radio" name="pago" class='formaPago' value="ONLINE" />Venta Online</td>
			</tr>
			<tr>
				<td><strong>OBSERVACIONES</strong></td>
				<td colspan='4'><input type='text' id='obs' size='64' maxLength='256' value=''></td>
			</tr>
		</table>

		  <table id="table2">
			  <tr>
				  <td colspan="4" style="font-weight: bold;">AGREGAR SERVICIOS</td>
				  <td colspan="2" style="font-weight: bold;">TOTAL DE SERVICIOS $</td>
				  <td id="total" style="font-weight: bold;">0</td>
				  
			  </tr>
			<tr>
				<td>Servicio</td>
				<td>Opcion</td>
				<td>Cantidad</td>
				<td>Precio $</td>
				<td>Descuento %</td>
				<td>Subtotal $</td>
				<td><input type="button" onclick='addRow()' class='boton2' value="Agregar"></td>
		  	</tr>
		  <tr id="1-filaServ" class="filaServ">
							<td style='width: 250px;'>
								<select  name='1-selectServ' id="1-servList" class="servList" onchange="showOpts(this)">
									<option value='none'> - Elegir Servicio - </option>
									<?php
										include "dbconfig.php";
										$query="SELECT * FROM servicios WHERE estado='VIGENTE'";
										$result=mysqli_query($dbcon, $query);
				  						$i=0;
										while($fila = mysqli_fetch_array($result, MYSQLI_NUM)){
											echo "<option value='$fila[0]'>$fila[2]</option>";
											$query="SELECT * FROM opciones WHERE idServ='$fila[0]' AND estado='VIGENTE'";
											$ops[$i]=mysqli_query($dbcon, $query);
											$ids[$i]=$fila[0];
											$i++;
										}
				  echo "
								</select>
							</td>

							<td style='width: 250px;'>
								<select name='1-selectOpt' id='1-opDef' class='opDef' onchange='setPrice(this)'>
									<option name='none'> - Elegir Opcion -</option>
								</select>";                      
			   ?>
							</td>
							<td>
								<input type="number" name="1-cantidad" id="1-cant" class="cant" min="1" max="999" size="2" value="1" onchange='calcServ(this)'>
							</td>
							<td id='1-prec' class="prec">
								
							</td>
							<td>
								<input type="number" name="1-dto" id='1-descnt' class="descnt" min="0" max="100" size="2" value="0" onchange='calcServ(this)'>
							</td>
							<td id="1-subtotal" class="subtotal">
								
							</td>
							<td>
								<input type="button" name="1-borrar" value="Eliminar" id="1-boton2" class="boton2" onclick="deleteRow(this)">
							</td>
						</tr>
					</table>
					<table id="table3">
			  <tr>
				  <td colspan="4" style="font-weight: bold;">AGREGAR PRODUCTOS</td>
				  <td colspan="2" style="font-weight: bold;">TOTAL DE PRODUCTOS $</td>
				  <td id="totalProd" style="font-weight: bold;">0</td>
			  </tr>
						<tr>
							<td>Producto</td>
							<td>Cantidad</td>
							<td>Precio $</td>
							<td>Stock</td>
							<td>Descuento %</td>
							<td>Subtotal $</td>
			<td><input type="button" onclick='addProdRow()' class='boton2' value="Agregar"></td>
		  </tr>
		  <tr id="1-filaProd" class="filaProd">
			<td style='width: 350px;'>
				<select  name='1-selectProd' id="1-prodList" class="prodList" style='width: 300px;' onchange="showProd(this)">
					<option value='none'> - Elegir Producto - </option>
					<?php
						include "dbconfig.php";
						$query="SELECT * FROM productos WHERE estado='VIGENTE' AND stockProd > 0";
						$result=mysqli_query($dbcon, $query);
					$i=0;
					while($fila = mysqli_fetch_array($result, MYSQLI_NUM)){
						echo "<option value='$fila[0]'>$fila[1] - $fila[2]</option>";
						
					}
					echo "
						</select>
							</td>";                      
					?>
							
							<td>
								<input type="number" name="1-cantidadProd" id="1-cantProd" class="cantProd" min="0" max="999" size="2" value="1" onchange='calcProd(this)'>
							</td>
							<td id='1-precioProd' class='precioProd'>
								
							</td>
							<td id='1-stockProd' class='stockProd' name="">
								
							</td>
							<td>
								<input type="number" name="1-dtoProd" id='1-descntProd' class="descntProd" min="0" max="999" size="2" value="0" onchange='calcProd(this)'>
							</td>
							<td id="1-subtotalProd" class="subtotalProd">
								
							</td>
							<td>
								<input type="button" name="1-borrarProd" value="Eliminar" id="1-boton2Prod" class="boton2" onclick="deleteProdRow(this)">
							</td>
						</tr>
					</table>
				</center>
			</form>
		</div>			

		<div id="footer">
			<?php
				include "includes/footer.php";
			?>
		</div>

	</body>
</html>
