<?php include "includes/auth.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include "includes/titulo.php"; ?>
		<script src="jquery-ui-1.11.4/external/jquery/jquery.js"></script>
		<script text="javascript">
			function cargarCliente(){
				
				var id = document.getElementById('idCli').value;
				var nombre = document.getElementById('nomCli').value;
				var apellido = document.getElementById('apCli').value;
				var dni = document.getElementById('dniCli').value;
				var email = document.getElementById('emailCli').value;
				var cel1 = document.getElementById('cel1Cli').value;
				var cel2 = document.getElementById('cel2Cli').value;
				var estado = document.getElementById('estadoCli').value;
				var zona = document.getElementById('selectZona');
				var opcion = document.getElementById('opCli').value;
				var cuenta = document.getElementById('ctaCte').value;
				var knownBy = document.getElementById('selectKnownBy');
				var balance = document.getElementById('balance').value;
				
				if(!zona){
					zona = document.getElementById('textZona').value;
				}
				else{
					zona = zona.options[zona.selectedIndex].value;
				}
				
				if(!knownBy){
					knownBy = document.getElementById('textKnownBy').value;
				}
				else{
					knownBy = knownBy.options[knownBy.selectedIndex].value;
				}
				
				if(nombre == "" || apellido == "" || dni == "" || knownBy == ""){
					alert("Los siguientes campos son obligatorios:\n\nNOMBRE, APELLIDO, DNI, NOS CONOCIO POR");
					return false;
				}
				
				$.ajax({
					url: "includes/agregarCliente.php",
					type: "POST",
					data: { 'id': id,
						  	'nombre': nombre,
						  	'apellido': apellido,
						  	'dni': dni,
						  	'email': email,
						  	'cel1': cel1,
						  	'cel2': cel2,
						  	'estado': estado,
						  	'zona': zona,
						   	'cuenta': cuenta,
						    'knownBy': knownBy,
						  	'balance': balance,
						   	'opcion': opcion
						  },
					success: function(request)
								{
									alert(request);
									window.location = "clientes.php";
								}
				});
			}
			
			function cambiarKnownBy(valor){
				var text1 = "<input type='text' id='textKnownBy' size='28' maxLength='128' value=''>";
				if(valor == "otro"){
					$("#knownBy").html(text1);
				}				
			}
			
			function cambiarZona(valor){
				var text1 = "<input type='text' id='textZona' size='28' maxLength='128' value=''>";
				if(valor == "otro"){
					$("#zona").html(text1);
				}				
			}
		</script>
	</head>
	
	<body id="body">

		<?php
			include "includes/header.php";
			include "includes/menu.php";
		?>

		<div id='user1'>
			<center>
				<table cellpadding="3px" id="table1">
					<?php
						$id = $_REQUEST['id'];
						$option="ADD";
						include "dbconfig.php";
						if(isset($id)){
							$query="SELECT 	idCliente AS id,
											tipoCliente AS tipo,
											nombreCliente AS nom,
											apellidoCliente AS ap,
											dniCliente AS dni,
											emailCliente AS email,
											telCliente AS tel1,
											telCliente2 AS tel2,
											idZona AS zona,
											idKnownBy AS knownBy,
											balance AS bal
											FROM clientes WHERE idCliente='$id'";
							$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
							$fila=mysqli_fetch_array($result, MYSQLI_ASSOC);
							$option="UPDATE";
							$boton = "Actualizar";
						}
						else{
							$boton = "Cargar";
							$id = "NULL";
						}

						echo "<tr>
							<td colspan='2' style='font-weight: bold;'>AGREGAR CLIENTE - 
								<a href='listaClientes.php'><input type='button' class='boton2' value='Ver Todos'></a>
								<input type='hidden' name='opcion' id='opCli' value='$option'>
								<input type='hidden' name='id' id='idCli' value='$id'>
							</td>
						</tr>
						<tr>
							<td>Nombre</td>
							<td style='width: 260px;'><input type='text' id='nomCli' name='nombre' size='28' maxLength='64' value='$fila[nom]'></td>
						</tr>
						<tr>
							<td>Apellido</td>
							<td><input type='text' id='apCli' name='apellido' size='28' maxLength='64' value='$fila[ap]'></td>
						</tr>
						<tr>
							<td>DNI</td>
							<td><input type='text' id='dniCli' name='dni' size='28' maxLength='16' value='$fila[dni]'></td>
						</tr>
						<tr>
							<td>E-mail</td>
							<td><input type='text' id='emailCli' name='email' size='28' maxLength='128' value='$fila[email]'></td>
						</tr>
						<tr>
							<td>Telefono Celular</td>
							<td><input type='text' id='cel1Cli' name='celular' size='28' maxLength='32' value='$fila[tel1]'></td>
						</tr>
						<tr>
							<td>Telefono Alternativo</td>
							<td><input type='text' id='cel2Cli' name='celular2' size='28' maxLength='32' value='$fila[tel2]'></td>
						</tr>
						<tr>
							<td>Tipo de cliente</td>
							<td>
								<select id='tipoCli' name='tipoCli' style='width: 140px;'>";
									$query = " SHOW COLUMNS FROM `clientes` LIKE 'tipoCliente' ";
									$result = mysqli_query($dbcon, $query );
									$row = mysqli_fetch_array($result , MYSQLI_NUM );
									#extract the values
									#the values are enclosed in single quotes
									#and separated by commas
									$regex = "/'(.*?)'/";
									preg_match_all( $regex , $row[1], $enum_array );
									$enum_fields = $enum_array[1];
					
									foreach($enum_fields as $item){
										echo "<option value='$item'";
										if($item == $fila['tipo']){
											echo " Selected";
										}

										echo ">$item</option>";	
									}
						echo "</select>
							</td>
						</tr>
						<tr>
							<td>Estado</td>
							<td>
								<select id='estadoCli' name='estadoCli' style='width: 140px;'>";
									$query = " SHOW COLUMNS FROM `clientes` LIKE 'estado' ";
									$result = mysqli_query($dbcon, $query );
									$row = mysqli_fetch_array($result , MYSQLI_NUM );
									#extract the values
									#the values are enclosed in single quotes
									#and separated by commas
									$regex = "/'(.*?)'/";
									preg_match_all( $regex , $row[1], $enum_array );
									$enum_fields = $enum_array[1];
					
									foreach($enum_fields as $item){
										echo "<option value='$item'";
										if($item == "ACTIVO"){
											echo " Selected";
										}

										echo ">$item</option>";	
									}
							echo "</select>
							</td>
						</tr>
						<tr>
							<td>Cuenta corriente</td>
							<td>
								<select id='ctaCte' name='cuentaCte' style='width: 140px;'";

								if($_SESSION['rol'] > 2){
									echo " disabled='disabled'";
								}
								echo ">";
					
								$query = "SHOW COLUMNS FROM `clientes` LIKE 'ctaCte'";
								$result = mysqli_query($dbcon, $query );
								$row = mysqli_fetch_array($result , MYSQLI_NUM );
								#extract the values
								#the values are enclosed in single quotes
								#and separated by commas
								$regex = "/'(.*?)'/";
								preg_match_all( $regex , $row[1], $enum_array );
								$enum_fields = $enum_array[1];
					
								foreach($enum_fields as $item){
									echo "<option value='$item'";

									if($item == "NO HABILITADA"){
										echo " Selected";
									}

									echo ">$item</option>";	
								}
							echo "</select>
							</td>
						</tr>
						<tr>
							<td>Zona</td>
							<td id='zona'>
								<select id='selectZona' name='zonaCli' style='width: 140px;' onchange='cambiarZona(this.value)'>";
					
								$query="SELECT idConf, charValue FROM config WHERE descConfig = 'zona'";
								$result2=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
								while($fila2 = mysqli_fetch_array($result2, MYSQLI_NUM)){
									if($fila2[0] == "$fila[zona]"){
										echo "<option value='$fila2[0]' Selected>$fila2[1]</option>";
									}
									else{
										echo "<option value='$fila2[0]'>$fila2[1]</option>";
									}
								}
							echo "<option value='otro'>Otro...</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Nos conoció por:</td>
							<td id='knownBy'>
								<select id='selectKnownBy' name='nosConocioPor' style='width: 140px;' onchange='cambiarKnownBy(this.value)'>";
					
								$query="SELECT idConf, charValue FROM config WHERE descConfig = 'nos_conocio_por'";
								$result2=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
								while($fila2 = mysqli_fetch_array($result2, MYSQLI_NUM)){
									if($fila2[0] == "$fila[knownBy]"){
										echo "<option value='$fila2[0]' Selected>$fila2[1]</option>";
									}
									else{
										echo "<option value='$fila2[0]'>$fila2[1]</option>";
									}
								}

							if(!$fila[bal]){
								$fila[bal] = 0;
							}
					
							echo "<option value='otro'>Otro...</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Balance cta. cte.</td>
							<td><input type='number' name='balance' id='balance' max='99999' size='2' value='$fila[bal]' onchange=''></td>
						</tr>
						<tr>
							<td colspan='2'>
								<input type='button' value='$boton' class='boton2' onClick='cargarCliente()'>
							</td>
						</tr>";
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
