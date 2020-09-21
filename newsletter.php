<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/titulo.php"; ?>
		<script src="componentes/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
		<script src='componentes/tinymce/js/tinymce/tinymce.min.js'></script>
		<script src='modulos/newsletter/js/newsletter.js'></script>
		<script type="text/javascript" src="componentes/jquery-1.5.2/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="componentes/lightbox/themes/default/jquery.lightbox.css" />
		<script type="text/javascript" src="componentes/lightbox/jquery.lightbox.min.js"></script>
		<script>
			$(document).ready(function(){
				$('.lightbox').lightbox();
			  });
		</script>
	</head>
	
	<body id="body">

		<?php
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/header.php";
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/menu.php";
		?>

		<div id='user1'>
			<?php
				require_once $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/newsletter/newsletter.class.php";
				$editor = new Newsletter();
				$editor->mostrarEditor();
			?>
		</div>
		<div id="footer">
			<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/footer.php"; ?>
		</div>
	</body>
</html>
