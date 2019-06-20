<?php
include_once('harvest.php');
if(isset($query['file'])){
	$file = $query['file'];
}else{
	$file = "";
}
if(isset($query['status'])){
	$status = $query['status'];
}else{
	$status = "";
}


$json = file_get_contents("../../../json/games/".$file.".json");
$json = json_decode($json, true);
$json['status'] = $status;

$jsonE=json_encode($json);
$fp = fopen("../../../json/games/".$file.".json" , "w");
fputs($fp , "$jsonE");
fclose($fp);
?>