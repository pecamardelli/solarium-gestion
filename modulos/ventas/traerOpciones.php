<?php
include "../../includes/auth.php";
$servId = $_POST['servId'];

include "../../dbconfig.php";
$query="SELECT * FROM opciones WHERE idServ='$servId' AND estado='VIGENTE'";
$result=mysqli_query($dbcon, $query);

	if(mysqli_num_rows($result)){
	$first=" selected";
		while($fila = mysqli_fetch_array($result, MYSQLI_NUM)){
		  echo "<option id='$fila[0]' value='$fila[4]'" . $first . ">$fila[3]</option>";
			$first="";
		}
	}
?>
