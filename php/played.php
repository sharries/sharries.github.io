<?php
include_once('harvest.php');
if(isset($query['file'])){
	$file = $query['file'];
}else{
	$file = "";
}
if(isset($query['word'])){
	$word = $query['word'];
}else{
	$word = "";
}
if(isset($query['timer'])){
	$timer = $query['timer'];
}else{
	$timer = "";
}

$json = file_get_contents("../../../json/games/".$file.".json");
$json = json_decode($json, true);
/* CHECK IF VALID? */
$json["word"] = $word;
$json['letter'] = substr($word, -1);
array_push($json['played'], array($word));
$i = $json['player'];
$json["players"][$i]["points"] = round(( 50/(10 - $timer))+ (sizeof($json['played']) * 10),2);
if($i != sizeof($json["players"])-1){
	$json['player'] += 1;
}else{
	$json['player'] = 0;	
}
$str="";
for ($x = 0; $x <= sizeof($json["players"])-1; $x++) {
	$pattern="..................";
	$l = strlen($json["players"][$x]["name"]);
	$n = strlen((string)$json["players"][$x]["points"]);
	$insert = substr($pattern,0,20 - ($n+$l));
	$str = $str.$json["players"][$x]["name"]." ".$insert." ".$json["players"][$x]["points"]."<br>";
}

echo $word."*".$str;
$jsonE=json_encode($json);
$fp = fopen("../../../json/games/".$file.".json" , "w");
fputs($fp , "$jsonE");
fclose($fp);
?>