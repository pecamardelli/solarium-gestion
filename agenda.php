<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>OXUM SOLARIUM - MENDOZA</title>
		<link rel="stylesheet" type="text/css" href="estilos/<?php echo $_SESSION['tema'];?>_estilo_2.css">
		<?php setlocale(LC_TIME, 'es_ES.UTF-8');?>
		
		<link href="componentes/fullcalendar/2.6.1/fullcalendar.css" type="text/css" rel="stylesheet" />
		<link href="componentes/jquery-ui-1.11.4/jquery-ui.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="componentes/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
		<script type="text/javascript" src="componentes/jquery-ui-1.11.4/jquery-ui.js"></script>
		<script type="text/javascript" src="componentes/moment.js/2.12.0/moment.js"></script>
		<script type="text/javascript" src="componentes/fullcalendar/2.6.1/fullcalendar.js"></script>
		<script type="text/javascript" src="componentes/fullcalendar/2.6.1/lang/es.js"></script>		
		<script type="text/javascript" src="modulos/calendario/js/calendario.js"></script>
		<style>
			.ui-dialog-titlebar {
				  //background:red;
			}
		</style>
	</head>
	
	<body id="body">
		<?php
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/header.php";
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/menu.php";
		?>
		<br>
		<div id="calendar"></div>
		<br>
		<div id="eventContent" title="Detalles del turno" style="display:none;">
			<p id="eventInfo"></p>
		</div>
		<div id="footer">
			<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/footer.php"; ?>
		</div>
	</body>
</html>
