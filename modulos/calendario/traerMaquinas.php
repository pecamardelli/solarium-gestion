<?php
	require $_SERVER['DOCUMENT_ROOT'] . "sistema/clases/db.class.php";
	$db = new DB();
	$dbcon = $db->connect();

	$idServ = $_POST['idServ'];

	$query="SELECT idMaq, marcaMaq
			FROM maquinas
			WHERE idServicio='$idServ' AND estado='VIGENTE'";
	$result = mysqli_query($dbcon, $query) or die('Consulta no válida: ' . mysqli_error($dbcon));
	echo "<br><br>Elegir maquina\t<select name='maq' id='modalMaqList'>";
	while($fila2 = mysqli_fetch_array($result, MYSQLI_NUM)){
			echo "<option value='$fila2[0]'>$fila2[1]</option>";
	}
	echo "</select>";

	#logger("INFO", $_SESSION['user'] . " cambio la configuracion de la maquina " . $id . ": " . $controller . ", " . $controllerOpt . ", graficar: " . $graficar . ", " . $estado);
?>