<?php
	require_once $_SERVER['DOCUMENT_ROOT'] . "sistema/clases/db.class.php";

	class Newsletter
	{
			   
		public function mostrarEditor(){
			echo "<center>
				<table id='table1'>
					<tr style='font-weight: bold;'>
						<td style='width: 136px;'>Título</td>
						<td style='width: 300px;'><input type='text' id='titulo' size='32' maxlength='128' value=''></td>
						<td style='width: 250px;'>Anteriores:
							<select  style='max-width:60%;' name='newsletters' id='newsletters' onchange='load(this.value)'>
								<option value='0'>Elegir...</option>";
								
			$db = new DB();
			$dbcon = $db->connect();
			$query="SELECT * FROM newsletters";
			$result=mysqli_query($dbcon, $query) or die('Consulta no válida: ' . mysqli_error($dbcon));
			
			while($fila = mysqli_fetch_array($result, MYSQLI_NUM)){
				echo "<option value='$fila[0]'>$fila[1]</option>";
			}
					echo "</select>
						</td>
						<td style='width: 100px;'>
							<a href='modulos/newsletter/ayudaNewsletter.php?lightbox[iframe]=true&lightbox[width]=550&lightbox[height]=330' class='lightbox' title='Ayuda'><img id='imgEffects' src='imagenes/$_SESSION[tema]/boton_ayuda.png' onClick=''></a>
							<a href='aplicaciones.php' title='Volver a Aplicaciones'><img id='imgEffects' src='imagenes/$_SESSION[tema]/boton_volver.png' onClick=''>
						</td>
					</tr>
				</table>
				<textarea id='htmlEditor'>
					<p style='text-align: center;'></p>
					<table>
						<tbody>
							<tr>
								<td>
									<img style='display: block; margin-left: auto; margin-right: auto;' src='http://www.oxumsolarium.com.ar/oxum/news/logo_chico.png' alt='Oxum Solarium' width='97' height='89' />
								</td>
								<td>";
								
					$this->mostrarPie();
									
						echo "</td>
							</tr>
						</tbody>
					</table>
				</textarea>
				<br />
				<input type='button' value='ENVIAR' class='boton2' onClick='enviar()'>
			</center>";				
		}
		
		public function mostrarPie(){			
			echo "<strong>OXUM SOLARIUM - LA BARRACA MALL</strong><br />
				Las ca&ntilde;as 1833, local 44 planta alta, ala norte.<br />
				Guaymall&eacute;n, Mendoza.<br />
				261-4598165 // 261-6543381 (Llamadas y WhatsApp)<br />
				<a title='Sitio web de Oxum Solarium' href='http://www.oxumsolarium.com.ar' target='_blank' rel='noopener'>www.oxumsolarium.com.ar</a>";
		}
		
		public function cargarNewsletter($idNews){
			$db = new DB();
			$dbcon = $db->connect();
			$query="SELECT contenido FROM newsletters WHERE idNews='$idNews'";
			$result=mysqli_query($dbcon, $query) or die('Consulta no válida: ' . mysqli_error($dbcon));
			$fila = mysqli_fetch_array($result, MYSQLI_NUM);	
			echo $fila[0];
		}
		
		public function enviarNewsletter(){
			
		}
				
		function __construct() {
				;
		}
			   
		function __destruct() {
				;
		}
	}
?>