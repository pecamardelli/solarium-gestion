function calcTotalProd(){
	var subs = document.getElementsByClassName('subtotalProd');
	var total = 0;
	
	for(i=0;i<subs.length;i++){
		sub = subs[i].innerHTML;
		total = total + Number(sub);
	}
	
	document.getElementById('totalProd').innerHTML = total;
	calcTotalGral();
}

function calcProd(caller){
	var ID = caller.id;
	ID = ID.substring(0,1);
	if(document.getElementById(ID + '-prodList').selectedIndex){
		var cant = parseInt(document.getElementById(ID + '-cantProd').value);
		var stock = parseInt(document.getElementById(ID + '-stockProd').getAttribute("name"));
		//alert("cant = " + cant + "	stock: " + stock + "	suma = " + (cant+stock));
		if(cant <= stock ){
			var precio = document.getElementById(ID + '-precioProd').innerHTML;
			document.getElementById(ID + '-stockProd').innerHTML = stock - cant;
			var descuento = document.getElementById(ID + '-descntProd').value;
			var sub = cant * precio;
			sub = sub - (sub * descuento / 100);
			document.getElementById(ID + '-subtotalProd').innerHTML = sub;
			document.getElementById(ID + '-stockProd').innerHTML = document.getElementById(ID + '-stockProd').getAttribute("name") - document.getElementById(ID + '-cantProd').value;
		}
		else{
			alert("LA CANTIDAD INGRESADA EXCEDE EL STOCK");
			document.getElementById(ID + '-cantProd').value = stock;
			document.getElementById(ID + '-stockProd').innerHTML = stock - cant;
		}
		//alert(document.getElementById(ID + '-stockProd').getAttribute("name"));
		calcTotalProd();
	}
}

function showProd(producto){
	idProd = producto.options[producto.selectedIndex].value;
	var ID = producto.id;
	ID = ID.substring(0,1);
	
	$.ajax ({
		url: 'modulos/ventas/prodData.php',	/* URL a invocar asíncronamente */
		type:  'post',											/* Método utilizado para el requerimiento */
		data: 	{ 'prodId': idProd },		/* Información local a enviarse con el requerimiento */

		success: 	function(request)
		{
			var data = $.parseJSON(request);
			$("#"+ID+"-precioProd").html(data[3]);
			$("#"+ID+"-stockProd").html(data[4]);
			$("#"+ID+"-stockProd").attr("name", data[4]);
			calcProd(producto);
		}			
	});
}

function addProdRow(){
	var rows = document.getElementsByClassName('filaProd');
	var ID = rows[rows.length - 1].id;
	ID = ID.substring(0,1);
	ID = Number(ID);
	var newId = ID+1;
	//alert(newId);
	var newRow = $("#table3").find("#"+ID+"-filaProd").clone();
	newRow.attr("id", newId+"-"+newRow.attr("class"));
	
	var child1 = newRow.find("#"+ID+"-prodList");
	child1.attr("id", newId+"-"+child1.attr("class"));
	
	var child2 = newRow.find("#"+ID+"-cantProd");
	child2.attr("id", newId+"-"+child2.attr("class"));
	//child2.attr("value", "1");
	child2.value = "1";
	
	var child3 = newRow.find("#"+ID+"-precioProd");
	child3.attr("id", newId+"-"+child3.attr("class"));
	child3.html("");
	
	var child4 = newRow.find("#"+ID+"-stockProd");
	child4.attr("id", newId+"-"+child4.attr("class"));
	child4.attr("name", "");
	child4.html("");
	
	var child5 = newRow.find("#"+ID+"-descntProd");
	child5.attr("id", newId+"-"+child5.attr("class"));
	//child5.attr("value", "0");
	child5.value = "1";
	
	var child6 = newRow.find("#"+ID+"-subtotalProd");
	child6.attr("id", newId+"-"+child6.attr("class"));
	child6.html("");
	
	var child7 = newRow.find("#"+ID+"-boton2Prod");
	child7.attr("id", newId+"-"+child7.attr("class"));
	
	$("#table3").append(newRow).end();
	
}

function deleteProdRow(caller){
	var ID = caller.id;
	ID = ID.substring(0,1);
	trId = ID + "-filaProd";
	
	if(document.getElementsByClassName('filaProd').length == 1){
		alert("ERROR! NO SE PUEDE ELIMINAR LA PRIMERA FILA.");
	}
	else
	{
		if(confirm('¿BORRAR ESTA FILA?')) {
			$('#'+trId).remove();
			calcTotalProd();
		}
	}
}