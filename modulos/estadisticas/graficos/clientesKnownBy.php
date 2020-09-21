<?php    
	/* CAT:Bar Chart */ 

	/* pChart library inclusions */ 
	define("CLASS_PATH", $_SERVER['DOCUMENT_ROOT'] . "sistema/componentes/pChart2.1.4/class");
	define("FONT_PATH", $_SERVER['DOCUMENT_ROOT'] . "sistema/componentes/pChart2.1.4/fonts");

	include(CLASS_PATH."/pData.class.php"); 
	include(CLASS_PATH."/pDraw.class.php"); 
	include(CLASS_PATH."/pImage.class.php");

	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	
	$query="SELECT charValue FROM config WHERE descConfig = 'nos_conocio_por' AND charValue != 'Pruebas'";
	$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
	$known_by = array();

	while($fila = mysqli_fetch_array($result, MYSQLI_NUM)){
		array_push($known_by, $fila[0]);
	}

	$query="SELECT  clientes.idKnownBy AS idk,
					COUNT(clientes.idCliente) AS cant,
					config.charValue AS known					
					FROM clientes
					INNER JOIN config ON clientes.idKnownBy = config.idConf
					GROUP BY idk";
	$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
	
	$cants = array();
	$zonas = array();
	$total_gral = 0;

	while($fila = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		if(array_search($fila['known'], $known_by) >= 0){
			array_push($cants, $fila['cant']);
			array_push($zonas, $fila['known']);
			$total_gral = (($total_gral + $fila['cant']));
		}
	}

	array_multisort($cants, SORT_DESC, $zonas);
	
	/* Create and populate the pData object */ 
	$MyData = new pData();   
	$MyData->addPoints($cants,"Total " . $total_gral);
	$MyData->setAxisName(0,""); 
	$MyData->addPoints($zonas,"Options"); 
	$MyData->setAbscissa("Options"); 
	
	/* Create the pChart object */ 
	$myPicture = new pImage(800,320,$MyData);
	
	/* Draw the background */ 
	$Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107); 
	$myPicture->drawFilledRectangle(0,0,800,320,$Settings); 

	/* Overlay with a gradient */ 
	$Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50); 
	$myPicture->drawGradientArea(0,0,800,320,DIRECTION_VERTICAL,$Settings); 

	/* Add a border to the picture */ 
	$myPicture->drawRectangle(0,0,799,319,array("R"=>0,"G"=>0,"B"=>0)); 
	
	/* Write the chart title */  
	$myPicture->setFontProperties(array("FontName"=>FONT_PATH."/Forgotte.ttf","FontSize"=>15)); 
	$myPicture->drawText(200,37,"Nos conocieron por",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMRIGHT)); 

	/* Define the default font */  
	$myPicture->setFontProperties(array("FontName"=>FONT_PATH."/pf_arma_five.ttf","FontSize"=>10)); 

	/* Set the graph area */  
	$myPicture->setGraphArea(160,60,730,300); 
	$myPicture->drawGradientArea(160,60,730,300,DIRECTION_HORIZONTAL,array("StartR"=>200,"StartG"=>200,"StartB"=>200,"EndR"=>255,"EndG"=>255,"EndB"=>255,"Alpha"=>30)); 

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
