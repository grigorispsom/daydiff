<?php

function getWorkdays($date1, $date2) {
  if (!defined('SATURDAY')) define('SATURDAY', 6);
  if (!defined('SUNDAY')) define('SUNDAY', 0);

		// Array of all public festivities 
  $publicHolidays = array('01-01','06-01','25-04','01-05','15-08','28-10','25-12','26-12');
		// Array of all orthodox easter dates until 2031
  $easters = array('2-05-2021', '24-4-2022', '16-4-2022', '5-5-2024', '20-4-2025', '12-4-2026', '2-5-2027', '16-4-2028', '8-4-2029', '28-4-2030', '13-4-2031'); 
		// Get all easter relatide holidays	
	foreach ($easters as $easter_day) {
		$year_est = explode("-", $easter_day);
		if ($year_est[2] == date("Y")){
				$easter = strtotime($easter_day);
				$deyterpasxa = strtotime("+1 day", $easter) ;    
				$megparaskeyi = strtotime("-2 day", $easter) ;    
				$kathdeytera = strtotime("-48 day", $easter) ; 
				$agioupneymatos = strtotime("+50 day", $easter) ; 
				$easter_holidays[] = date('d-m',$deyterpasxa);		
				$easter_holidays[] =  date('d-m',$megparaskeyi);		
				$easter_holidays[] =  date('d-m',$kathdeytera);		
				$easter_holidays[] =  date('d-m',$agioupneymatos);		
		}
	}
		// Run through date range and exclude Saturday,Sunday,Holidays,Easter etc 
  $start = strtotime($date1);
  $end   = strtotime($date2);
  $workdays = 0;
  
	for ($i = $start; $i < $end; $i = strtotime("+1 day", $i)) {
		$day = date("w", $i);  // 0=sun, 1=mon, ..., 6=sat
		$mmgg = date('d-m', $i);
			if (($day != SUNDAY && $day != SATURDAY) && !in_array($mmgg, $publicHolidays) && !in_array($mmgg, $easter_holidays)) {
				$workdays++;
			}
	}

  return intval($workdays);
}


if (isset($_POST['startdate'])&& isset($_POST['enddate'])){
	$workdays = getWorkdays($_POST['startdate'],$_POST['enddate']);
	echo json_encode($workdays);
}

?>