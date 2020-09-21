function buscar(dni){

	if(!dni){
		var nombre = $("#name").val();
		var doc = $("#dni").val();
	}
	else{
		var doc = dni;
	}

	if(!nombre && !doc){
		alert("Ingrese nombre y/o documento para buscar.");
		return;
	}

	var start = $('#start').val();


  $.ajax ({
	url: 'modulos/clientes/buscarCliente.php',
	type:  'post',
	data: 	{ 'nombre': nombre,
			  'doc': doc
			},
	success: 	function(request, settings)
	{
	  $('#encontrado').html(request);
			if(document.getElementsByClassName('clienteSeleccionado').length == 1){
				$('#comprasCliente').empty();
				idCli = $('.clienteSeleccionado').attr('id');
				$.ajax ({
					url: 'modulos/clientes/comprasCliente.php',
					type: 'post',
					data: { 'idCliente': idCli, 'start': start },
					success: 	function(req)
				{
						$('#comprasCliente').html(req);
					},
					error: 	function(req)
				   {
					 $('#comprasCliente').html('Error: ' + req.responseText);
				   }
				});
			}
	},
	error: 	function(request, settings)
	{
	  $('#encontrado').html('Error: ' + request.responseText);
	}				
  });
}

function agendar(idDetalle){
	opcion = document.getElementById(idDetalle + '-opcion').innerHTML;
	servicio = document.getElementById(idDetalle + '-servicio').innerHTML;
	cliente = document.getElementsByClassName('clienteSeleccionado')[0].innerHTML;
	var maq = $("#" + idDetalle + "-maqList option:selected").attr('name');

	if(maq){
		if(confirm('SE AGENDARA:\n\n' + opcion + '  de  ' + servicio + '\n\nPARA:\n\n' + cliente)){
			start = $('#start').attr('value');
			end = $('#end').attr('value');
			idCli = $('.clienteSeleccionado').attr('id');
			$.ajax ({
				url: 'modulos/turnos/agendarTurno.php',
				type: 'post',
				data: { 'idCliente': idCli, 'idDetalle': idDetalle, 'start': start, 'end': end, 'maq': maq },
				success: 	function(req)
			{
					alert(req);
					window.location.replace("index.php");
				},
				error: 	function(req)
				{
				  alert(req);
				}
			});
		}
	}
	else
	{
		alert("NO HAY MAQUINAS DISPONIBLES PARA ESTE TURNO!");	
	}
}

function enter(e){
	if(e.keyCode == 13){
		buscar();
	}
}