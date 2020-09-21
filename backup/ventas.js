function acciones(a){	
	switch(a){
		case "cargar":
		if($('#encontrado').is(':empty')){
			alert("FALTA SELECCIONAR CLIENTE...");
			return false;
		}

		var radios = document.getElementsByClassName('formaPago');
		var ctaEnabled = document.getElementById('ctacte').value;
		var obs = $('#obs').val();

		for(i=0;i<radios.length;i++){
			if(radios[i].checked){
				if(radios[i].value == 'CTACTE'){
					if(ctaEnabled == 'NO HABILITADA' || ctaEnabled == 'SUSPENDIDA'){
						alert("ERROR!\n\nEL ESTADO DE LA CUENTA CORRIENTE DE ESTE CLIENTE ES:  " + ctaEnabled);
						return false;
					}
				}
				var pago = radios[i].value;
				break;
			}
		}
		var totalServ = parseInt(document.getElementById('total').innerHTML);
		var totalProd = parseInt(document.getElementById('totalProd').innerHTML);
		//alert(totalServ + " " + totalProd);
		//if ($('#total').is(':empty') && $('#totalProd').is(':empty')){

		//////////////////////////////////////////////////////////////////////////////////
		servicios = document.getElementsByClassName('servList');
		servsId = new Array(servicios.length);

		var hay_serv = 0;

		for(i=0;i<servicios.length;i++){
			servsId[i] = servicios[i].options[servicios[i].selectedIndex].value;
			if(servsId[i] != 'none'){
				hay_serv = 1;
			}
		}

		opciones = document.getElementsByClassName('opDef');
		opsId = new Array(opciones.length);

		for(i=0;i<opciones.length;i++){
			opsId[i] = opciones[i].options[opciones[i].selectedIndex].id;
		}

		//////////////////////////////////////////////////////////////////////////////////
		cantidades = document.getElementsByClassName('cant');
		cants = new Array(cantidades.length);       

		for(i=0;i<cantidades.length;i++){
			cants[i] = cantidades[i].value;
		}

		precios = document.getElementsByClassName('prec');
		precs = new Array(precios.length);

		for(i=0;i<precios.length;i++){
			precs[i] = parseInt(precios[i].innerHTML);
		}

		descuentos = document.getElementsByClassName('descnt');
		desc = new Array(descuentos.length);

		for(i=0;i<descuentos.length;i++){
			desc[i] = descuentos[i].value;
		}

		subtotales = document.getElementsByClassName('subtotal');
		subs = new Array(subtotales.length);

		for(i=0;i<subtotales.length;i++){
			subs[i] = subtotales[i].innerHTML;
		}

		//////////////////////////////////////////////////////////////////////////////////
		productos = document.getElementsByClassName('prodList');
		prodsId = new Array(productos.length);

		var hay_prod = 0;

		for(i=0;i<productos.length;i++){
			prodsId[i] = productos[i].options[productos[i].selectedIndex].value;
			if(prodsId[i] != 'none'){
				hay_prod = 1;
			}
		}


		if (servicios.length == 1 && productos.length == 1){
			if(productos[0].options[productos[0].selectedIndex].value == 'none' && servicios[0].options[servicios[0].selectedIndex].value == 'none'){
				alert("NO SE HAN AGREGADO SERVICIOS NI PRODUCTOS...");
				return false;	
			}
		}
		//alert(servicios.length + " " + productos.length);return false;
		//////////////////////////////////////////////////////////////////////////////////
		cantidadesProds = document.getElementsByClassName('cantProd');
		cantProds = new Array(cantidadesProds.length);       

		for(i=0;i<cantidadesProds.length;i++){
			cantProds[i] = cantidadesProds[i].value;
		}

		//////////////////////////////////////////////////////////////////////////////////
		preciosProd = document.getElementsByClassName('precioProd');
		precProds = new Array(preciosProd.length);

		for(i=0;i<preciosProd.length;i++){
			precProds[i] = parseInt(preciosProd[i].innerHTML);
		}

		//////////////////////////////////////////////////////////////////////////////////
		stocksProd = document.getElementsByClassName('stockProd');
		stockProds = new Array(stocksProd.length);

		for(i=0;i<stocksProd.length;i++){
			stockProds[i] = parseInt(stocksProd[i].innerHTML);
		}

		//////////////////////////////////////////////////////////////////////////////////
		descuentosProd = document.getElementsByClassName('descntProd');
		descProds = new Array(descuentosProd.length);

		for(i=0;i<descuentosProd.length;i++){
			descProds[i] = descuentosProd[i].value;
		}

		//////////////////////////////////////////////////////////////////////////////////
		subtotalesProd = document.getElementsByClassName('subtotalProd');
		subProds = new Array(subtotalesProd.length);

		for(i=0;i<subtotalesProd.length;i++){
			subProds[i] = subtotalesProd[i].innerHTML;
		}

		//////////////////////////////////////////////////////////////////////////////////

		servsid = encodeURIComponent(JSON.stringify(servsId));
		JSON.stringify(opsId);
		JSON.stringify(cants);
		JSON.stringify(precs);
		JSON.stringify(desc);
		JSON.stringify(subs);

		JSON.stringify(prodsId);
		JSON.stringify(cantProds);
		JSON.stringify(precProds);
		JSON.stringify(stockProds);
		JSON.stringify(descProds);
		JSON.stringify(subProds);

		clientId = $('.clienteSeleccionado').attr('id');
		clientData = document.getElementsByClassName('clienteSeleccionado')[0].innerHTML;
		saleTotal = totalServ + totalProd;

		var bal = $('#balance').val();

		if(bal > 0){
			if(confirm("El cliente tiene a favor $" + bal + ". \n\nUsar en esta compra?")){
				var usar_bal = 1;
			}
			else{
				var usar_bal = 0;
			}

			if(bal > saleTotal){
				var nota = "\n\nNOTA: Se cubre esta venta con el saldo en cuenta del cliente.";
				saleTotal = 0;
			}
			else{
				var nota = "\n\nNOTA: Se le restó al total el saldo que el cliente tenía en la cuenta ($" + bal + ").";
				saleTotal = saleTotal - bal;
			}
		}

		if(confirm("CONFIRMAR VENTA?\n" +
			"\nCLIENTE: " + clientData +
			"\n\nPOR UN TOTAL DE $" + saleTotal + nota)){

			$.ajax({
				url: "modulos/ventas/opcionesDeVentas.php",
				type: "POST",
				data: { 'servsIds': servsId,
						'opsIds': opsId,
						'cantidades': cants,
						'precios': precs,
						'descuentos': desc,
						'subTotales': subs,
						'prodIds': prodsId,
						'cantsProd': cantProds,
						'preciosProd': precProds,
						'stocksProd': stockProds,
						'descsProd': descProds,
						'subsProd': subProds,
						'cliente': clientId,
						'totServ': totalServ,
						'totProd': totalProd,
						'formapago': pago,
						'hay_serv': hay_serv,
						'hay_prod': hay_prod,
						'usar_bal': usar_bal,
						'bal': bal,
						'obs': obs
						},
				success: function(request)
				{
					alert(request);
					window.location.replace("ventas.php");
				},
				error: 	function(request)
				{
					alert("ERROR: " + request.responseText);
				}
			});
		}
		break;
	}
}