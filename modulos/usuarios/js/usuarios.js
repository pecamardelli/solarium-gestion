function acciones(a, id){
	var args = Object.create(null);
	
	switch(a){
		case "agregar":
			args = null;
			break;
		case "cargar":
			args["id"] = id;
			args["user"] = $("#us").val();
			args["nom"] = $("#nom").val();
			args["ap"] = $("#ap").val();
			args["dni"] = $("#dni").val();
			args["cel"] = $("#cel").val();
			args["rol"] = $("#rol option:selected").attr('value');
			args["tema"] = $("#tema option:selected").attr('value');
			args["est"] = $("#estado option:selected").attr('value');
			args["email"] = $("#email").val();
			args["obs"] = $("#obs").val();
			args["paguor1"] = $("#paguor1").val();
			args["paguor2"] = $("#paguor2").val();
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