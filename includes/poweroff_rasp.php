<?php
	include "../dbconfig.php";
	include "log.php";

	$b1 = $_REQUEST['b1'];
	$b2 = $_REQUEST['b2'];
	$b3 = $_REQUEST['b3'];
	$b4 = $_REQUEST['b4'];

	$command = "ssh pi@$b1.$b2.$b3.$b4 'bash /home/pi/Solarium/Scripts/poweroff.sh'";
	$output = shell_exec($command);
	logger("RASPBERRY", $output . " - IP: $b1.$b2.$b3.$b4");
	echo $output;
?>

