<?php    
	/* CAT:Bar Chart */ 

	/* pChart library inclusions */ 
	define("CLASS_PATH", $_SERVER['DOCUMENT_ROOT'] . "sistema/componentes/pChart2.1.4/class");
	define("FONT_PATH", $_SERVER['DOCUMENT_ROOT'] . "sistema/componentes/pChart2.1.4/fonts");

	include(CLASS_PATH."/pData.class.php"); 
	include(CLASS_PATH."/pDraw.class.php"); 
	include(CLASS_PATH."/pImage.class.php");

	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	
	/* Obtener las ventas del mes */
	$mes = $_REQUEST['mes'];
	$anio = $_REQUEST['anio'];

	$query="SELECT idMaq AS id, marcaMaq AS marca FROM maquinas WHERE graficar='SI'";
	$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
	
	$cants = array();
	$marcas = array();
	$date = new DateTime($anio . '-' . $mes . '-01T00:00:00'); // For today/now, don't pass an arg.
	$start = (($date->format('U') * 1000));
	$date->modify("+1 month");
	$end = (($date->format('U') * 1000));
	$total_gral = 0;
	
	while($fila = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		$query="SELECT COUNT(*) AS cant FROM turnos WHERE idMaq='$fila[id]' AND start >= $start AND end < $end AND estado='TOMADO'";
		$result2 = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
		$fila2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
		
		array_push($cants, $fila2['cant']);
		array_push($marcas, $fila['marca']);
		$total_gral = (($total_gral + $fila2['cant']));
	}

	$hoy = getdate();
	$numero = cal_days_in_month(CAL_GREGORIAN, $mes, $anio); // 31

	if($hoy['mon'] < 10){
		$mes2 = "0$hoy[mon]";
	}
	else{
		$mes2 = $hoy['mon'];
	}

	if($mes != $mes2){
		$promedio = round((($total_gral/$numero*100)))/100;
	}
	else{
		$promedio = round((($total_gral/$hoy['mday']*100)))/100;
	}
	
	/* Create and populate the pData object */ 
	$MyData = new pData();   
	$MyData->addPoints($cants,"Total " . $total_gral . " - Promedio " . $promedio);
	$MyData->setAxisName(0,""); 
	$MyData->addPoints($marcas,"Options"); 
	$MyData->setAbscissa("Options"); 
	
	/* Create the pChart object */ 
	$myPicture = new pImage(800,270,$MyData);
	
	/* Draw the background */ 
	$Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107); 
	$myPicture->drawFilledRectangle(0,0,800,270,$Settings); 

	/* Overlay with a gradient */ 
	$Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50); 
	$myPicture->drawGradientArea(0,0,800,270,DIRECTION_VERTICAL,$Settings); 

	/* Add a border to the picture */ 
	$myPicture->drawRectangle(0,0,799,269,array("R"=>0,"G"=>0,"B"=>0)); 
	
	/* Write the chart title */  
	$myPicture->setFontProperties(array("FontName"=>FONT_PATH."/Forgotte.ttf","FontSize"=>15)); 
	$myPicture->drawText(185,37,"Turnos tomados",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMRIGHT)); 

	/* Define the default font */  
	$myPicture->setFontProperties(array("FontName"=>FONT_PATH."/pf_arma_five.ttf","FontSize"=>10)); 

	/* Set the graph area */  
	$myPicture->setGraphArea(100,60,730,250); 
	$myPicture->drawGradientArea(100,60,730,250,DIRECTION_HORIZONTAL,array("StartR"=>200,"StartG"=>200,"StartB"=>200,"EndR"=>255,"EndG"=>255,"EndB"=>255,"Alpha"=>30)); 

	/* Draw the chart scale */  
	$scaleSettings = array("AxisAlpha"=>10,"TickAlpha"=>10,"DrawXLines"=>FALSE,"Mode"=>SCALE_MODE_START0,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10,"Pos"=>SCALE_POS_TOPBOTTOM); 
	$myPicture->drawScale($scaleSettings);  

	/* Turn on shadow computing */  
	#$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 

	/* Draw the chart */  
	$myPicture->drawBarChart(array("DisplayValues"=>TRUE,"DisplayShadow"=>TRUE,"DisplayPos"=>LABEL_POS_INSIDE,"Rounded"=>TRUE,"Surrounding"=>30)); 
	/* Write the chart legend */ 
	$myPicture->drawLegend(540,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
	/* Render the picture (choose the best way) */ 
	$myPicture->autoOutput("example.drawBarChart.poll.png"); 
?>
