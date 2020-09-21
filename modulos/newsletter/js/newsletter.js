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

function acciones(a, id){
	var args = Object.create(null);
	
	switch(a){
		case "cargar":
			args["id"] = id;
			JSON.stringify(args);
			$.ajax({
				url: "modulos/newsletter/opcionesNewsletter.php",
				type: "POST",
				data: { 'accion': "cargar", 'args': args },
				success: function(request)
				{
					tinymce.get('htmlEditor').setContent(request);
				},
				error: 	function(request)
				{
					$('#htmlEditor').html(request);
				}
			});
			break;
		case "editar":
			args["id"] = id;
			JSON.stringify(args);
			break;
		case "listar":
			args = null;
			break;
		default:
			alert("Accion invalida.");
			return false;
	}
	

	
	$.ajax({
		url: "modulos/usuarios/opcionesDeUsuario.php",
		type: "POST",
		data: { 'accion': a, 'args': args },
		success: function(request)
		{
			if(request == "OK"){
				alert("DATOS CARGADOS CORRECTAMENTE");
				window.location.replace("usuarios.php");
			}
			else{
				$("#user1").html(request);
			}
		},
		error: function(request)
		{
			alert("ERROR: " + request.responseText);
		}
	});
}

function enviar(){
	var titulo = $('#titulo').val();
	if(titulo == ""){
		alert("INGRESAR TITULO.");
		return false;
	}
	var html_code = tinymce.get('htmlEditor').getContent();
	//alert(html_code);
	if(confirm("CONFIRMAR ENVIO DE NEWSLETTER?")){					
		$.ajax({
			url: "modulos/newsletter/enviarNewsletter.php",
			type: "POST",
			data: { 'titulo': titulo, 'contenido': html_code },
			success: function(request)
			{
				alert(request);
				window.location.replace("newsletter.php");
			},
			error: 	function(request)
			{
				alert("ERROR: " + request);
			}
		});
	}
}

function load(idNews){
	
}