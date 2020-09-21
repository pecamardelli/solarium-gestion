<?php
include "../../includes/auth.php";
include "../../dbconfig.php";

$prodId = $_POST['prodId'];

$query="SELECT * FROM productos WHERE idProd='$prodId'";
$result=mysqli_query($dbcon, $query);

	if(mysqli_num_rows($result)){
		while($fila = mysqli_fetch_array($result)){
		  echo json_encode($fila);
		}
	}
?>