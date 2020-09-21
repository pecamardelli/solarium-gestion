<?php    
	/* CAT:Bar Chart */

	include "funciones.php";

	/* pChart library inclusions */ 
	define("CLASS_PATH", $_SERVER['DOCUMENT_ROOT'] . "sistema/componentes/pChart2.1.4/class");
	define("FONT_PATH", $_SERVER['DOCUMENT_ROOT'] . "sistema/componentes/pChart2.1.4/fonts");

	/* pChart library inclusions */
	include(CLASS_PATH."/pData.class.php");
	include(CLASS_PATH."/pDraw.class.php");
	include(CLASS_PATH."/pImage.class.php");

	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";

	$anio = $_REQUEST['anio'];	
	$cants = array();
	$promedio = 0;
	$Q = 0;
	$meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
	
	for($i=1;$i<=12;$i++){
		
		if($i < 10){
			$mes = "0$i";
		}
		else{
			$mes = $i;
		}
		
		$date = new DateTime($anio . '-' . $mes . '-01T00:00:00'); // For today/now, don't pass an arg.
		$start = (($date->format('U') * 1000));
		$date->modify("+1 month");
		$end = (($date->format('U') * 1000));
		$query="SELECT COUNT(*) AS cant FROM turnos WHERE start >= $start AND start < $end AND estado='TOMADO'";
		$result2 = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
		$fila2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
		$numero = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
		$sundays = getNumberOfDays($anio, $mes, 7);
		$numero = $numero - $sundays;
		$numero = (($numero * 72));
		$mondays = getNumberOfDays($anio, $mes, 1);
		$numero = $numero - ($mondays * 36);
		$percent = round((($fila2['cant']*100/$numero))*100)/100;
		
		if($percent > 0){
			(($Q++));
		}
		
		array_push($cants, $percent);
		$promedio = (($promedio + $percent));
	}

	$promedio = round((($promedio / $Q))*100)/100;
	/* Create and populate the pData object */ 
	$MyData = new pData();   
	$MyData->loadPalette($_SERVER['DOCUMENT_ROOT'] . "sistema/componentes/pChart2.1.4/palettes/light.color",TRUE);
	$MyData->addPoints($cants,"Promedio del año: " . $promedio . "%");
	$MyData->setAxisName(0,"Porcentaje"); 
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
	$myPicture->drawLegend(530,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 

	$myPicture->setFontProperties(array("FontName"=>FONT_PATH."/Forgotte.ttf","FontSize"=>14)); 
	$myPicture->drawText(270,36,"Porcentaje de uso mensual",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMRIGHT));

/* Draw static thresholds */  
	$myPicture->setFontProperties(array("FontName"=>FONT_PATH."/pf_arma_five.ttf","FontSize"=>8)); 
	$myPicture->drawThreshold(25,array("WriteCaption"=>TRUE,"Caption"=>"Objetivo","BoxAlpha"=>100,"BoxR"=>255,"BoxG"=>40,"BoxB"=>70,"Alpha"=>70,"Ticks"=>1,"R"=>255,"G"=>40,"B"=>70)); 

	/* Render the picture (choose the best way) */ 
	$myPicture->autoOutput("example.drawBarChart.can.png"); 
?>
