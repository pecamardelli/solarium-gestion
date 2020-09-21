<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<script type="text/javascript" src="componentes/jquery-1.5.2/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="componentes/lightbox/themes/default/jquery.lightbox.css" />
		<script type="text/javascript" src="componentes/lightbox/jquery.lightbox.min.js"></script>
		<script>
			$(document).ready(function(){
				$('.lightbox').lightbox();
			  });
			
			function filtrar(){
				var fecha = document.getElementById('fecha').value;
				var cat = document.getElementById('cat').value;
				var datos = document.getElementById('datos').value;
				var obs = document.getElementById('obs').value;
				
				$(".reg").remove();
				
				$.ajax({
					url: "modulos/logger/filtrarLog.php",
					type: "POST",
					data: { 'fecha': fecha,
							'cat': cat,
							'datos': datos,
							'obs': obs
							},
					success: function(request)
					{
						$('#table1').find('tbody').append(request);
					},
					error: 	function(request)
					{
						alert("ERROR: " + request.responseText);
					}
				});
			}
		</script>
		<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/titulo.php";?>
	</head>
	
	<body id="body">
		<?php
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/header.php";
			include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/menu.php";
		?>
		<div>
			<center>
				<table id='table1' style="width: 90%;">
					<thead>
						<tr>
							<td colspan=5 style="font-weight: bold;">REGISTROS DEL SISTEMA</td>
						</tr>
						<tr>
							<td><input type='button' value='Filtrar' class='boton2' onClick='filtrar()'></td>
							<td><input type='text' id='fecha' class='filtro' value="" size="15"></td>
							<td>
								<select id='cat' style='width: 90px;' class='filtro'>";
									<option value="TODAS" Selected>TODAS</option>
									<?php
										include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
										$query = "SHOW COLUMNS FROM `log` LIKE 'categoria'";
										$result = mysqli_query($dbcon, $query );
										$row = mysqli_fetch_array($result , MYSQLI_NUM );
										#extract the values
										#the values are enclosed in single quotes
										#and separated by commas
										$regex = "/'(.*?)'/";
										preg_match_all( $regex , $row[1], $enum_array );
										$enum_fields = $enum_array[1];

										foreach($enum_fields as $item){
											$item=trim($item, "'");
											echo "<option value='$item'>$item</option>";	
										}
									?>
								</select>
							</td>
							<td><input type='text' id='datos' class='filtro' value="" size="64"></td>
							<td><input type='text' id='obs' class='filtro' value="" size="40"></td>
						</tr>
						<tr style="font-weight: bold;" id='filaBase'>
							<td style="width: 30px;">NUMERO</td>
							<td style="width: 150px;">FECHA</td>
							<td style="width: 30px;">CATEGORIA</td>
							<td style="width: 460px;">DATOS</td>
							<td style="width: 300px;">OBSERVACIONES</td>
						</tr>
					</thead>
					<tbody>
						<?php
							//$query="SELECT * FROM log WHERE 1";
							$query="SELECT * FROM log WHERE 1 ORDER BY id DESC LIMIT 50";
							$result=mysqli_query($dbcon, $query);

							while($fila = mysqli_fetch_array($result, MYSQLI_NUM)){
								$var = htmlspecialchars_decode($fila[4]);
								echo "<tr class='reg'>
										<td>$fila[0]</td>
										<td>$fila[1]</td>
										<td>$fila[2]</td>
										<td>$fila[3]</td>
										<td>$var</td>
									</tr>";
							}
						?>
					</tbody>
				</table>
			</center>
		</div>
		<div id="footer">
			<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/footer.php"; ?>
		</div>
	</body>
</html>
