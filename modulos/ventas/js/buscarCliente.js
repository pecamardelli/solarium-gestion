function buscar(dni){
	if(!dni){
		var nombre = $("#buscarNombre").val();
		var doc = $("#buscarDni").val();
	}
	else{
		var doc = dni;
	}
	
	if(!nombre && !doc){
		alert("Ingrese nombre y/o documento para buscar.");
		return;
	}
	
	$.ajax ({
		url: 'modulos/ventas/buscarCliente.php',
		type:  'post',
		data: 	{ 'nombre': nombre,
				  'doc': doc
				},
		success: 	function(request, settings)
		{
		  $('#encontrado').html(request);
		},
		error: 	function(request, settings)
		{
		  $('#encontrado').html('Error: ' + request.responseText);
		}
	});
}