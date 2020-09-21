<?php    
	/* CAT:Bar Chart */ 

	/* pChart library inclusions */ 
	define("CLASS_PATH", $_SERVER['DOCUMENT_ROOT'] . "sistema/componentes/pChart2.1.4/class");
	define("FONT_PATH", $_SERVER['DOCUMENT_ROOT'] . "sistema/componentes/pChart2.1.4/fonts");

	include(CLASS_PATH."/pData.class.php"); 
	include(CLASS_PATH."/pDraw.class.php"); 
	include(CLASS_PATH."/pImage.class.php");

	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	
	$meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
	$cants = array();
	$hoy = getdate();
	
	for($i=1;$i<=12;$i++){
		if($i < 10){
			$mes = "0$i";
		}
		else{
			$mes = $i;
		}
		$date = new DateTime($hoy['year'] . '-' . $mes . '-01T00:00:00'); // For today/now, don't pass an arg.
		$start = (($date->format('U') * 1000));
		$date->modify("+1 month");
		$end = (($date->format('U') * 1000));
		$query="SELECT	turnos.idCliente AS idCli,
						clientes.nombreCliente AS nom,
						clientes.apellidoCliente AS ap,
						COUNT(*) AS cant
						FROM turnos
						INNER JOIN clientes ON clientes.idCliente = turnos.idCliente
						WHERE turnos.start >= $start AND turnos.end < $end AND turnos.estado='TOMADO' AND clientes.tipoCliente != 'PROPIETARIO'
						GROUP BY turnos.idCliente";
		$result2 = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
		
		while($fila2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
			$nom = "$fila2[nom] $fila2[ap]";
			$cants[$nom] = $cants[$nom] + $fila2['cant'];
		}
	}

	arsort($cants);
	$nombres = array();
	$cantidades = array();
	$i=1;

	foreach($cants as $n => $q){
		array_push($nombres, $n);
		array_push($cantidades, $q);
		$i++;
		if($i == 11){
			break;
		}
	}
	
	/* Create and populate the pData object */ 
	$MyData = new pData();   
	$MyData->addPoints($cantidades, "Cantidad");
	$MyData->setAxisName(0,""); 
	$MyData->addPoints($nombres,"Clientes"); 
	$MyData->setAbscissa("Clientes"); 
	
	/* Create the pChart object */ 
	$myPicture = new pImage(800,500,$MyData);
	
	/* Draw the background */ 
	$Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107); 
	$myPicture->drawFilledRectangle(0,0,800,500,$Settings); 

	/* Overlay with a gradient */ 
	$Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50); 
	$myPicture->drawGradientArea(0,0,800,500,DIRECTION_VERTICAL,$Settings); 

	/* Add a border to the picture */ 
	$myPicture->drawRectangle(0,0,799,499,array("R"=>0,"G"=>0,"B"=>0)); 
	
	/* Write the chart title */  
	$myPicture->setFontProperties(array("FontName"=>FONT_PATH."/Forgotte.ttf","FontSize"=>15)); 
	$myPicture->drawText(280,37,"Top Ten de clientes",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMRIGHT)); 

	/* Define the default font */  
	$myPicture->setFontProperties(array("FontName"=>FONT_PATH."/pf_arma_five.ttf","FontSize"=>10)); 

	/* Set the graph area */  
	$myPicture->setGraphArea(200,60,680,470); 
	$myPicture->drawGradientArea(200,60,680,470,DIRECTION_HORIZONTAL,array("StartR"=>200,"StartG"=>200,"StartB"=>200,"EndR"=>255,"EndG"=>255,"EndB"=>255,"Alpha"=>30)); 

	/* Draw the chart scale */  
	$scaleSettings = array("AxisAlpha"=>10,"TickAlpha"=>10,"DrawXLines"=>FALSE,"Mode"=>SCALE_MODE_START0,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10,"Pos"=>SCALE_POS_TOPBOTTOM); 
	$myPicture->drawScale($scaleSettings);  

	/* Turn on shadow computing */  
	#$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 

	/* Draw the chart */  
	$myPicture->drawBarChart(array("DisplayValues"=>TRUE,"DisplayShadow"=>TRUE,"DisplayPos"=>LABEL_POS_INSIDE,"Rounded"=>TRUE,"Surrounding"=>30)); 
	/* Write the chart legend */ 
	$myPicture->drawLegend(640,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
	/* Render the picture (choose the best way) */ 
	$myPicture->autoOutput("example.drawBarChart.poll.png"); 
?>
