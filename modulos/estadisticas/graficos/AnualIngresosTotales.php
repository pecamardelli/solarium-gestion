<?php    
	/* CAT:Bar Chart */ 

	/* pChart library inclusions */ 
	define("CLASS_PATH", $_SERVER['DOCUMENT_ROOT'] . "sistema/componentes/pChart2.1.4/class");
	define("FONT_PATH", $_SERVER['DOCUMENT_ROOT'] . "sistema/componentes/pChart2.1.4/fonts");

	include(CLASS_PATH."/pData.class.php"); 
	include(CLASS_PATH."/pDraw.class.php"); 
	include(CLASS_PATH."/pImage.class.php");

	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";

	$anio = $_REQUEST['anio'];
	$meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");

	$cants = array();
	$total_gral = 0;
	$Q = 0;
	$hoy = getdate();

	for($i=1;$i<=12;$i++){
		
		if($i <= 9){
			$mes = "0$i";
		}
		else{
			$mes = $i;
		}
		
		$total_dias = cal_days_in_month(CAL_GREGORIAN, $i, $anio);
		
		$query="SELECT SUM(montoTotal) AS monto FROM ventas WHERE fechaVenta >= '$anio-$mes-01 00:00:00' AND fechaVenta <= '$anio-$mes-$total_dias 23:59:59'";
		$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
		$fila = mysqli_fetch_array($result, MYSQLI_ASSOC);

		if($fila['monto'] > 0 && $i <= $hoy['mon']){
			(($Q++));
		}
		
		$total_gral = (($total_gral + $fila['monto']));
		array_push($cants, $fila['monto']);
	}

	if($Q != 0){
		$promedio = round((($total_gral/$Q*100)))/100;
	}
	else{
		$promedio = 0;
	}

	/* Create and populate the pData object */ 
	$MyData = new pData();   
	$MyData->loadPalette($_SERVER['DOCUMENT_ROOT'] . "sistema/componentes/pChart2.1.4/palettes/light.color",TRUE); 
	$MyData->addPoints($cants,"Total: $" . $total_gral . " - Promedio: $" . $promedio);
	$MyData->setAxisName(0,"Ingresos"); 
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
	$myPicture->drawText(180,34,"Ingresos en " . $anio,array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMRIGHT)); 

	/* Render the picture (choose the best way) */ 
	$myPicture->autoOutput("example.drawBarChart.can.png"); 
?>