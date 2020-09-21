function mostrarConfiguraciones(){
	$.ajax({
		url: "modulos/configuraciones/opcionesDeConfiguracion.php",
		type: "POST",
		data: { 'accion': "mostrar", 'args': null },
		success: function(request)
		{
			$("#contenedor").html(request);
		},
		error: function(request)
		{
			alert("ERROR: " + request.responseText);
		}
	});
}

function guardarConfiguraciones(){
	var args = Object.create(null);
	args["vent"] = $('#vent').val();
	args["ilum"] = $('#ilum').val();
	args["wait"] = $('#wait').val();
	args["ports"] = $('#ports').val();
	args["agStart"] = $('#agStart').val();
	args["agEnd"] = $('#agEnd').val();
	args["agView"] = $('#agView option:selected').val();
	JSON.stringify(args);

	$.ajax({
		url: "modulos/configuraciones/opcionesDeConfiguracion.php",
		type: "POST",
		data: { 'accion': "guardar", 'args': args },
		success: function(request)
		{
			if(request == "OK"){
				alert("CONFIGURACIONES GUARDADAS CORRECTAMENTE");
			}
			else{
				alert(request);
			}
		},
		error: function(request)
		{
			alert("ERROR: " + request.responseText);
		}
	});
}