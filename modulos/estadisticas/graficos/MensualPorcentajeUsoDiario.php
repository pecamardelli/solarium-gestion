<?php    
	/* CAT:Bar Chart */ 

	/* pChart library inclusions */ 
	define("CLASS_PATH", $_SERVER['DOCUMENT_ROOT'] . "sistema/componentes/pChart2.1.4/class");
	define("FONT_PATH", $_SERVER['DOCUMENT_ROOT'] . "sistema/componentes/pChart2.1.4/fonts");

	include(CLASS_PATH."/pData.class.php"); 
	include(CLASS_PATH."/pDraw.class.php"); 
	include(CLASS_PATH."/pImage.class.php");

	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";

	$mes = $_REQUEST['mes'];
	$anio = $_REQUEST['anio'];	
	$cants = array();
	$dias = array();
	$numero = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
	$promedio = 0;
	$Q = 0;
	$hoy = getdate();

	for($i=1;$i<=$numero;$i++){
		
		if($i < 10){
			$dia = "0$i";
		}
		else{
			$dia = $i;
		}
		
		$date = new DateTime($anio . '-' . $mes . '-' . $dia . 'T00:00:00'); // For today/now, don't pass an arg.
		$start = (($date->format('U') * 1000));
		$date->modify("+1 day");
		$end = (($date->format('U') * 1000));
		$query="SELECT COUNT(*) AS cant FROM turnos WHERE start >= $start AND start < $end AND estado='TOMADO'";
		$result2 = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
		$fila2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
		$percent = round((($fila2['cant']*100/72))*100)/100;
		array_push($cants, $percent);
		array_push($dias, $i);
		$promedio = (($promedio + $percent));
		
		if($i <= $hoy['mday']){
			(($Q++));
		}
	}

	if($Q != 0){
		$promedio = round((($promedio / $Q))*100)/100;
	}
	else{
		$promedio = 0;
	}

	/* Create and populate the pData object */ 
	$MyData = new pData();   
	$MyData->loadPalette($_SERVER['DOCUMENT_ROOT'] . "sistema/componentes/pChart2.1.4/palettes/light.color",TRUE);
	$MyData->addPoints($cants,"Promedio del mes: " . $promedio . "%");
	$MyData->setAxisName(0,"Porcentaje"); 
	$MyData->addPoints($dias,"Dias"); 
	$MyData->setSerieDescription("Dias","Dia"); 
	$MyData->setAbscissa("Dias"); 

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
	$myPicture->drawLegend(540,22,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 

	$myPicture->setFontProperties(array("FontName"=>FONT_PATH."/Forgotte.ttf","FontSize"=>14)); 
	$myPicture->drawText(240,34,"Porcentaje de uso diario",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMRIGHT));

/* Draw static thresholds */  
	$myPicture->setFontProperties(array("FontName"=>FONT_PATH."/pf_arma_five.ttf","FontSize"=>8)); 
	$myPicture->drawThreshold(25,array("WriteCaption"=>TRUE,"Caption"=>"Objetivo","BoxAlpha"=>100,"BoxR"=>255,"BoxG"=>40,"BoxB"=>70,"Alpha"=>70,"Ticks"=>1,"R"=>255,"G"=>40,"B"=>70)); 

	/* Render the picture (choose the best way) */ 
	$myPicture->autoOutput("example.drawBarChart.can.png"); 
?>
