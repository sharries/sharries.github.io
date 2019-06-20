<?php
include_once('../php/harvest.php');
if(isset($query['key'])){
	$key = $query['key'];
}else{
	$key = "";
}

date_default_timezone_set("Europe/London");
header("Content-Type: text/event-stream\n\n");

   echo "event: ping\n";
   //$curDate = date(DATE_ISO8601);
   // 'data: {"time": "' . $curDate . '"}';
   //echo "\n\n";

$json = file_get_contents("../../../json/games/".$key.".json");
$json = json_decode($json, true);
global $number,$joined;
$number = $json['number'];
$joined = sizeof($json['players']);
//echo "data: Number".$number." Joined".$joined."\n\n";
$session = filemtime("../../../json/games/".$key.".json");
$time = time();
clearstatcache();
while (1) {
	$lastTime = time();
	$last = filemtime("../../../json/games/".$key.".json");
	clearstatcache();

$json = file_get_contents("../../../json/games/".$key.".json");
$json = json_decode($json, true);
$number = $json['number'];
$joined = sizeof($json['players']);

	// echo "data: Session ".$session." Last ".$last."\n\n";
	if(($session != $last) && $lastTime - $time > 1 && $number == $joined){
		// CHANGE
		$session = $last;
		$time = $lastTime;
		echo "data: FILE\n\n";
		$json = file_get_contents("../../../json/games/".$key.".json");
		$json = json_decode($json, true);
		$number = $json['number'];
		$joined = sizeof($json['players']);		
		//echo "data: Number".$number." Joined".$joined."\n\n";
	}else if(($session != $last) && $lastTime - $time > 1){
		$session = $last;
		$time = $lastTime;
		$json = file_get_contents("../../../json/games/".$key.".json");
		$json = json_decode($json, true);
		$number = $json['number'];
		$joined = sizeof($json['players']);	
		$waiting = $number - $joined;
		echo "data: ".$waiting."JOIN\n\n";		
	}	
	if($number == $joined){
		if($session != $last){
			// CHANGE
			$session = $last;
			echo "data: CHANGED\n\n";
		}else{
			// NO CHANGED
			echo "data: NOCHANGE\n\n";
		}
	}else{
			echo "data: ".($number - $joined)."NOGAME\n\n";	
	}
	//echo "data: ".$json["player"]."TURN\n\n";
  while (ob_get_level() > 0) {
    ob_end_flush();
  }
  flush();
  sleep(1);
}
?>