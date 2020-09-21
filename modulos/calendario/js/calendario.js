var days = ["DOMINGO","LUNES","MARTES","MIERCOLES","JUEVES","VIERNES","SABADO"];

/////////////////////////////////////////////////
// Carga de las configuraciones del calendario //
/////////////////////////////////////////////////

var configs = $.ajax({
		type: "POST",
		url: "modulos/calendario/calendarConfig.php",
		data: "request_type=generator",
		async: false
	}).responseText;

configs = JSON.parse(configs);

var agStart = configs.inicio + ':00:00';
var agEnd = configs.fin + ':00:00';
var agHeight = 120 + ((configs.fin - configs.inicio) * 85);
var agView = configs.vista;

///////////////////////////////////////////////////

$(document).ready(function() {
	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		viewRender: function(view, element){
			var currentdate = new Date(view.intervalStart);
		},
		defaultView: agView,
		selectable: true,
		selectHelper: true,
		slotEventOverlap: false,
		height: agHeight,
		minTime: agStart,
		maxTime: agEnd,
		axisFormat: 'HH:mm',
		select: function(start, end) {
			var hora = new Date();
			var estart = new Date(start + 10800000);	// Se le suman las 3 horas de la zona horaria (GMT -3) en milisegundos
			var s = new Date(start + 12000000);
			var title = confirm('¿AGREGAR TURNO PARA EL ' + days[estart.getDay()] + ' ' + estart.getDate() + ' A LAS ' + estart.getHours() + ':' + estart.getMinutes() + '?');
			var eventData;
			if (title) {
				eventData = {
					title: title,
					start: start,
					end: end
				};
				$('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
				window.location = 'turnos.php?start=' + start + '&end=' + end;	
			}
			$('#calendar').fullCalendar('unselect');
		},
		eventLimit: true, // allow "more" link when too many events
		eventSources: ['modulos/calendario/cargarAgenda.php'],		//	Este .php trae los turnos de 30 días para atrás cargados en la base de datos		
		eventClick:  function(event, jsEvent, view) {
			//alert(event.balance);return;
			var eventHtml = 'SERVICIO:<br>' + event.desc + ' ' + event.mins + ' minutos.';
			if(event.maqMar != "" && event.maqMod != ""){
				eventHtml += '<br><br>MAQUINA:<br>' + event.maqMar + ' ' + event.maqMod;
			}
			if(event.balance < 0){
				alert("El cliente tiene una deuda de: " + event.balance);
				eventHtml += '<br><br>##############################'
				eventHtml += '<br>CLIENTE CON DEUDA: ' + event.balance;
				eventHtml += '<br>##############################'
			}
			eventHtml += '<br><br>CLIENTE:<br>' + event.cliente + '<br><br>ESTADO DEL TURNO: ' + event.estado;
			var sel;

			//$('body').css('overflow','hidden');
			
			var estart = new Date(event.start + 10800000);
			var dialogButtons = {};
			
			if(event.estado == 'AGENDADO'){
				//$("#eventInfo").html($("#eventInfo").html() + "<br><br><input type='checkbox' id='musica' checked> Activar musica");
				str = event.cliente.substring(0, 8);
					$.ajax ({
					url: 'modulos/calendario/traerMaquinas.php',
					type:  'post',
					data: 	{ 'idServ': event.idServ },
					success: 	function(request)
					{
						sel = request;
					},
					async: false
				});
				eventHtml += sel;
				if(str != "SIN PAGO"){
					dialogButtons['Tomar Turno'] = function() {
						var maqId = $("#modalMaqList option:selected").val();
						var hora = new Date();
						if((estart + 1200000) < hora){
							alert("NO SE PUEDE TOMAR UN TURNO PASADO.\n\nSolo puede hacerse hasta 2 horas pasadas desde el inicio.");
						}
						else{
							est = "TOMADO";
							var musica = $('#musica:checked').val();
							$.ajax ({
								url: 'modulos/turnos/cambiarTurno.php',	/* URL a invocar asíncronamente */
								type:  'post',											/* Método utilizado para el requerimiento */
								data: 	{ 'id': event.id, 'estado': est, 'iddet': event.iddetalle, 'musica': musica, 'maqId': maqId },		/* Información local a enviarse con el requerimiento */
								success: 	function(request)
								{
									if(request == "BUSSY"){
										alert("ERROR: LA MAQUINA ESTA EN USO.\n\n###################\n# TURNO NO TOMADO #\n###################");
									}
									else{
										alert(request);
										window.location = "index.php";
									}
								}
							});
						}
					};
				}
				dialogButtons['Cancelar Turno'] = function(){
					var hora = new Date();
					/*if(event.start < hora){
						alert("NO SE PUEDE CANCELAR UN TURNO PASADO.\n\nSolo puede hacerse si el cliente avisó con una hora de anticipación.");
					}
					else{*/
						if(confirm("ATENCIÓN! Cancelar el turno de " + event.cliente + "?")){
							est = "CANCELADO";
							$.ajax ({
								url: 'modulos/turnos/cambiarTurno.php',	/* URL a invocar asíncronamente */
								type:  'post',											/* Método utilizado para el requerimiento */
								data: 	{ 'id': event.id, 'estado': est, 'iddet': event.iddetalle },		/* Información local a enviarse con el requerimiento */

								success: 	function(request)
								{
									alert("TURNO CANCELADO!");
									window.location = "index.php";
								}			
							});
						}
					//}
				};
			}
			else{
				dialogButtons['Marcar como Agendado'] = function(){
					// Habilitar esto cuando el sistema sea utilizado por terceros
					/*var hora = new Date();
					if(event.start < (hora - 42300000)){
						alert("NO SE PUEDE RE-AGENDAR UN TURNO PASADO.\n\nSolo puede hacerse con los turnos de 12 horas para atrás.");
					}
					else{*/
						est = "CAMBIO-AGENDADO";
						$.ajax ({
							url: 'modulos/turnos/cambiarTurno.php',	
							type:  'post',											
							data: 	{ 'id': event.id, 'estado': est, 'iddet': event.iddetalle },

							success: 	function(request)
							{
								alert("TURNO AGENDADO!");
								window.location = "index.php";
							}			
						});
					//}
				};
			}
			dialogButtons['Cerrar'] = function(){
				$(this).dialog('close');
			}
			
			var titulo = 'Turno del ' + days[estart.getDay()] + ' ' + estart.getDate() + ' a las ' + estart.getHours() + ':';
			
			if(estart.getMinutes() < 10){
				titulo = titulo + '0' + estart.getMinutes();
			}
			else{
				titulo = titulo + estart.getMinutes();
			}
			$("#eventInfo").html(eventHtml);
			$("#eventContent").dialog({ 
				modal: true,
				title: titulo,
				width:430,
				height:350,
				draggable: false,
				position: {
					my: "center",
					at: "top"
				},
				buttons: dialogButtons
			});
		}
	});
});
