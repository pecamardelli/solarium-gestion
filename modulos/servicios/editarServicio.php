<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<script type="text/javascript" src="componentes/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
	<script type="text/javascript" src="componentes/jscolor/jscolor.js"></script>
	<head>
		<?php
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/titulo.php";
		?>
		<script type="text/javascript">
			function guardar(fila){
				var myTable = document.getElementById('edit1');
				idOp = myTable.rows[fila].cells[0].innerHTML;
				nombre = document.getElementById('nombre'+fila).value;
				desc = document.getElementById('desc'+fila).value;
				precio = document.getElementById('precio'+fila).value;
				idServ = document.getElementById('idServ').value;
				//var ops = idOp + nombre + desc + precio + idServ;
				//alert(ops);
				//window.location = "actualizarOpcion.php?id="+idOp+"&nombre="+nombre+"&desc="+desc+"&precio="+precio+"&idServ="+idServ;
				$.ajax({
					url: "modulos/servicios/actualizarOpcion.php",
					type: "POST",
					data: { 'idOp': idOp,
						   	'idServ': idServ,
						  	'nombre': nombre,
						  	'desc': desc,
						  	'precio': precio
						  },                   
					success: function(request)
								{
									alert(request);
									window.location = "modulos/servicios/editarServicio.php?id=" + idServ;
								}
				});
			}
			
			function edit(fila){
				var myTable = document.getElementById('edit1');
				var str = myTable.rows[fila].cells[3].innerHTML;
				var res = str.substring(1, 4);
				var nombre = "<input type='text' name='nombreOp' id='nombre" + fila + "' size='10' value='" + myTable.rows[fila].cells[1].innerHTML + "'>";
				var desc = "<input type='text' name='descOp' id='desc" + fila + "' size='20' value='" + myTable.rows[fila].cells[2].innerHTML + "'>";
				var precio = "<input type='number' name='precioOp' id='precio" + fila + "' min='1' max='999999' size='5' value='" + res + "'>";
				var boton = "<button class='boton2' onClick='guardar(" + fila + ")'>Guardar</button>";
				myTable.rows[fila].cells[1].innerHTML = nombre;
				myTable.rows[fila].cells[2].innerHTML = desc;
				myTable.rows[fila].cells[3].innerHTML = precio;
				myTable.rows[fila].cells[4].innerHTML = boton;
			}
			
			function actualizar(editar){ 
				if(editar.nombre.value == "" ||
					editar.desc.value == ""){
					alert('NO DEJAR CAMPOS VACIOS.');
					return false;
				}
			} 

			function agregarOp(opciones){ 
				if(opciones.nombre.value == "" ||
					opciones.desc.value == ""){
					alert('NO DEJAR CAMPOS VACIOS.');
					return false;
				}
			} 

			function del(idOp){
				var rol = "<?php echo $_SESSION['rol']; ?>";
				if(rol > 2){
					alert("ERROR: No tiene permisos para eliminar elementos." );
					return false;
				}
				
				if (confirm('ATENCION!\n\nSe borrara esta opcion.\n\nCONTINUAR?')){
					idsrv = document.getElementById('idServ').value;
					//window.location = "borrarOpcion.php?id=" + idOp + '&idserv=' + idsrv;
					$.ajax({
						url: "modulos/servicios/borrarOpcion.php",
						type: "POST",
						data: { 'ids': idOp },                   
						success: function(request)
							{
								alert(request);
								window.location = "modulos/servicios/editarServicio.php?id=" + idsrv;
							}
					});
				}
			}
			
			function act(idServ){
				nomsrv = document.getElementById('nombreServ').value;
				descsrv = document.getElementById('descServ').value;
				tiposrv = document.getElementById('tipoServ').options[document.getElementById('tipoServ').selectedIndex].value;
				cantsrv = document.getElementById('cantSrv').value;
				colorsrv = document.getElementById('colorServ').value;
				
				//alert("nombre: " + nomsrv + "\ndesc: " + descsrv +  "\ncolor: " + colorsrv);
				$.ajax({
					url: "modulos/servicios/actualizarServicio.php",
					type: "POST",
					data: { 'ident': idServ,
						  	'nombre': nomsrv,
						  	'desc': descsrv,
						    'tipo': tiposrv,
						    'cant': cantsrv,
						  	'servColor': colorsrv 
						  },                   
					success: function(request)
						{
							alert(request);
							window.location = "modulos/servicios/editarServicio.php?id=" + idServ;
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

		<center>
			<table id='table1'>
 				<?php
					include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
					$idServ = $_REQUEST['id'];
					$query="SELECT * FROM servicios WHERE idServ='$idServ'";
					$result=mysqli_query($dbcon, $query);
					$servs = mysqli_fetch_array($result);

					echo "
						<tr>
							<td colspan='6' style='font-weight: bold;'>EDITAR SERVICIO</td>
						</tr>
						<tr>
							<td>Servicio</td>
							<td style='width: 300px;'>Descripcion</td>
							<td style='width: 190px;'>Tipo</td>
							<td>Servicios simultáneos</td>
							<td>Color</td>
							<td rowspan='2'><input type='button' value='Actualizar' class='boton2' onClick='act($idServ)'>
						</tr>
						<tr>
							<td style='width: 180px;'><input type='text' name='nombre' id='nombreServ'";
										
					if($_SESSION['rol'] > 2){
						echo " disabled='disabled'";
					}

					echo" value='$servs[1]'></td>
							<td><input type='text' size='40' name='desc' id='descServ'";
					
					if($_SESSION['rol'] > 2){
						echo " disabled='disabled'";
					}

					echo " value='$servs[2]'></td>
							<td>
							<select name='tipoServ' id='tipoServ' style='width: 170px;'";
					if($_SESSION['rol'] > 2){
						echo " disabled='disabled'";
					}
							echo "><option value='none'> - Elegir Tipo - </option>";
								$sql = "SHOW COLUMNS FROM `servicios` LIKE 'tipoServ'";
								$results = mysqli_query($dbcon, $sql);
								$row = mysqli_fetch_array($results);
								$type = $row['Type'];
								preg_match('/enum\((.*)\)$/', $type, $matches);
								$vals = explode(',', $matches[1]);
								foreach($vals as $item){
									$item=trim($item, "'");
									echo "<option value='$item'";
									if($item == $servs[3]){
										echo " Selected";
									}
									   echo ">$item</option>";
								}
							
					

					echo "</select></td>
							<td><input type='number' name='cantServ' id='cantSrv' min='1' max='99' size='2' value='$servs[4]'></td>
							<td><input type='text' class='color' name='servColor' size='6' id='colorServ' value='$servs[5]'></td>
							<input type='hidden' id='idServ' value='$servs[0]'></td>
						</tr>";
				?>
			</table>

			<hr>

			<table id='table1' style='width: 700px;'>
				<form name="opciones" action="modulos/servicios/agregarOpcion.php" method="post" onSubmit="return agregarOp(this)">
					<tr>
						<td colspan='9' style='font-weight: bold;'>AGREGAR OPCIONES</td>
					</tr>
					<tr>
						<td>Nombre</td>
						<td style='width: 180px;'><input type='text' size='15' name='nombre'></td>
						<td>Descripcion</td>
						<td style='width: 180px;'><input type='text' size='20' name='desc'></td>
						<td>Precio</td>
						<td><input type="number" name="precio" min="1" max="999999" size="5" value="50"></td>
						<td>
							<center>
								<input type='submit' value='Agregar' class='boton2'>
								<input type='hidden' name='servicio' value='<?php echo $servs[0]; ?>'>
							</center>
						</td>
					</tr>
				</form>
			</table>

			<table id='edit1' style='width: 700px;'>
 				<?php
					include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
					$query="SELECT * FROM opciones WHERE idServ='$idServ' AND estado='VIGENTE'";
					$result=mysqli_query($dbcon, $query);
					$Q = mysqli_num_rows($result);

					echo "<tr>
							<td colspan='7'>Opciones de $servs[2]: $Q</td>
						</tr>";

					if($Q > 0){
						echo "<tr>
								<td>ID</td>
								<td>NOMBRE</td>
								<td style='width: 180px;'>DESCRIPCION</td>
								<td>PRECIO</td>
								<td colspan='2'>ACCIONES</td>
							</tr>";
					}

					$n = 2;
					while($ops = mysqli_fetch_array($result, MYSQLI_NUM)){
						echo "<tr>
								<td>$ops[0]</td>
								<td>$ops[2]</td>
								<td>$ops[3]</td>
								<td>\$$ops[4]</td>
								<td><button class='boton2' onclick='edit($n)'>Editar</button></td>
								<td><button onclick='del($ops[0])' class='boton2'>Eliminar</button></td>
							</tr>";
					$n++;
					}
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
