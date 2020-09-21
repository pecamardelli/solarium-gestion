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
		$query="SELECT idCliente AS idCli, COUNT(*) AS cant FROM turnos WHERE start >= $start AND end < $end AND estado='TOMADO' GROUP BY idCliente";
		$result2 = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
		
		#while($fila2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
		#	echo "$i - $fila2[idCli] : $fila2[cant]<br>";
		#}
		#echo "$i - " . mysqli_num_rows($result2) .  "<br />";
		array_push($cants, mysqli_num_rows($result2));
	}

	$promedio = round(array_sum($cants)/count($cants));

	/* Create and populate the pData object */ 
	$MyData = new pData();   
	$MyData->loadPalette($_SERVER['DOCUMENT_ROOT'] . "sistema/componentes/pChart2.1.4/palettes/light.color",TRUE);
	$MyData->addPoints($cants,"Clientes activos - Promedio $promedio");
	#$MyData->addPoints(array(140,0,340,300,320,300,200,100,50),"Mystix Sun"); 
	#$MyData->addPoints(array(140,0,340,300,320,300,200,100,50),"VitaSun"); 
	$MyData->setAxisName(0,"Cantidad"); 
	$MyData->addPoints($meses,"Meses"); 
	$MyData->setSerieDescription("Meses","Mes"); 
	$MyData->setAbscissa("Meses"); 

	/* Create the pChart object */ 
	$myPicture = new pImage(800,270,$MyData); 
	$myPicture->drawGradientArea(0,0,800,270,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100)); 
	$myPicture->drawGradientArea(0,0,800,270,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20)); 
	$myPicture->setFontProperties(array("FontName"=>FONT_PATH."/pf_arma_five.ttf","FontSize"=>10)); 

	/* Draw the scale  */ 
	$myPicture->setGraphArea(80,50,750,230); 
	$myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10)); 

	/* Turn on shadow computing */  
	$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 

	/* Draw the chart */ 
	$settings = array("Gradient"=>TRUE,"GradientMode"=>GRADIENT_EFFECT_CAN,"DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"DisplayR"=>255,"DisplayG"=>255,"DisplayB"=>255,"DisplayShadow"=>TRUE,"Surrounding"=>10);
	$myPicture->drawBarChart($settings); 

	/* Add a border to the picture */ 
	$myPicture->drawRectangle(0,0,799,269,array("R"=>0,"G"=>0,"B"=>0)); 

	/* Write the chart legend */ 
	$myPicture->drawLegend(500,22,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 

	$myPicture->setFontProperties(array("FontName"=>FONT_PATH."/Forgotte.ttf","FontSize"=>14)); 
	$myPicture->drawText(360,34,"Clientes activos mensuales en " . $hoy['year'],array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMRIGHT)); 

	/* Render the picture (choose the best way) */ 
	$myPicture->autoOutput("example.drawBarChart.can.png"); 
?>
