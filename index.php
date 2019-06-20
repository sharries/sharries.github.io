<!doctype html>
<html lang="en-gb">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
<title>ElephantTree</title>
<meta name="author" content="Steve Harries">
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link rel="manifest" href="manifest.json">
<link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
<link rel="stylesheet" href="css/master.css">
<link rel="stylesheet" type="text/css" href="css/custom.css">
<script   src="js/jquery-3.1.1.js"></script>	
<script   src="js/alterClass.js"></script>	
<script>
$('document').ready(function(){
	$('#join').on('touchstart mousedown', function(e){
		e.stopPropagation();
		var str = $('#name').val();
		if(str != ""){
			window.location.href="lobby.php?n="+str;
		}
	});
	
	$('#name').click(function(){
		var rnd1 = Math.floor(Math.random()*10) + 6;
		var rnd2 = Math.floor(Math.random()*2) +1;
		var rnd3 = Math.floor(Math.random()*5) +1;
		one(rnd1,rnd2,rnd3);
		rnd1 = Math.floor(Math.random()*10) + 6;
		rnd2 = Math.floor(Math.random()*2) +1;
		rnd3 = Math.floor(Math.random()*5) +1;
		two(rnd1,rnd2,rnd3);
	});
	
	function one(rnd1,rnd2,rnd3){
      var text = "elephant";
      var msg = new SpeechSynthesisUtterance();
      var voices = window.speechSynthesis.getVoices();
	  console.log(voices);
      msg.voice = voices[rnd3];
      msg.rate = rnd1 / 10;
      msg.pitch = rnd2;
      msg.text = text;
      speechSynthesis.speak(msg);	

		console.log(rnd1+" "+rnd2+" "+rnd3);	  
	}
	function two(rnd1,rnd2,rnd3){
      var text = "tree";
      var msg = new SpeechSynthesisUtterance();
      var voices = window.speechSynthesis.getVoices();
	  console.log(voices);
      msg.voice = voices[rnd3];
      msg.rate = rnd1 / 10;
      msg.pitch = rnd2;
      msg.text = text;
      speechSynthesis.speak(msg);	

		console.log(rnd1+" "+rnd2+" "+rnd3);	  
	}
	
});  // End Doc ready
</script>
</head>
<body class="invert txt-c">
<div class="row h8"><img src="assets/et-logo.png" class="fullh"></div>
<label for="name" class="light p-sml m-sml">Enter your name:</label>
<p>
<input id="name" type="text" class="p-sml m-sml txt-c">
</p>
<p>
<span id="join" class="btn w12 bg-orange dark p-sml m-sml">Join</span>
</p>
<script src="js/BC-CMS.js"></script>
</body>
</html>