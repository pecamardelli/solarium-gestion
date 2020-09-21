<?php    
	/* pChart library inclusions */ 
	define("CLASS_PATH", $_SERVER['DOCUMENT_ROOT'] . "sistema/componentes/pChart2.1.4/class");
	define("FONT_PATH", $_SERVER['DOCUMENT_ROOT'] . "sistema/componentes/pChart2.1.4/fonts");

	include(CLASS_PATH."/pData.class.php"); 
	include(CLASS_PATH."/pDraw.class.php"); 
	include(CLASS_PATH."/pImage.class.php");

	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";

	/* Obtener las ventas del mes */	

	$date = new DateTime(); // For today/now, don't pass an arg.
	$date->modify("-30 day");
	$cants = array();
	$dias = array();
	
	$total_gral = 0;
	for($i=1;$i<=30;$i++){
		$date->modify("+1 day");
		$dia =  $date->format("Y-m-d");
		$query="SELECT numeroVenta AS nro FROM ventas WHERE fechaVenta >= '$dia 00:00:00' AND fechaVenta <= '$dia 23:59:59'";
		$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
		
		$cantidad = 0;
		while($fila = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$query="SELECT COUNT(*) AS cantidad FROM detalleVentas WHERE numeroVenta = '$fila[nro]'";
			$result2=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
			$row = mysqli_fetch_array($result2, MYSQLI_ASSOC);
			$cantidad = (($cantidad + $row['cantidad']));
		}
		$total_gral = (($total_gral + $cantidad));
		array_push($cants, $cantidad);
		array_push($dias, $date->format("d"));
	}

	$promedio = round((($total_gral/30*100)))/100;
	
	/* Create and populate the pData object */ 
	$MyData = new pData();   
	#$MyData->addPoints(array(-4,VOID,VOID,12,8,3),"Probe 1");
	$MyData->addPoints($cants,"Total " . $total_gral . " - Promedio " . $promedio);
	#$MyData->addPoints(array(2,7,5,18,19,22),"Probe 3"); 
	#$MyData->setSerieTicks("Probe 2",4); 
	#$MyData->setSerieWeight("Probe 3",2); 
	$MyData->setAxisName(0,"Cantidad"); 
	#$MyData->addPoints(array("Jan","Feb","Mar","Apr","May","Jun"),"Labels"); 
	$MyData->addPoints($dias,"Labels"); 
	$MyData->setSerieDescription("Labels","Dias"); 
	$MyData->setAbscissa("Labels"); 

	$imageWidth = 800;
	$imageHeight = 230;
	
	$graphAreaWidth = (($imageWidth - 30));
	$rectangleWidth = (($imageWidth - 1));
	
	/* Create the pChart object */ 
	$myPicture = new pImage($imageWidth,230,$MyData); 

	/* Retrieve the image map */ 
	if (isset($_GET["ImageMap"]) || isset($_POST["ImageMap"])) 
	$myPicture->dumpImageMap("ImageMapLineChart",IMAGE_MAP_STORAGE_FILE,"LineChart","../tmp"); 

	/* Set the image map name */ 
	$myPicture->initialiseImageMap("ImageMapLineChart",IMAGE_MAP_STORAGE_FILE,"LineChart","../tmp"); 

	/* Turn of Antialiasing */ 
	$myPicture->Antialias = FALSE; 

	/* Draw the background */ 
	$Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107); 
	$myPicture->drawFilledRectangle(0,0,$imageWidth,$imageHeight,$Settings); 

	/* Overlay with a gradient */ 
	$Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50); 
	$myPicture->drawGradientArea(0,0,$imageWidth,$imageHeight,DIRECTION_VERTICAL,$Settings); 

	/* Add a border to the picture */ 
	$myPicture->drawRectangle(0,0,$rectangleWidth,229,array("R"=>0,"G"=>0,"B"=>0)); 

	/* Write the chart title */  
	$myPicture->setFontProperties(array("FontName"=>FONT_PATH."/Forgotte.ttf","FontSize"=>14)); 
	$myPicture->drawText(280,35,"Cantidad de turnos vendidos",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMRIGHT)); 

	/* Set the default font */ 
	$myPicture->setFontProperties(array("FontName"=>FONT_PATH."/pf_arma_five.ttf","FontSize"=>10)); 

	/* Define the chart area */ 
	$myPicture->setGraphArea(60,40,$graphAreaWidth,200); 

	/* Draw the scale */ 
	$scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE); 
	$myPicture->drawScale($scaleSettings); 

	/* Turn on Antialiasing */ 
	$myPicture->Antialias = TRUE; 

	/* Draw the line chart */ 
	$Settings = array("RecordImageMap"=>TRUE); 
	$myPicture->drawLineChart($Settings); 
	$myPicture->drawPlotChart(array("PlotBorder"=>TRUE,"BorderSize"=>1,"Surrounding"=>-60,"BorderAlpha"=>80)); 

	/* Write the chart legend */ 
	$myPicture->drawLegend(540,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
	
	/* Draw static thresholds */  
	$myPicture->setFontProperties(array("FontName"=>FONT_PATH."/pf_arma_five.ttf","FontSize"=>8)); 
	$myPicture->drawThreshold($promedio,array("WriteCaption"=>TRUE,"Caption"=>"Promedio","BoxAlpha"=>100,"BoxR"=>255,"BoxG"=>40,"BoxB"=>70,"Alpha"=>70,"Ticks"=>1,"R"=>255,"G"=>40,"B"=>70)); 

	/* Render the picture (choose the best way) */ 
	$myPicture->autoOutput("LineChart.png"); 
?>