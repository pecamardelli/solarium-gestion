<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";	

	$nombre = $_POST['nombre'];
	$dni = $_POST['doc'];

	if($dni != ""){
		$search = "dniCliente LIKE '%$dni%' AND estado='ACTIVO'";
		$no_result = "DNI: $dni";
		if($nombre != ""){
			$search = $search . " AND (nombreCliente LIKE '%$nombre%' or apellidoCliente LIKE '%$nombre%') AND estado='ACTIVO'";
			$no_result = $no_result . " y nombre: $nombre";
		}
	}
	elseif($nombre != ""){
		$search = "estado='ACTIVO' AND (nombreCliente LIKE '%$nombre%' or apellidoCliente LIKE '%$nombre%')";
		$no_result = "nombre: $nombre";
	}

	$query="SELECT  idCliente AS id,
					nombreCliente AS nom,
					apellidoCliente AS ap,
					dniCliente AS dni,
					ctaCte AS cta,
					balance AS bal
					FROM clientes WHERE $search";
	$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

	if(mysqli_num_rows($result)){
		while($fila = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			echo "<label id='$fila[id]' class='clienteSeleccionado'>$fila[nom] $fila[ap] - DNI: $fila[dni] - <strong>Balance de cuenta: $$fila[bal]</strong>";
			if(mysqli_num_rows($result) > 1){
				echo "- </label><a href=# onclick='buscar($fila[dni])'>SELECCIONAR</a><br>
					<input type='hidden' id='ctacte' value='$fila[cta]'><input type='hidden' id='balance' value='$fila[bal]'>";
			}
			else{
				echo "</label><br>
					<input type='hidden' id='ctacte' value='$fila[cta]'><input type='hidden' id='balance' value='$fila[bal]'>";
			}
		}
	}
	else{
		echo "No se encontro cliente con $no_result";
	}
?>
