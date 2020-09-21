function calcTotalServ(){
	var subs = document.getElementsByClassName('subtotal');
	var total = 0;
	
	for(i=0;i<subs.length;i++){
		sub = subs[i].innerHTML;
		total = total + Number(sub);
	}
	
	document.getElementById('total').innerHTML = total;
	calcTotalGral();
}

function calcServ(caller){
	var ID = caller.id;
	ID = ID.substring(0,1);
	var cant = document.getElementById(ID + '-cant').value;
	var precio = document.getElementById(ID + '-prec').innerHTML;
	var descuento = document.getElementById(ID + '-descnt').value;
	var sub = cant * precio;
	sub = sub - (sub * descuento / 100);
	document.getElementById(ID + '-subtotal').innerHTML = sub;
	
	calcTotalServ();
}

function setPrice(caller){
	var ID = caller.id;
	ID = ID.substring(0,1);
	
	var precio = $("#"+ID+"-opDef option:selected").attr("value");
	document.getElementById(ID + '-prec').innerHTML = precio;
	calcServ(caller);
}

function showOpts(servicio){
	idServ = servicio.options[servicio.selectedIndex].value;
	var ID = servicio.id;
	ID = ID.substring(0,1);
	
	var opSelect = document.getElementById(ID + '-opDef');
	
	while (opSelect.firstChild) {
		opSelect.removeChild(opSelect.firstChild);
	}
	
	$.ajax ({
		url: 'modulos/ventas/traerOpciones.php',	/* URL a invocar asíncronamente */
		type:  'post',											/* Método utilizado para el requerimiento */
		data: 	{ 'servId': idServ },		/* Información local a enviarse con el requerimiento */

		success: 	function(request)
		{
			$('#' + ID + '-opDef').append(request);
			var precio = $("#"+ID+"-opDef option").eq(0).val();
			//$("#"+ID+"-prec").attr("value", precio);
			$("#"+ID+"-prec").html(precio);
			calcServ(servicio);
		}			
	  });
}

function addRow(){
	var rows = document.getElementsByClassName('filaServ');
	var ID = rows[rows.length - 1].id;
	ID = ID.substring(0,1);
	ID = Number(ID);
	var newId = ID+1;
	
	var newRow = $("#table2").find("#"+ID+"-filaServ").clone();
	newRow.attr("id", newId+"-"+newRow.attr("class"));
	
	var child1 = newRow.find("#"+ID+"-servList");
	child1.attr("id", newId+"-"+child1.attr("class"));
	
	var child2 = newRow.find("#"+ID+"-opDef");
	child2.attr("id", newId+"-"+child2.attr("class"));
	child2.empty();
	child2.append("<option> - Elegir Opcion -</option>");
	
	var child3 = newRow.find("#"+ID+"-cant");
	child3.attr("id", newId+"-"+child3.attr("class"));
	child3.attr("value", 1);
	
	var child4 = newRow.find("#"+ID+"-prec");
	child4.attr("id", newId+"-"+child4.attr("class"));
	child4.attr("value", "");
	
	var child5 = newRow.find("#"+ID+"-descnt");
	child5.attr("id", newId+"-"+child5.attr("class"));
	child5.attr("value", 0);
	
	var child6 = newRow.find("#"+ID+"-subtotal");
	child6.attr("id", newId+"-"+child6.attr("class"));
	child6.html("");
	
	var child7 = newRow.find("#"+ID+"-boton2");
	child7.attr("id", newId+"-"+child7.attr("class"));
	
	$("#table2").append(newRow).end();
	
}

function deleteRow(caller){
	var ID = caller.id;
	ID = ID.substring(0,1);
	trId = ID + "-filaServ";
	
	if(document.getElementsByClassName('filaServ').length == 1){
		alert("ERROR! NO SE PUEDE ELIMINAR LA PRIMERA FILA.");
	}
	else
	{
		if(confirm('¿BORRAR ESTA FILA?')) {
			$('#'+trId).remove();
			calcTotalServ();
		}
	}
}
