<?php include "includes/auth.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<script src="jquery-ui-1.11.4/external/jquery/jquery.js"></script>
		<script text="javascript">
	
		</script>
	</head>
	
	<body id="body">
		<div id='user1'>
			<center>
				<?php
					$command = dirname(__FILE__) . "/asc/./asc status";
					#logger("ARDUINO", $command);
					$output = shell_exec($command);
					$data = explode(",", $output);
					print_r($data);
				?>
			</center>
		</div>			
	</body>
</html>
