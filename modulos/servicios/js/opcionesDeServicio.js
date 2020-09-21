function opcionesDeServicio(a, id){
	var args = Object.create(null);
	
	switch(a){
		case "agregar":
			args["nombreServ"] = $("#nombreServ").val();
			args["descServ"] = $("#descServ").val();
			args["tipoServ"] = $("#tipoServ option:selected").attr('value');
			args["cantServ"] = $("#cantServ").val();
			args["eventColor"] = $("#eventColor").val();
			JSON.stringify(args);
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
		url: "modulos/servicios/opcionesDeServicio.php",
		type: "POST",
		data: { 'accion': a, 'args': args },
		success: function(request)
		{
			if(request == "OK"){
				alert("DATOS CARGADOS CORRECTAMENTE");
				window.location.replace("servicios.php");
			}
			else{
				//$("#user1").html(request);
				alert(request);
			}
		},
		error: function(request)
		{
			alert("ERROR: " + request.responseText);
		}
	});
}