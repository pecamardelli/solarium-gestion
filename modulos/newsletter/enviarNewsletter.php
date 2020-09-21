<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/modulos/logger/log.php";
	
	$contenido = $_REQUEST['contenido'];
	$titulo = $_REQUEST['titulo'];

	$query="SELECT emailCliente FROM clientes";
	$result=mysqli_query($dbcon, $query) or die('Consulta no válida: ' . mysqli_error($dbcon));
	$enviados = 0;
	$fallidos = 0;

	while($destinatario = mysqli_fetch_array($result, MYSQLI_NUM)){
		if($destinatario[0] != ""){
			$com = "sendEmail -f info@oxumsolarium.com.ar -t $destinatario[0] -s smtp.gmail.com:587 -o tls=yes -o message-content-type=html -xu oxumsolarium@gmail.com -xp Cach1986 -u 'OXUM SOLARIUM - $titulo' -m '$contenido'";
			exec($com, $output, $code);
			#echo $com;
			if($code == 0){
				(($enviados++));
			}
			else{
				(($fallidos++));
			}
		}
	}
	$query="INSERT INTO newsletters (titulo, contenido) VALUES ('$titulo', '$contenido')";
	$result=mysqli_query($dbcon, $query) or die('Consulta no válida: ' . mysqli_error($dbcon));
	logger("INFO", $_SESSION['user'] . " - Se envió correctamente el newsletter de título $titulo. Enviados: $enviados - Fallidos: $fallidos");

	echo "NEWSLETTER EN PROCESO DE ENVÍO!\n\nChequear registros...";
?>
