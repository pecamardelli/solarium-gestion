<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	
		<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/titulo.php"; ?>

		<script type="text/javascript" src="componentes/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
		<script type="text/javascript">

		function check(datos){ 
			if(datos.nombre.value == "" ||
				datos.desc.value == ""){
				alert('NO DEJAR CAMPOS VACIOS.');
				return false;
			}
		}

		function del(id) {
			var rol = "<?php echo $_SESSION['rol']; ?>";
			if(rol > 2){
				alert("ERROR: No tiene permisos para eliminar elementos." );
				return false;
			}
			
			var nombre = document.getElementById('td-nombre' + id).innerHTML;
			var descripcion = document.getElementById('td-desc' + id).innerHTML;
			if (confirm('ATENCION! SE BORRARA EL SIGUIENTE PRODUCTO:\n\n' + nombre + ' - ' + descripcion + '\n\nCONTINUAR?')) {
				$.ajax({
					url: "modulos/productos/borrarProducto.php",
					type: "POST",
					data: { 'id': id },                   
					success: function(request)
						{
							alert(request);
							window.location = "productos.php";
						}
				});
			}
		}

		function guardar(fila){
			var myTable = document.getElementById('prods');
			idProd = myTable.rows[fila].cells[0].innerHTML;
			var rol = "<?php echo $_SESSION['rol']; ?>";
			if(rol < 3){
				nombre = document.getElementById('nombre'+fila).value;
				var desc = document.getElementById('desc'+fila).value;
			}
			else{
				var nombre = document.getElementById('td-nombre'+idProd).innerHTML;
				var desc = document.getElementById('td-desc'+idProd).innerHTML;
			}
			precio = document.getElementById('precio'+fila).value;
			stock = document.getElementById('stock'+fila).value;
			
			$.ajax({
					url: "modulos/productos/actualizarProducto.php",
					type: "POST",
					data: { 'idProd': idProd,
						  	'nombre': nombre,
						  	'desc': desc,
						  	'precio': precio,
						   	'stock': stock
						  },                   
					success: function(request)
								{
									alert(request);
									window.location = "productos.php";
								}
				});
		}

		function edit(fila){
			var myTable = document.getElementById('prods');
			var str = myTable.rows[fila].cells[3].innerHTML;
			var res = str.substring(1, 4);
			
			var rol = "<?php echo $_SESSION['rol']; ?>";
			if(rol < 3){
				var nombre = "<input type='text' name='nombreProd' id='nombre" + fila + "' size='20' value='" + myTable.rows[fila].cells[1].innerHTML + "'>";
				var desc = "<input type='text' name='descProd' id='desc" + fila + "' size='20' value='" + myTable.rows[fila].cells[2].innerHTML + "'>";
				myTable.rows[fila].cells[1].innerHTML = nombre;
				myTable.rows[fila].cells[2].innerHTML = desc;
			}
			var precio = "<input type='number' name='precioProd' id='precio" + fila + "' min='1' max='999999' size='5' value='" + res + "'>";
			var stock = "<input type='number' name='stockProd' id='stock" + fila + "' min='1' max='999999' size='5' value='" + myTable.rows[fila].cells[4].innerHTML + "'>";
			var boton = "<button class='boton2' onClick='guardar(" + fila + ")'>Guardar</button>";
			
			myTable.rows[fila].cells[3].innerHTML = precio;
			myTable.rows[fila].cells[4].innerHTML = stock;
			myTable.rows[fila].cells[5].innerHTML = boton;
		}
	</script>
	
	</head>
	
	<body id="body">

		<?php
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/header.php";
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/menu.php";
		?>

		<center>
			<form name="datos" action="modulos/productos/agregarProducto.php" method="POST" onSubmit="return check(this)">
				<table id='table1'>
					<tr>
						<td colspan='9' style='font-weight: bold;'>AGREGAR PRODUCTO</td>
					</tr>
					<tr>
						<td>Producto</td>
						<td style='width: 180px;'><input type="text" name="nombre" maxLength="50"></td>
						<td>Descripcion</td>
						<td style='width: 180px;'><input type="text" name="desc"></td>
						<td>Precio</td>
						<td><input type="number" name="precio" min="1" max="999999" size="4" value="50" style='width: 40px;'></td>
						<td>Stock</td>
						<td><input type="number" name="stock" min="1" max="999999" size="3" value="10" style='width: 40px;'></td>
						<td><input type="submit" value="Agregar" class="boton2"></td>
					</tr>
				</table>
			</form>
			<hr>
			<table id='prods'>

				<?php
					include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
					$query="SELECT * FROM productos WHERE estado='VIGENTE'";
					$result=mysqli_query($dbcon, $query);

					echo "<tr>
							<td colspan='7' style='font-weight: bold;'>PRODUCTOS CARGADOS: " . mysqli_num_rows($result) . "</td>
						</tr>
						<tr style='font-weight: bold;'>
							<td style='width: 50px;'>ID</td>
							<td style='width: 150px;'>NOMBRE</td>
							<td style='width: 200px;'>DESCRIPCION</td>
							<td>PRECIO</td>
							<td>STOCK</td>
							<td colspan='2'>ACCIONES</td>
						</tr>";			

					$n = 2;
					while($fila = mysqli_fetch_array($result, MYSQLI_NUM)){
						echo "<tr>
								<td>$fila[0]</td>
								<td id='td-nombre$fila[0]'>$fila[1]</td>
								<td id='td-desc$fila[0]'>$fila[2]</td>
								<td>\$$fila[3]</td>
								<td>$fila[4]</td>
								<td><button class='boton2' onclick='edit($n)'>Editar</button></td>
								<td><button onclick='del($fila[0])' class='boton2'>Eliminar</button></td>
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

		<?php
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/jquery_scripts.php";
		?>
	</body>
</html>
