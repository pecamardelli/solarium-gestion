<link rel="stylesheet" type="text/css" href="estilos/<?php echo $_SESSION['tema'];?>_usermenu.css">
<script>
	function power_off(b1,b2,b3,b4) {
		//alert(b1 + "." + b2 + "." + b3 + "." + b4);
		$.ajax(
			{
				url:  '<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/sistema/includes/poweroff_rasp.php',
				type: 'POST',
				data: { 'b1': b1,
					   	'b2': b2,
					   	'b3': b3,
					   	'b4': b4
					  },
				success: function(data) {
					alert(data);
				 }
			}
		);
	}
	
	function salir(){
		if(confirm("Cerrar la sesion?")){
			window.location = "includes/logout.php";
		}
	}
	
	function status()
    {
        $.ajax(
            {
                url:  "modulos/maquinas/estadoMaquinas.php",
                type: "post",
                data: null,
                success: function(data) {
					$("#status").html(data);					
                 }
            }
        );
    }
	setInterval(status,4000);
</script>
<div id="header" style='width: 30%; float: left;'>
	<img src="imagenes/logo.png">
	<script type="text/javascript">status();</script>
</div>
<div id="status" style='width: 40%; float: left;'>
	
</div>
<div id="header" style='width: 30%; float: right; text-align: right'>
	<p id='usermenu'>
		
		<?php echo $_SESSION['nombre']; ?><br><br>
		Versión 2.0&nbsp;
		<?php
			session_start();
			$tema=$_SESSION['tema'];
			if($_SESSION['rol'] < 4){
				echo "<a href='aplicaciones.php'><img id='imgEffects' src='imagenes/$tema/config.png' title='Aplicaciones'></a>";
			}
		
			if($_SESSION['rol'] < 3){
				echo "<a href='papelera.php'><img id='imgEffects' src='imagenes/$tema/recycle_bin.png' title='Papelera'></a>";
			}		
			echo "<a href='modulos/usuarios/perfil.php'><img id='imgEffects' src='imagenes/$tema/profile.png' title='Mi perfil'></a>
			<img id='imgEffects' src='imagenes/$tema/logout.png' title='Cerrar sesión' onClick='salir()' style='cursor: pointer;'>";
			?>
	</p>
</div>
<div style='clear: both;'>
</div>
