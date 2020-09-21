<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/titulo.php";?>
		<script type="text/javascript" src="componentes/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
		<script type="text/javascript">
			function changeInputState(){
				$("#passChg").change(function(){
					if($(this).is(":checked")){
						$("#paguor1").removeAttr('disabled');
						$("#paguor2").removeAttr('disabled');
					}
					else{
						$("#paguor1").attr('disabled', 'disabled');
						$("#paguor2").attr('disabled', 'disabled');
					}
				});
			}
			
			function actualizar(){
				var id = <?php echo $_SESSION['id']; ?>;
				var nombre = document.getElementById('nomUser').value;
				var apellido = document.getElementById('apUser').value;
				var dni = document.getElementById('dniUser').value;
				var email = document.getElementById('mailUser').value;
				var cel = document.getElementById('celUser').value;
				var estado = "ACTIVO";
				var dir = document.getElementById('dirUser').value;
				var tema = document.getElementById('temaUser').value;
				var rol = <?php echo $_SESSION['rol']; ?>;
				var user = document.getElementById('user').value;
				var pass1 = document.getElementById('paguor1').value;
				var pass2 = document.getElementById('paguor2').value;
				
				/*alert("ID: " + id +
					  "\nnombre: " + nombre +
					  "\napellido: " + apellido +
					  "\ndni: " + dni +
					  "\nemail: " + email +
					  "\ncel: " + cel +
					  "\nestado: " + estado +
					  "\ndir: " + dir +
					  "\ntema: " + tema +
					  "\npass1: " + pass1 +
					  "\npass2: " + pass2 +
					  "\nrol: " + rol);*/

				if(nombre == ""){
					alert("El nombre es obligatorio.");
					return false;
				}
				
				if(apellido == ""){
					alert("El apellido es obligatorio.");
					return false;
				}
				
				if(cel == ""){
					alert("El número de celular es obligatorio.");
					return false;
				}
				
				if($('#passChg').is(":checked")){
					if(pass1 = ""){
						alert("No están permitidas las contraseñas en blanco.");
						return false;
					}

					if(document.getElementById('paguor1').value != document.getElementById('paguor2').value){
						alert("Las contraseñas no coinciden.");
						return false;
					}
					var passwd = document.getElementById('paguor1').value;
				}
				else{
					var passwd = "NULL";	
				}
				
				
				$.ajax({
					url: "modulos/usuarios/actualizarUsuario.php",
					type: "POST",
					data: { 'nom': nombre,
							'ap': apellido,
						   	'dni': dni,
						   	'dir': dir,
						   	'cel': cel,
							'email': email,
						    'rol': rol,
						    'userId': id,
						    'estado': estado,
						    'tema': tema,
						    'user': user,
							'pass': passwd
							},
					success: function(request)
					{
						if(request == "OK"){
							alert("DATOS ACTUALIZADOS CORRECTAMENTE.");
							window.location = "modulos/usuarios/perfil.php";
						}
						else{
							alert(request);
						}
						
					},
					error: function(request)
					{
						alert("ERROR: " + request.responseText);
					}
				});
				
			}
			
		</script>
	</head>
	
	<body id="body">

		<?php
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/header.php";
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/menu.php";
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";

			$id = $_SESSION['id'];

			$query="SELECT userName AS us, usuarioNombre AS nom, usuarioApellido AS ap, usuarioDni AS dni, usuarioDir AS dir, usuarioCel AS cel, usuarioEmail AS email, usuarioTema AS tema, estado AS estado, usuarioRol AS rol FROM usuarios WHERE idUsuario='$id'";
			$result = mysqli_query($dbcon, $query);
			
			if($result){
				$fila = mysqli_fetch_array($result, MYSQLI_ASSOC);
			}
			else{
				die("ERROR: " . mysqli_error($dbcon));
			}

			echo "<div>
				<center>
					<table id='table1'>
						<tr>
							<td colspan=2>MIS DATOS</td>
						</tr>
						<tr>
							<td>Nombre</td>
							<td style='width: 200px'><input type='text' maxlength=128 id='nomUser' name='nom' class='inputs' value='" . $fila['nom'] . "'></td>
						</tr>
						<tr>
							<td>Apellido</td>
							<td style='width: 200px'><input type='text' maxlength=128 id='apUser' name='ap' class='inputs' value='" . $fila['ap'] . "'></td>
						</tr>
						<tr>
							<td>DNI</td>
							<td style='width: 200px'><input type='text' maxlength=128 id='dniUser' name='dni' class='inputs' value=" . $fila['dni'] . "></td>
						</tr>
						<tr>
							<td>Dirección</td>
							<td style='width: 200px'><input type='text' maxlength=128 id='dirUser' name='dir' class='inputs' value='" . $fila['dir'] . "'></td>
						</tr>
						<tr>
							<td>Celular</td>
							<td style='width: 200px'><input type='text' maxlength=32 id='celUser' name='cel' class='inputs' value=" . $fila['cel'] . "></td>
						</tr>
						<tr>
							<td>Email</td>
							<td style='width: 200px'><input type='email' id='mailUser' name='email' class='inputs' value=" . $fila['email'] . "></td>
						</tr>
						<tr>
							<td>Usuario</td>
							<td style='width: 200px'><input type='text' id='user' name='usuario' class='inputs' value=" . $fila['us'] . "></td>
						</tr>
						<tr>
							<td>Tema</td>
							<td style='width: 190px;'>
								<select id='temaUser' style='width: 100px;' class='inputs'>";
									$query = "SHOW COLUMNS FROM `usuarios` LIKE 'usuarioTema'";
									$result = mysqli_query($dbcon, $query );
									$row = mysqli_fetch_array($result , MYSQLI_NUM );
									#extract the values
									#the values are enclosed in single quotes
									#and separated by commas
									$regex = "/'(.*?)'/";
									preg_match_all( $regex , $row[1], $enum_array );
									$enum_fields = $enum_array[1];

									foreach($enum_fields as $item){
										$item=trim($item, "'");
										echo "<option value='$item'";

										if($item == $fila['tema']){
											echo " Selected";
										}

										echo ">$item</option>";	
									}
							echo "</select>
							</td>
						</tr>
						<tr>
							<td colspan='2'>
								<input type='checkbox' name='changepass' id='passChg' onClick='changeInputState()'>
								Cambiar contraseña
							</td>
						</tr>
						<tr>
							<td>Password</td>
							<td style='width: 200px'><input type='password' maxlength=64 id='paguor1' name='pass1' class='inputs' disabled='disabled' placeholder='Max 64 caracteres...'></td>
						</tr>
						<tr>
							<td>Reingresar</td>
							<td style='width: 200px'><input type='password' maxlength=64 id='paguor2' name='pass2' class='inputs' disabled='disabled' placeholder='Max 64 caracteres...'></td>
						</tr>
						<tr>
							<td colspan=2><input type='button' value='Actualizar' class='boton2' onClick='actualizar()'></td>
						</tr>
					</table>
				</center>
			</div>";
		?>
		<div id="footer">
			<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/footer.php"; ?>
		</div>
	</body>
</html>
