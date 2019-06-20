<?php
session_start();



include_once('../php/harvest.php');
if(isset($query['key'])){
	$key = $query['key'];
}else{
	$key = "";
}
/* 
Connect to DB - READ table and store in SESSION count

*/
date_default_timezone_set("Europe/London");
header("Content-Type: text/event-stream\n\n");
$json = file_get_contents("../data/games/".$key.".json");
$json = json_decode($json, true);

echo "data: JSON".$json."\n\n";
echo "data: KEY".$key."\n\n";
global $number,$joined;
$number = $json['number'];
$joined = sizeof($json['players']);
echo "data: Number".$number." Joined".$joined."\n\n";
echo "data: $key was last modified: " . date ("F d Y H:i:s.", filemtime("../data/games/".$key.".json"));
$counter = rand(1, 10);
while (1) {
  // Every second, sent a "ping" event.

  /* Check count against Session and if changed Send Message*/
  
  echo "event: ping\n";
  $curDate = date(DATE_ISO8601);
  echo 'data: {"time": "' . $curDate . '"}';
  echo "\n\n";
if($number == $joined){
  // Send List online

  $counter--;

  if (!$counter) {
    echo 'data: This is a message at time ' . $curDate . "\n\n";
    $counter = rand(1, 10);
  }

}else{
	
}
  while (ob_get_level() > 0) {
    ob_end_flush();
  }
  flush();
  sleep(1);
}
?>