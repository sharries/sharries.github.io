<?php
include_once('harvest.php');
if(isset($query['file'])){
	$file = $query['file'];
}else{
	$file = "";
}
if(isset($query['mode'])){
	$mode = $query['mode'];
}else{
	$mode = "";
}


$json = file_get_contents("../../../json/games/".$file.".json");
$json = json_decode($json, true);
if($mode == "Story Telling"){
	$json["word"] = "Once upon a time";
}
$json['mode'] = $mode;

$jsonE=json_encode($json);
$fp = fopen("../../../json/games/".$file.".json" , "w");
fputs($fp , "$jsonE");
fclose($fp);
?>