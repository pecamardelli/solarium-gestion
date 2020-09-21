<?php
	session_start();
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";
	logger("SYSTEM", "Usuario " . $_SESSION['user'] . " cerro la sesion en el sistema");
	$_SESSION = array();
	session_unset();
	session_destroy();
	HEADER("location: index.php");
?>