<?php
	function getNumberOfDays($anio, $mes, $day){
		if($mes == 12){
			$anio++;
			$next = 1;
		}
		else{
			$next = $mes + 1;
		}
		
		$no = 0;
		$start = new DateTime($anio . '-' . $mes . '-01');
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
?>