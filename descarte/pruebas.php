<?php
	function getNumberOfDays($anio, $mes, $day){
		$next = $mes + 1;
		$no = 0;
		$start = new DateTime($anio . '-' . $mes . '-01');
		#$end   = new DateTime($anio . '-' . $mes . '-' .$numero);
		$end   = new DateTime($anio . '-' . $next . '-01');
		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($start, $interval, $end);
		
		foreach ($period as $dt)
		{
			if ($dt->format('N') == $day)
			{
				$no++;
			}
		}
		
		return $no;
	}
$anio = 2017;
	for($i=1;$i<=12;$i++){
		
		if($i < 10){
			$mes = "0$i";
		}
		else{
			$mes = $i;
		}
		
		
		$sundays = getNumberOfDays($anio, $mes, 7);
		$mondays = getNumberOfDays($anio, $mes, 1);
		echo "MES $i: domingos: $sundays, lunes: $mondays<br>";
		
		
	}
?>
