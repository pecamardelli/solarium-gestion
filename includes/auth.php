<?php
	session_start();
	if(!$_SESSION['logged']){
		HEADER("location:index.php");
		die;
	}
?>