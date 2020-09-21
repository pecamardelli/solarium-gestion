<?php include "includes/auth.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include "includes/titulo.php"; ?>
		<script src="jquery-ui-1.11.4/external/jquery/jquery.js"></script>
		<script src='tinymce/js/tinymce/tinymce.min.js'></script>
		<script>
			tinymce.init({
			  selector: '#htmlEditor',
			  height: 500,
			  width: 800,
			  menubar: false,
			  language: 'es_AR',
			  plugins: [
				'advlist autolink lists link image charmap print preview anchor',
				'searchreplace visualblocks code fullscreen',
				'insertdatetime media table contextmenu paste code'
			  ],
			  toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
			  content_css: [
				'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
				'//www.tinymce.com/css/codepen.min.css']
			});
			
			function enviar(){
				var html_code = tinymce.get('htmlEditor').getContent();
				//alert(html_code);
				if(confirm("CONFIRMAR ENVIO DE NEWSLETTER?")){					
					$.ajax({
						url: "enviar_news.php",
						type: "POST",
						data: { 'contenido': html_code },
						success: function(request)
						{
							alert(request);
							window.location.replace("newsletter.php");
						},
						error: 	function(request)
						{
							alert("ERROR: " + request.responseText);
						}
					});
				}
			}
		</script>
	</head>
	
	<body id="body">

		<?php
			include "includes/header.php";
			include "includes/menu.php";
		?>

		<div id='user1'>
			<center>
				<textarea id='htmlEditor'>
					<p style='text-align: center;'>&nbsp;</p>
					<table>
						<tbody>
							<tr>
								<td>
									<img style='display: block; margin-left: auto; margin-right: auto;' src='imagenes/logo_chico.png' alt='Oxum Solarium' width='97' height='89' />
								</td>
								<td>
									OXUM SOLARIUM - LA BARRACA MALL<br />
									Las ca&ntilde;as 1833, local 44 planta alta, ala norte.<br />
									Guaymall&eacute;n, Mendoza.<br />
									261-4598165 // 261-6543381 (Llamadas y WhatsApp)<br />
									<a title='Sitio web de Oxum Solarium' href='http://www.oxumsolarium.com.ar' target='_blank' rel='noopener'>www.oxumsolarium.com.ar</a>
								</td>
							</tr>
						</tbody>
					</table>
				</textarea>
				<input type="button" value="Ver" class='boton2' onClick="enviar()">
			</center>
		</div>
		<div id="footer">
			<?php
				include "includes/footer.php";
			?>
		</div>
	</body>
</html>
