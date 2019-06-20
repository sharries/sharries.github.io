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
if(isset($query['player'])){
	$user = $query['player'];
}else{
	$user = "";
}
if(isset($query['players'])){
	$players = $query['players'];
}else{
	$players = "";
}

$json = file_get_contents("../../../json/games/".$file.".json");
$json = json_decode($json, true);
$json['word'] = $word;
$json['number'] = $players;
$json['letter'] = substr($word, -1);
array_push($json['players'], array('name'=>"$user",'points'=>"0"));
array_push($json['played'], array($word));

$jsonE=json_encode($json);
$fp = fopen("../../../json/games/".$file.".json" , "w");
fputs($fp , "$jsonE");
fclose($fp);
?>