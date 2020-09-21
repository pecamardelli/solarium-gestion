<?php
	session_start();
	if($_SESSION['rol'] > $access_level){
		include "../dbconfig.php";
		include "log.php";
		logger("WARNING", $_SESSION['user'] . " (rol " . $_SESSION['rol'] . ") intento acceder a un apartado con nivel de acceso $access_level");
		HEADER("location: agenda.php");	
	}
?>