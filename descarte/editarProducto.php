<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/titulo.php"; ?>

		<script type="text/javascript" src="componentes/jscolor/jscolor.js"></script>
		<script type="text/javascript">
			function guardar(fila){
				var myTable = document.getElementById('edit1');
				idOp = myTable.rows[fila].cells[0].innerHTML;
				nombre = document.getElementById('nombre'+fila).value;
				desc = document.getElementById('desc'+fila).value;
				precio = document.getElementById('precio'+fila).value;
				idServ = document.getElementById('idOpcion').value;
				//ops = idOp + nombre + desc + precio + idServ;
				//alert(ops);
				window.location = "modulos/servicios/actualizarOpcion.php?id="+idOp+"&nombre="+nombre+"&desc="+desc+"&precio="+precio+"&idServ="+idServ;
			}

			function edit(fila){
				//alert(fila);
				var myTable = document.getElementById('edit1');
				var str = myTable.rows[fila].cells[3].innerHTML;
				var res = str.substring(1, 4);
				nombre = "<input type='text' name='nombreOp' id='nombre" + fila + "' size='10' value='";
				nombre = nombre.concat(myTable.rows[fila].cells[1].innerHTML,"'>");
				desc = "<input type='text' name='descOp' id='desc" + fila + "' size='20' value='";
				desc = desc.concat(myTable.rows[fila].cells[2].innerHTML, "'>");
				precio = "<input type='number' name='precioOp' id='precio" + fila + "' min='1' max='999999' size='5' value='";
				precio = precio.concat(res, "'>");
				boton = "<button class='boton2' onClick='actualizarOpcion.php?id=";
				boton = "<button class='boton2' onClick='guardar(";
				boton = boton.concat(fila,")'>Guardar</button>");
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
				if (confirm('Borrar esta opcion?')){
					idServ = document.getElementById('ident').value;
					window.location = "borrarOpcion.php?id="+idOp+"&idServ="+idServ;
				}
			}
		</script>
	</head>
	
	<body id="body">

		<div id="header">
				<img src="imagenes/logo.png">
		</div>
		<div>
		<?php
			include "menu.php";
		?>

		<center>
			<table id='table1'>
				<form name="editar" action="actualizar.php" method="post">
 				<?php
					include "dbconfig.php";
					$idServ = $_REQUEST['id'];
					$query="SELECT * FROM servicios WHERE idServ='$idServ'";
					$result=mysqli_query($dbcon, $query);
					$servs = mysqli_fetch_array($result, MYSQLI_NUM);

					echo "
						<tr>
							<td colspan='2' style='font-weight: bold;'>EDITAR SERVICIO</td>
						</tr>
						<tr>
							<td style='width: 150px;'>Nombre del servicio</td>
							<td style='width: 180px;'><input type='text' name='nombre' value='$servs[1]'></td>
						</tr>
						<tr>
							<td>Descripcion</td>
							<td><input type='text' name='desc' value='$servs[2]'></td>
						</tr>
						<tr>
							<td>Color</td>
							<td><input type='text' class='color' name='servColor' size='6' value='$servs[3]'></td>
						</tr>
						<tr>
							<td colspan='2'><input type='submit' value='Actualizar' class='boton2'>
							<input type='hidden' id='idOpcion' name='ident' value='$servs[0]'></td>
						</tr>";
				?>
				</form>
			</table>

			<hr>

			<table id='table1' style='width: 700px;'>
				<form name="opciones" action="agregarOpcion.php" method="post" onSubmit="return agregarOp(this)">
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
					include "dbconfig.php";
					$query="SELECT * FROM opciones WHERE idServ='$idServ'";
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
					while($ops = mysqli_fetch_array($result)){
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
		</div>
		<div id="footer">
			<?php
				include "includes/footer.php";
			?>
		</div>
	</body>
</html>
