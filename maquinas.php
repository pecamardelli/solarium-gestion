<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>	
		<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/titulo.php"; ?>
		<script type="text/javascript" src="componentes/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
		<script type="text/javascript" src="componentes/jscolor/jscolor.js"></script>
		<script type="text/javascript">
		function agregar(){
			var tipo = $("#tipoList option:selected").val();
			var marca = $("#marca").val();
			var modelo = $("#modelo").val();
			var tubos = $("#tubos").val();
			var fecha = $("#fecha").val();
			var serv = $("#servList option:selected").attr('name');
			var controller = $("#controllerList option:selected").attr('name');
			var color = $("#maqColor").val();
			
			if(controller == "ARDUINO"){
				var controllerOpt = $("#arduinoPortList option:selected").attr('name');
				//alert(controllerOpt);return false;
			}
			else if(controller == "RASPBERRY"){
				var firstOctet = $("#raspIpAddressOctet1").val();
				var secondOctet = $("#raspIpAddressOctet2").val();
				var thirdOctet = $("#raspIpAddressOctet3").val();
				var fourthOctet = $("#raspIpAddressOctet4").val();
				var controllerOpt = firstOctet + "." + secondOctet + "." + thirdOctet + "." + fourthOctet;
				//alert(controllerOpt);return false;
			}
			else{
				var controllerOpt = "NINGUNO";
				//alert(controllerOpt);return false;
			}
			
			if($("#graficar").is(':checked')){
				var graficar = "SI";
			}
			else{
				var graficar = "NO";
			}
			
			var estado = $("#estadoList option:selected").val();
			
			//alert(port);
			//return false;
			
			if(tipo == ""){
				alert('El campo TIPO esta vacio!');
				return false;
			}
			
			if(marca == ""){
				alert('El campo MARCA esta vacio!');
				return false;
			}
			
			if(modelo == ""){
				alert('El campo MODELO esta vacio!');
				return false;
			}
			
			if(tubos < 1 || tubos > 99){
				alert('El campo TUBOS esta fuera de rango (1-99)!');
				return false;
			}
			
			if(fecha == ""){
				alert('El campo FECHA esta vacio!');
				return false;
			}
			
			if(estado == ""){
				alert('El campo ESTADO esta vacio!');
				return false;
			}
			
			if(controller == "ARDUINO"){
				$.ajax({
					url: "includes/checkPort.php",
					type: "POST",
					data: { 'controllerOpt': controllerOpt  },                   
					success: function(request)
							{
								if(request == "NACK\n"){
									alert("El puerto " + port + " esta utilizado.");
									return false;
								}
							}
				});
			}
			
			$.ajax({
				url: "modulos/maquinas/agregarMaquina.php",
				type: "POST",
				data: { 'tipo': tipo,
						'marca': marca,
						'modelo': modelo,
						'tubos': tubos,
						'fecha': fecha,
						'serv': serv,
						'controller': controller,
						'controllerOpt': controllerOpt,
						'graficar': graficar,
						'estado': estado,
					   	'color': color
					  },
				success: function(request)
						{
							alert(request);
							//alert("Maquina agregada correctamente!");
							window.location = "maquinas.php";
						}
			});
		}

		function del(id) {
			var rol = "<?php echo $_SESSION['rol']; ?>";
			if(rol > 2){
				alert("ERROR: No tiene permisos para eliminar maquinas." );
				return false;
			}
			
			var tipo = $("#tipoList option:selected").val();
			var marca = $("#marca-" + id).html();
			var modelo = $("#modelo-" + id).html();
			
			if (confirm('ATENCION! SE BORRARA LA SIGUIENTE MAQUINA:\n\nTipo:\t' + tipo + '\nMarca\t: ' + marca + '\nModelo:\t' + modelo + '\n\nCONTINUAR?')) {
				$.ajax({
					url: "modulos/maquinas/borrarMaquina.php",
					type: "POST",
					data: { 'id': id, 'modelo': modelo, 'marca': marca },                   
					success: function(request)
								{
									alert(request);
									window.location = "maquinas.php";
								}
				});
			}
		}

		function guardar(fila){
			var rol = "<?php echo $_SESSION['rol']; ?>";
			
			if(rol < 3){
				var myTable = document.getElementById('maqs');
				var idMaq = myTable.rows[fila].cells[0].innerHTML;
				var controller = $("#editController" + fila + " option:selected").attr("name");
				
				
				switch(controller){
					case "NINGUNO":
						var controllerOpt = "NINGUNO";
						break;
					case "ARDUINO":
						var controllerOpt = $("#editPortList" + fila + " option:selected").attr("name");
						break;
					case "RASPBERRY":
						var firstOctet = $("#editIpAddressOctet1" + fila).val();
						var secondOctet = $("#editIpAddressOctet2" + fila).val();
						var thirdOctet = $("#editIpAddressOctet3" + fila).val();
						var fourthOctet = $("#editIpAddressOctet4" + fila).val();
						var controllerOpt = firstOctet + "." + secondOctet + "." + thirdOctet + "." + fourthOctet;
						break;
				} 
				
				if($("#editGraficar" + fila).is(':checked')){
					var graficar = "SI";
				}
				else{
					var graficar = "NO";
				}
				
				var estado = $("#editEstadoList" + fila + " option:selected").attr("value");
				var color = $("#editMaqColor" + fila).val();
				//alert(idMaq + " - " + controller + " - " + controllerOpt + " - " + graficar + " - " + estado);return false;
				
				$.ajax({
					url: "modulos/maquinas/actualizarMaquina.php",
					type: "POST",
					data: { 'idMaq': idMaq,
						  	'controller': controller,
						    'controllerOpt': controllerOpt,
						    'graficar': graficar,
						   	'estado': estado,
						    'color': color
						  },                   
					success: function(request)
								{
									alert(request);
									window.location = "maquinas.php";
								}
				});
			}
			else{
				alert("No tiene permisos para cambiar el numero de puerto.");
			}			
		}
			
		function edit(fila){
			var myTable = document.getElementById('maqs');
			var controller = myTable.rows[fila].cells[7].innerHTML;
			var controllerOpt = myTable.rows[fila].cells[8].innerHTML;
			var color = myTable.rows[fila].cells[11].innerHTML;
			
			$("#editGraficar").disabled = false;
			
			if($("#editGraficar" + fila).is(':checked')){
				var graficar = "SI";
			}
			else{
				var graficar = "NO";
			}
			
			var estado = myTable.rows[fila].cells[10].innerHTML;
			
			//alert(controller + " - " + controllerOpt + " - " + graficar);return false;
			
			var rol = "<?php echo $_SESSION['rol']; ?>";
			
			var option_name_1 = "";
			var option_name_2 = "";
			var option_name_3 = "";
			var controllerOptsHTML = "";
			
			if(rol < 3){
				switch(controller){
					case "NINGUNO":
						option_name_1 = " Selected"
						controllerOptsHTML = "NINGUNO";
						break;
					case "ARDUINO":
						option_name_2 = " Selected"
						controllerOptsHTML = "<strong>Puerto</strong>&nbsp;<select name='editPortList' id='editPortList" + fila + "' style='width: 30px;'> \
								<option name='0'>0</option> \
								<option name='1'>1</option> \
								<option name='2'>2</option> \
								<option name='3'>3</option> \
							</select>";
						break;
					case "RASPBERRY":
						var octets = controllerOpt.split(".");
						option_name_3 = " Selected"
						controllerOptsHTML = "<input type='number' id='editIpAddressOctet1" + fila + "' min='1' max='255' size='1' value='" + octets[0] + "' style='width: 40px;'>. \
							<input type='number' id='editIpAddressOctet2" + fila + "' min='1' max='255' size='3' value='" + octets[1] + "' style='width: 40px;'>. \
							<input type='number' id='editIpAddressOctet3" + fila + "' min='1' max='255' size='3' value='" + octets[2] + "' style='width: 40px;'>. \
							<input type='number' id='editIpAddressOctet4" + fila + "' min='1' max='255' size='3' value='" + octets[3] + "' style='width: 40px;'> \
							";
						break;
				}
				
				var controllerHTML = "<select name='controller' id='editController" + fila + "'style='width: 110px;' onChange='editControllerOpts(" + fila + ")'> \
										<option name='NINGUNO'" + option_name_1 + ">NINGUNO</option> \
										<option name='ARDUINO'" + option_name_2 + ">ARDUINO</option> \
										<option name='RASPBERRY'" + option_name_3 + ">RASPBERRY</option> \
									</select>";
				
				if(graficar == "SI"){
					var graficarHTML = "<input type='checkbox' id='editGraficar" + fila + "' Checked>"
				}
				else{
					var graficarHTML = "<input type='checkbox' id='editGraficar" + fila + "'>"
				}
				
				var estadoHTML = "<select name='estado' id='editEstadoList" + fila + "' style='width: 120px;'>";
				var colorHTML = "<input type='text' class='color' id='editMaqColor" + fila + "' size='6' value='" + color + "'>";
				
				estadoHTML = estadoHTML + $("#estadoList").html();
				estadoHTML = estadoHTML + "</select>";
				
				myTable.rows[fila].cells[7].innerHTML = controllerHTML;
				myTable.rows[fila].cells[8].innerHTML = controllerOptsHTML;
				myTable.rows[fila].cells[9].innerHTML = graficarHTML;
				//myTable.rows[fila].cells[10].innerHTML = estadoHTML.html();
				myTable.rows[fila].cells[10].innerHTML = estadoHTML;
				myTable.rows[fila].cells[11].innerHTML = colorHTML;
				
				var boton = "<button class='boton2' onClick='guardar(" + fila + ")'>Guardar</button>";
				myTable.rows[fila].cells[12].innerHTML = boton;
			}
			else{
				alert("No tiene permisos para cambiar el numero de puerto.");
			}
		}
			
		function showControllerOpts(){
			var controller = $("#controllerList option:selected").attr('name');
			
			if(controller == "ARDUINO"){
				var data = "<strong>Puerto</strong>&nbsp;<select name='arduinoPortList' id='arduinoPortList' style='width: 30px;'> \
								<option name='0'>0</option> \
								<option name='1'>1</option> \
								<option name='2'>2</option> \
								<option name='3'>3</option> \
							</select>";
			}
			else if(controller == "RASPBERRY"){
				var data = "<input type='number' id='raspIpAddressOctet1' min='1' max='255' size='1' value='192' style='width: 40px;'>. \
							<input type='number' id='raspIpAddressOctet2' min='1' max='255' size='3' value='168' style='width: 40px;'>. \
							<input type='number' id='raspIpAddressOctet3' min='1' max='255' size='3' value='0' style='width: 40px;'>. \
							<input type='number' id='raspIpAddressOctet4' min='1' max='255' size='3' value='100' style='width: 40px;'> \
							";
			}
			else{
				var data = "NINGUNO";
			}
			 
			$("#controllerOpts").html(data);
		}
			
		function editControllerOpts(fila){
			var controller = $("#editController" + fila + " option:selected").attr('name');
			var myTable = document.getElementById('maqs');
			
			if(controller == "ARDUINO"){
				var data = "<strong>Puerto</strong>&nbsp;<select name='editPortList' id='editPortList'" + fila + " style='width: 30px;'> \
								<option name='0'>0</option> \
								<option name='1'>1</option> \
								<option name='2'>2</option> \
								<option name='3'>3</option> \
							</select>";
			}
			else if(controller == "RASPBERRY"){
		var data = "<input type='number' id='editIpAddressOctet1" + fila + "' min='1' max='255' size='1' value='192' style='width: 40px;'>. \
					<input type='number' id='editIpAddressOctet2" + fila + "' min='1' max='255' size='3' value='168' style='width: 40px;'>. \
					<input type='number' id='editIpAddressOctet3" + fila + "' min='1' max='255' size='3' value='0' style='width: 40px;'>. \
					<input type='number' id='editIpAddressOctet4" + fila + "' min='1' max='255' size='3' value='100' style='width: 40px;'> \
					";
			}
			else{
				var data = "NINGUNO";
			}
			 
			myTable.rows[fila].cells[8].innerHTML = data;
		}
	</script>
	
	</head>
	
	<body id="body">

		<?php
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/header.php";
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/menu.php";
		?>

		<center>
			<table id='table1' style='width: 80%;'>
				<tr>
					<td colspan='12' style='font-weight: bold;'>AGREGAR MAQUINA</td>
				</tr>
				<tr style='font-weight: bold;'>
					<td>Tipo</td>
					<td>Marca</td>
					<td>Modelo</td>
					<td style='width: 55px;'>Tubos</td>
					<td>Adquirida en</td>
					<td>Servicio Asociado</td>
					<td colspan='2'>Controlador</td>
					<td style='width: 55px;'>Graficar?</td>
					<td>Estado</td>
					<td>Color</td>
					<td>Acciones</td>
				</tr>
				<tr>
					<td style='width: 180px;'>
						<select name="tipo" id="tipoList" style='width: 150px;'>
						<?php
							include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
							$query = " SHOW COLUMNS FROM `maquinas` LIKE 'tipoMaq' ";
							$result = mysqli_query($dbcon, $query );
							$row = mysqli_fetch_array($result , MYSQLI_NUM );
							#extract the values
							#the values are enclosed in single quotes
							#and separated by commas
							$regex = "/'(.*?)'/";
							preg_match_all( $regex , $row[1], $enum_array );
							$enum_fields = $enum_array[1];
							$selected = false;

							foreach($enum_fields as $item){
								if($selected == false){	
									echo "<option name='' Selected>$item</option>";
									$selected = true;
								}
								else{
									echo "<option name=''>$item</option>";
								}
							}
						?>
						</select>
					</td>
					<td style='width: 100px;'><input type="text" name="marca" id="marca" size='10'></td>
					<td style='width: 100px;'><input type="text" name="modelo" id="modelo" size='10'></td>
					<td style='width: 55px;'><input type="number" name="tubos" id="tubos" min="1" max="99" size="3" value="1" style='width: 40px;'></td>
					<td><input type="date" name="fecha" id="fecha"  style='width: 130px;'></td>

					<td style='width: 140px;'>
						<select name="serv" id="servList" style='width: 120px;'>
						<?php
							include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
							$query="SELECT idServ, nombreServ FROM servicios WHERE estado='VIGENTE'";
							$result=mysqli_query($dbcon, $query);
							$selected = false;
							while($fila = mysqli_fetch_array($result, MYSQLI_NUM)){
								if($selected == false){	
									echo "<option name='$fila[0]' Selected>$fila[1]</option>";
									$selected = true;
								}
								else{
									echo "<option name='$fila[0]'>$fila[1]</option>";
								}
							}
							
							$query="SELECT intValue FROM config WHERE descConfig = 'puertos_arduino'";
							$result=mysqli_query($dbcon, $query);
							$row = mysqli_fetch_array($result , MYSQLI_NUM);
							
							echo "<input type='hidden' id='qports' value='$row[0]'>
						
									</select>
								</td>
								<td style='width: 120px;'>
									<select name='controller' id='controllerList' style='width: 110px;' onChange='showControllerOpts()'>
										<option name='NINGUNO' Selected>NINGUNO</option>
										<option name='ARDUINO'>ARDUINO</option>
										<option name='RASPBERRY'>RASPBERRY</option>							
									</select>
								</td>
								<td id='controllerOpts' style='width: 210px;'>
										NINGUNO
								</td>";
							?>
					<td style='width: 50px;'>
						<input type="checkbox" id="graficar">
					</td>
					<td style='width: 140px;' id="tdEstadoList">
						<select name="estado" id="estadoList" style='width: 120px;'>
						<?php
							include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
							$query = " SHOW COLUMNS FROM `maquinas` LIKE 'estado' ";
							$result = mysqli_query($dbcon, $query );
							$row = mysqli_fetch_array($result , MYSQLI_NUM );
							#extract the values
							#the values are enclosed in single quotes
							#and separated by commas
							$regex = "/'(.*?)'/";
							preg_match_all( $regex , $row[1], $enum_array );
							$enum_fields = $enum_array[1];

							$selected = false;

							foreach($enum_fields as $item){
								if($selected == false){	
									echo "<option value='$item' Selected>$item</option>";
									$selected = true;
								}
								else{
									echo "<option value='$item'>$item</option>";
								}
							}
						?>
						</select>
					</td>
					<td><input type='text' class='color' id='maqColor' size='6'></td>
					<td><input type="button" onclick='agregar()' value="Agregar" class="boton2"></td>
				</tr>
			</table>
			<hr>
			<table id='maqs' style='width: 80%;'>
				<?php
					include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
				
					$query="SELECT * FROM maquinas WHERE estado!='ELIMINADA'";
					$result=mysqli_query($dbcon, $query);					

					echo "<tr>
							<td colspan='13' style='font-weight: bold;'>MAQUINAS CARGADAS: " . mysqli_num_rows($result) . "</td>
						</tr>
						<tr style='font-weight: bold;'>
							<td style='width: 30px;'>ID</td>
							<td style='width: 150px;'>TIPO</td>
							<td style='width: 100px;'>MARCA</td>
							<td style='width: 100px;'>MODELO</td>
							<td style='width: 30px;' id='tubos'>TUBOS</td>
							<td>ADQUIRIDA EN</td>
							<td style='width: 120px;'>SERVICIO ASOCIADO</td>
							<td colspan='2'>CONTROLADOR</td>
							<td style='width: 30px;'>GRAFICAR</td>
							<td style='width: 30px;'>ESTADO</td>
							<td style='width: 30px;'>COLOR</td>
							<td>ACCIONES</td>
						</tr>";			

					$n = 2;
					while($fila = mysqli_fetch_array($result, MYSQLI_NUM)){
						$query="SELECT nombreServ FROM servicios WHERE idServ='$fila[6]'";
						$res=mysqli_query($dbcon, $query);
						$serv = mysqli_fetch_array($res, MYSQLI_NUM);
						
						echo "<tr>
								<td style='width: 30px;'>$fila[0]</td>
								<td>$fila[1]</td>
								<td id='marca-$fila[0]'>$fila[2]</td>
								<td id='modelo-$fila[0]'>$fila[3]</td>
								<td>$fila[4]</td>
								<td>$fila[5]</td>
								<td>$serv[0]</td>
								<td style='width: 120px;'>$fila[7]</td>
								<td style='width: 210px;'>$fila[8]</td>
								<td>";
						
								if($fila[9] == "SI"){
									echo "<input type='checkbox' id='editGraficar$n' disabled='true' Checked>";
								}
								else{
									echo "<input type='checkbox' id='editGraficar$n' disabled='true'>";
								}
						
								echo "</td>
								<td id='est-$fila[0]'>$fila[10]</td>
								<td>$fila[11]</td>
								<td><button class='boton2' onclick='edit($n)'>Editar</button></td>
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
