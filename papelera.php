<?php 
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	$access_level = 3;
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/allow.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/titulo.php"; ?>

		<script type="text/javascript" src="componentes/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
		
		<script type="text/javascript">
			function cambiar(id, tipo, accion) {
				if(accion == "recuperar"){
					var texto = "RECUPERAR ESTE ELEMENTO?";
				}
				else{
					var texto = "DESCARTAR ESTE ELEMENTO?";
				}
				
				if (confirm(texto)) {
					$.ajax({
						url: "modulos/papelera/cambiarElemento.php",
						type: "POST",
						data: { 'ids': id, 'tipo': tipo, 'accion': accion },
						success: function(request)
									{
										alert(request);
										window.location = "papelera.php";
									}
					});
				}
			}
			
			function hideTables(id){
				var tables = document.getElementsByClassName('itemList');
				var tableId = id + 'List';
				
				
				if(id == "todos"){
					for(i=0;i<tables.length;i++){
						tables[i].style.display = 'table';
						//tables[i].style.marginLeft = 'auto';
						//tables[i].style.marginRight = 'auto';
						//tables[i].style.align = 'center';
					}
				}
				else{
					for(i=0;i<tables.length;i++){
						if(tables[i].id != tableId){
							tables[i].style.display = 'none';
						}
						else{
							tables[i].style.display = 'table';
						}

					}
				}
			}
			
		</script>
	
	</head>
	
	<body id="body">
			
		<?php
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/header.php";
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/menu.php";
		?>

		<center>
			<table id='table1'>
				<tr style='font-weight: bold;'>
					<td style='width: 130px;'><input type="radio" name="group1" class='radios' id='client' value="CLIENTES" onClick="hideTables(this.id)" /> CLIENTES</td>
					<td style='width: 130px;'><input type="radio" name="group1" class='radios' id='serv' value="SERVICIOS" onClick="hideTables(this.id)"/> SERVICIOS</td>
					<td style='width: 130px;'><input type="radio" name="group1" class='radios' id='op' value="OPCIONES" onClick="hideTables(this.id)"/> OPCIONES</td>
					<td style='width: 130px;'><input type="radio" name="group1" class='radios' id='prod' value="PRODUCTOS" onClick="hideTables(this.id)"/> PRODUCTOS</td>
					<td style='width: 130px;'><input type="radio" name="group1" class='radios' id='maq' value="MAQUINAS" onClick="hideTables(this.id)"/> MAQUINAS</td>
					<td style='width: 130px;'><input type="radio" name="group1" class='radios' id='todos' value="TODOS" onClick="hideTables(this.id)"/> TODOS</td>
				</tr>
			</table>
			<table id='servList' class='itemList'>

				<?php
					include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
					$query="SELECT * FROM servicios WHERE estado='ELIMINADO'";
					$result=mysqli_query($dbcon, $query);

					echo "<tr>
							<td colspan='7' style='font-weight: bold;'>SERVICIOS ELIMINADOS: " . mysqli_num_rows($result) . "</td>
						</tr>
						<tr style='font-weight: bold;'>
							<td style='width: 50px;'>ID</td>
							<td>NOMBRE</td>
							<td style='width: 200px;'>DESCRIPCION</td>
							<td>COLOR</td>
							<td style='width: 200px;'>OBSERVACIONES</td>
							<td colspan='2'>ACCIONES</td>
						</tr>";			

					while($fila = mysqli_fetch_array($result, MYSQLI_NUM)){
						echo "<tr>
								<td>$fila[0]</td>
								<td id='$fila[0]-servName'>$fila[1]</td>
								<td id='$fila[0]-servDesc'>$fila[2]</td>
								<td style='background-color: #$fila[3]'>$fila[3]</td>
								<td>$fila[5]</td>
								<td><button onclick='cambiar($fila[0], \"servicios\", \"recuperar\")' class='boton2'>Recuperar</button></td>
								<td><button onclick='cambiar($fila[0], \"servicios\", \"descartar\")' class='boton2'>Descartar</button></td>
							</tr>";
					}
					echo "</table>
							<table id='opList' class='itemList''>";
							
					$query="SELECT	opciones.idOpcion AS idOp,
									opciones.idServ AS idSrv,
									opciones.nombreOp AS nom,
									opciones.descOp AS descr,
									opciones.observaciones AS obs,
									servicios.descServ AS srvDesc
									FROM opciones 
									INNER JOIN servicios ON opciones.idServ = servicios.idServ
									WHERE opciones.estado='ELIMINADO'";
					$result=mysqli_query($dbcon, $query);

					echo "<tr>
							<td colspan='7' style='font-weight: bold;'>OPCIONES ELIMINADAS: " . mysqli_num_rows($result) . "</td>
						</tr>
						<tr style='font-weight: bold;'>
							<td style='width: 50px;'>ID</td>
							<td style='width: 200px;'>NOMBRE</td>
							<td style='width: 200px;'>DESCRIPCION</td>
							<td style='width: 200px;'>PERTENECE A</td>
							<td style='width: 200px;'>OBSERVACIONES</td>
							<td colspan='2'>ACCIONES</td>
						</tr>";

					while($fila = mysqli_fetch_array($result, MYSQLI_ASSOC)){
						echo "<tr>
								<td>$fila[idOp]</td>
								<td id='$fila[idOp]-servName'>$fila[nom]</td>
								<td id='$fila[idOp]-servDesc'>$fila[descr]</td>
								<td>$fila[srvDesc]</td>
								<td>$fila[obs]</td>
								<td><button onclick='cambiar($fila[idOp], \"opciones\", \"recuperar\")' class='boton2'>Recuperar</button></td>
								<td><button onclick='cambiar($fila[idOp], \"opciones\", \"descartar\")' class='boton2'>Descartar</button></td>
							</tr>";
					}
						
					echo "</table>
							<table id='prodList' class='itemList'>";		
							
					$query="SELECT * FROM productos WHERE estado='ELIMINADO'";
					$result=mysqli_query($dbcon, $query);

					echo "<tr>
							<td colspan='6' style='font-weight: bold;'>PRODUCTOS ELIMINADOS: " . mysqli_num_rows($result) . "</td>
						</tr>
						<tr style='font-weight: bold;'>
							<td style='width: 50px;'>ID</td>
							<td style='width: 200px;'>NOMBRE</td>
							<td style='width: 200px;'>DESCRIPCION</td>
							<td style='width: 200px;'>OBSERVACIONES</td>
							<td colspan='2'>ACCIONES</td>
						</tr>";			

					while($fila = mysqli_fetch_array($result, MYSQLI_NUM)){
						echo "<tr>
								<td>$fila[0]</td>
								<td id='$fila[0]-prodName'>$fila[1]</td>
								<td id='$fila[0]-prodDesc'>$fila[2]</td>
								<td>$fila[7]</td>
								<td><button onclick='cambiar($fila[0], \"productos\", \"recuperar\")' class='boton2'>Recuperar</button></td>
								<td><button onclick='cambiar($fila[0], \"productos\", \"descartar\")' class='boton2'>Descartar</button></td>
							</tr>";
					}
					
					echo "</table>
							<table id='clientList' class='itemList'>";		
							
					$query="SELECT	* FROM clientes WHERE estado='ELIMINADO'";
					$result=mysqli_query($dbcon, $query);

					echo "<tr>
							<td colspan='6' style='font-weight: bold;'>CLIENTES ELIMINADOS: " . mysqli_num_rows($result) . "</td>
						</tr>
						<tr style='font-weight: bold;'>
							<td style='width: 50px;'>ID</td>
							<td style='width: 200px;'>NOMBRE</td>
							<td style='width: 200px;'>DNI</td>
							<td style='width: 200px;'>OBSERVACIONES</td>
							<td colspan='2'>ACCIONES</td>
						</tr>";			

					while($fila = mysqli_fetch_array($result, MYSQLI_NUM)){
						echo "<tr>
								<td>$fila[0]</td>
								<td id='$fila[0]-cliName'>$fila[1] $fila[2]</td>
								<td id='$fila[0]-cliDni'>$fila[3]</td>
								<td>$fila[11]</td>
								<td><button onclick='cambiar($fila[0], \"clientes\", \"recuperar\")' class='boton2'>Recuperar</button></td>
								<td><button onclick='cambiar($fila[0], \"clientes\", \"descartar\")' class='boton2'>Descartar</button></td>
							</tr>";
					}
				echo "</table>
							<table id='maqList' class='itemList'>";		
							
					$query="SELECT	* FROM maquinas WHERE estado='ELIMINADA'";
					$result=mysqli_query($dbcon, $query);

					echo "<tr>
							<td colspan='8' style='font-weight: bold;'>MAQUINAS ELIMINADAS: " . mysqli_num_rows($result) . "</td>
						</tr>
						<tr style='font-weight: bold;'>
							<td style='width: 50px;'>ID</td>
							<td style='width: 200px;'>TIPO</td>
							<td style='width: 200px;'>MARCA</td>
							<td style='width: 200px;'>MODELO</td>
							<td style='width: 200px;'>TUBOS</td>
							<td style='width: 200px;'>ADQUIRIDA</td>
							<td colspan='2'>ACCIONES</td>
						</tr>";			

					while($fila = mysqli_fetch_array($result, MYSQLI_NUM)){
						echo "<tr>
								<td>$fila[0]</td>
								<td>$fila[1]</td>
								<td>$fila[2]</td>
								<td>$fila[3]</td>
								<td>$fila[4]</td>
								<td>$fila[5]</td>
								<td><button onclick='cambiar($fila[0], \"maquinas\", \"recuperar\")' class='boton2'>Recuperar</button></td>
								<td><button onclick='cambiar($fila[0], \"maquinas\", \"descartar\")' class='boton2'>Descartar</button></td>
							</tr>";
					}
				echo "</table>";
				?>
			</table>
		</center>
		
		<div id="footer">
			<?php
				include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/footer.php";
			?>
		</div>
	</body>
</html>
