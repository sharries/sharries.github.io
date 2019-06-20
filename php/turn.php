<?php
include_once('harvest.php');
if(isset($query['file'])){
	$file = $query['file'];
}else{
	$file = "";
}

$json = file_get_contents("../../../json/games/".$file.".json");
$json = json_decode($json, true);
$str="";
for ($x = 0; $x <= sizeof($json["players"])-1; $x++) {
	$pattern="..................";
	$l = strlen($json["players"][$x]["name"]);
	$n = strlen((string)$json["players"][$x]["points"]);
	$insert = substr($pattern,0,20 - ($n+$l));
	$str = $str.$json["players"][$x]["name"]." ".$insert." ".$json["players"][$x]["points"]."<br>";}
echo $json["player"]."*".$json["word"]."*".$str;

$jsonE=json_encode($json);
$fp = fopen("../../../json/games/".$file.".json" , "w");
fputs($fp , "$jsonE");
fclose($fp);
?>