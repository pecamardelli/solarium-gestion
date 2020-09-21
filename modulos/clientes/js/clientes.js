function acciones(a, p){
	var args = Object.create(null);
	
	switch(a){
		case "agregar":
			args = null;
			break;
		case "guardar":
			args["id"] = p;
			args["tipo"] = $("#tipoCli option:selected").attr('value');
			args["nom"] = $("#nomCli").val();
			args["ap"] = $("#apCli").val();
			args["dni"] = $("#dniCli").val();
			args["cel"] = $("#celCli").val();
			args["ctaCte"] = $("#ctaCte option:selected").attr('value');
			args["zona"] = $("#selectZona option:selected").attr('value');
			args["est"] = $("#estadoCli option:selected").attr('value');
			args["knownby"] = $("#selectKnownBy option:selected").attr('value');
			args["email"] = $("#emailCli").val();
			args["balance"] = $("#balance").val();
			JSON.stringify(args);
			break;
		case "editar":
			args["id"] = id;
			JSON.stringify(args);
			break;
		case "listar":
			args = null;
			break;
		case "filtrar":
			args["nom"] = $("#filtroNom").val();
			args["dni"] = $("#filtroDni").val();
			args["email"] = $("#filtroEmail").val();
			args["tel"] = $("#filtroTel").val();
			args["zona"] = $("#filtroZona option:selected").attr('value');
			args["tipo"] = $("#filtroTipo option:selected").attr('value');
			args["knownby"] = $("#filtroKnownBy option:selected").attr('value');
			args["est"] = $("#filtroEstado option:selected").attr('value');
			args["balance"] = $("#filtroBalance option:selected").attr('value');
			JSON.stringify(args);
			break;
		case "buscar":
			if(!p){
				args["nom"] = $("#buscarNombre").val();
				args["dni"] = $("#buscarDni").val();
			}
			else{
				args["dni"] = p;
			}
			
			if(!args["nom"] && !args["dni"]){
				alert("Ingrese nombre y/o documento para buscar.");
				return;
			}
			JSON.stringify(args);
			
			$.ajax ({
				url: "modulos/clientes/opcionesDeCliente.php",
				type: "POST",
				data: { 'accion': a, 'args': args },
				success: 	function(request, settings)
				{
				  $('#encontrado').html(request);
				},
				error: 	function(request, settings)
				{
				  $('#encontrado').html('Error: ' + request.responseText);
				}
			});
			return;
			break;
		default:
			alert("Accion invalida.");
			return false;
	}
	
	$.ajax({
		url: "modulos/clientes/opcionesDeCliente.php",
		type: "POST",
		data: { 'accion': a, 'args': args },
		success: function(request)
		{
			if(request == "OK"){
				alert("DATOS CARGADOS CORRECTAMENTE");
				window.location.replace("clientes.php");
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
		url: 'modulos/clientes/buscarCliente.php',
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

function check(datos){ 
	if(datos.nombre.value == "" ||
		datos.desc.value == ""){
		alert('NO DEJAR CAMPOS VACIOS.');
		return false;
	}
}

function del(id) {
	if (confirm('Borrar este elemento?')) {
		window.location = "modulos/clientes/cambiarCliente.php?id="+id
	}
}

function cargarCliente(){
	

	if(!zona){
		zona = document.getElementById('textZona').value;
	}
	else{
		zona = zona.options[zona.selectedIndex].value;
	}

	if(!knownBy){
		knownBy = document.getElementById('textKnownBy').value;
	}
	else{
		knownBy = knownBy.options[knownBy.selectedIndex].value;
	}

	if(nombre == "" || apellido == "" || dni == "" || knownBy == ""){
		alert("Los siguientes campos son obligatorios:\n\nNOMBRE, APELLIDO, DNI, NOS CONOCIO POR");
		return false;
	}

	$.ajax({
		url: "modulos/clientes/agregarCliente.php",
		type: "POST",
		data: { 'id': id,
				'nombre': nombre,
				'apellido': apellido,
				'dni': dni,
				'email': email,
				'cel1': cel1,
				'cel2': cel2,
				'estado': estado,
				'zona': zona,
				'cuenta': cuenta,
				'knownBy': knownBy,
				'balance': balance,
				'opcion': opcion
			  },
		success: function(request)
					{
						alert(request);
						window.location = "clientes.php";
					}
	});
}

function cambiarKnownBy(valor){
	var text1 = "<input type='text' id='textKnownBy' size='28' maxLength='128' value=''>";
	if(valor == "otro"){
		$("#knownBy").html(text1);
	}				
}

function cambiarZona(valor){
	var text1 = "<input type='text' id='textZona' size='28' maxLength='128' value=''>";
	if(valor == "otro"){
		$("#zona").html(text1);
	}				
}

function enter(e){
	if(e.keyCode == 13){
		filtrar();
	}
}
