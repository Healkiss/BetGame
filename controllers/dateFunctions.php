<?php
	function getTimeStamp($date){
		return(mktime($date['hours'],$date['minutes'],$date['seconds'],$date['mon'],$date['mday'],$date['year']));
	}
	
	function getDateFormatee($date){
		return($date["mday"].".".$date["mon"].".".$date["year"]." ".$date["hours"].":".$date["minutes"]."-".$date["seconds"]);
	}
		
	function getDateFormateeFromTimeStamp($timeStamp){
		return date('d/m/Y H:i', $timeStamp);
	}
	
	function isAdult($time)
	{
		$then = $time;
		$min = strtotime('+18 years', $then);
		if(time() < $min) 
			return 0;
		return 1 ;
	}
?>