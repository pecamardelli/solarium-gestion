<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php 
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/titulo.php";
		
			session_start();
			if($_SESSION['logged']){
				HEADER("location: agenda.php");
			}
		?>
		<script src="componentes/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
		<script type="text/javascript">
			function login(){
				var user = document.getElementById('usuario');
				var pass = document.getElementById('paguor');
				
				if(user.value == "" || pass.value == ""){
					alert("Ambos campos son obligatorios.");
					return false;
				}
				var root = document.location.hostname;
				$.ajax ({
					url: 'includes/login.php',
					type:  'post',
					data: 	{ 'user': user.value, 'pass': pass.value },
					success: function(request)
					{
						if(request == "OK"){
							window.location = "agenda.php";
						}
						else{
							alert(request);
						}
					}
				});
			}
			
			function enter(e){
				if(e.keyCode == 13){
					login();
				}
				
			}
			
		</script>
	</head>
	
	<body id="body">

		<div id="header">
			<img src="imagenes/logo.png">
		</div>

		<div id='login' style='height: 350px'>
			<center>
				<table id='table1' style='margin-top: 150px;'>
					<tr>
						<td colspan=2>LOGIN</td>
					</tr>
					<tr>
						<td>Usuario</td>
						<td style='width: 200px'><input type="text" id='usuario' name="user" placeholder="usuario..." required></td>
					</tr>
					<tr>
						<td>Password</td>
						<td style='width: 200px'><input type="password" id='paguor' name="password" placeholder="password..." onKeyPress='return enter(event)' required></td>
					</tr>
					<tr>
						<td colspan=2><input type="button" value="Login" class='boton2' onClick="login()"></td>
					</tr>
				</table>
			</center>
		</div>
		
		<div id="footer">
			<?php
				include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/footer.php";
			?>
		</div>

	</body>
</html>
