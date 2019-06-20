<?php
$key="";
$keys=[];
$thePath = "../../../json/games/";
$files = null;
if(!is_array($files)){
	$files = scandir($thePath); // Create array of filenames
}else{
	$files = [];
}
function getNewKey($key, $files){
	$keys=explode(",","ask,band,bank,belt,bench,best,beast,blank,blast,blend,blink,boost,brand,brass,bring,brown,brush,bunk,bust,burnt,camp,clap,clear,clown,cost,cramp,crash,crept,cream,creep,crisp,crunch,crust,champ,champion,chest,children,chimp,chunk,daft,damp,dent,desktop,drank,drench,drift,drop,droop,fact,fast,felt,flag,flair,float,fond,fresh,frog,from,frost,frown,gift,glad,glass,glint,golf,grab,graft,gran,grant,grasp,grass,green,grip,groan,growl,grunt,gulp,gust,hand,help,helper,hunt,husk,jump,just,kept,lamp,land,last,lift,limp,link,lost,melt,melting,milk,nest,not,next,north,paint,plan,plum,plump,pond,printer,punch,roast,sandwich,scoop,scrap,scrunch,sink,sixth,skunk,slant,slept,smart,smell,sniff,soft,spark,speck,spend,spear,speech,spin,spot,spoil,spoon,sport,spring,stamp,stand,stair,star,start,step,steep,stop,strap,street,string,stunt,swim,swing,shampoo,shelf,shelter,shift,shrink,task,tent,tenth,tilt,toast,track,tramp,trash,trail,train,train,trench,trend,tree,treetop,trip,trunk,trust,tuft,tusk,twin,twist,theft,think,thrill,thump,went,wind");
	$key = $keys[array_rand($keys)].rand(100,999);
	if(in_array($key.".json",$files) === true){
		getNewKey($key);
	}
	echo $key;
	copy('../../../json/template.json', "../../../json/games/".$key.".json");
	chmod("../../../json/games/".$key.".json",0776);
}
$key = getNewKey($key, $files);
?>