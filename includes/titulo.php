<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>OXUM SOLARIUM - MENDOZA</title>
<?php
	echo "<link rel='stylesheet' type='text/css' href='estilos/";

	if(isset($_SESSION['tema'])){
		echo $_SESSION['tema'];
	}
	else{
		echo "morado";
	}

	echo "_estilo_1.css'>";

	setlocale(LC_TIME, 'es_ES.UTF-8');?>
