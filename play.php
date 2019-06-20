<?php 
session_start();
	include_once('php/harvest.php');
	if(isset($query['name'])){
		$name = $query['name'];
	}else{
		$name = "";
	}
	if(isset($query['key'])){
		$key = $query['key'];
	}else{
		$key = "";
	}	
	if(isset($query['players'])){
		$players = $query['players'];
	}else{
		$players = "";
	}	
	$json = file_get_contents("../../json/games/".$key.".json");
	$json = json_decode($json, true);
	if(isset($json['word']) && isset($json['letter']) && isset($json['mode'])){
		$theWord = $json['word'];
		$letter = $json['letter'];
		$mode = $json['mode'];
	}
	$i=0;
	$c=0;
	foreach ($json['players'] as $value) {
		if($value['name'] == $name){
			$c = $i;
		}
	$i++;
	}
?>
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
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<script   src="js/jquery-3.1.1.js"></script>	
<script   src="js/alterClass.js"></script>	
<script>
$('document').ready(function(){
	// RUNTIME
	$.ajaxSetup({ cache: false });
	var game=false;
	var played = [];
	var playing=false;
	var flag = false;
	var theWord = "<?php echo $theWord ?>";
	var letter="";
	var mute = true;
	console.log("THE WORD 49 "+theWord);
	$("#wordh,i").hide();
	var button = document.querySelector('#leave');
	var evtSource = new EventSource("php/sse-lobby.php?key=<?php echo $key ?>");
	console.log(evtSource.withCredentials);
	console.log(evtSource.readyState);
	console.log(evtSource.url);
	var eventList = document.querySelector('ul');
  
	//EVENTS
	$('#thumbsCont').click(function(){
		if(mute != false){
			speak(theWord);
		}
	});	

  evtSource.onopen = function() {
    console.log("Connection to server opened.");
  };

  evtSource.onmessage = function(e) {
	if(e.data.indexOf("JOIN") != -1){
		console.log(e.data);
		var num = parseInt(e.data);
		$('h1 span').html("Waiting on "+num+" player/s<br><br><span class='share'><?php echo $key ?></span><h2>Share your room name<br>with your "+num+" friend/s to join.</h2><h2>The game starts when<br>all players have joined.</h2>");		
	}else if(e.data.indexOf("FILE") != -1){
		console.log(e.data);
		$("#wordh").hide();
		$("body").css("background-color","#000");
		$('h1 span').text("Game on!");
		$('i').show();
		//setTimeout(function(){
			$.ajax({
			  method: 'get',
			  url: "php/turn.php?file=<?php echo $key ?>",
			  success: function(result) {
				  console.log("RETURN "+result);
				  result = result.split('*');
					if(parseInt(result[0]) == parseInt(<?php echo $c ?>)){
						console.log("USERID "+result[0]+" $c <?php echo $c ?>");
						$("#wordh").show();
						$("body").css("background-color","#77B753");
						playing = true;
					}else{playing = false;}
					theWord = result[1];
					if("<?php echo $mode ?>" != "Story Telling"){
						$("#table").html(result[2]);
					}
					letter = theWord.charAt(theWord.length-1);
					console.log("SENDING1 "+theWord+" LETTER "+letter);
					getImgs(theWord);
					flag = true;
			  }	
			});
		//},100);
	}
	 
	if(e.data.indexOf("NOGAME") != -1 || e.data.indexOf("JOIN") != -1){
		var num = parseInt(e.data);
		$('h1 span').html("Waiting on "+num+" player/s<br><br><span class='share'><?php echo $key ?></span><h2>Share your room name<br>with your  "+num+"  friend/s to join.</h2><h2>The game starts when<br>all players have joined.</h2>");
	}else{
		if(!game ){	
		$('h1 span').text("Game on!");
			//console.log('GI124');
			if(e.data.indexOf("FILE") == -1){
				console.log("SENDING2 "+theWord);
				getImgs(theWord);
			}
			game = true;
		}
	}

	if(e.data.indexOf("NOCHANGE") != -1){
		$('body').css('background-color','#000');
	}
	if(e.data.indexOf("CHANGED") != -1){		
		//getImgs();
	}
	// if(e.data.indexOf("TURN") != -1){		
		// var num2 = parseInt(e.data);
		// if(num2 == <?php echo $c ?>){
			// $("#wordh").show();
		// }
	// }
	  
    // var newElement = document.createElement("li");

    // newElement.textContent = "message: " + e.data;
    // eventList.appendChild(newElement);
  }

  evtSource.onerror = function() {
    console.log("EventSource failed.");
  };

  button.onclick = function() {
    console.log('Connection closed');
    evtSource.close();
  }	
  
  $("#send").click(function(){
	send();
  });

var gameTimer = 0;	
	//FUNCTIONS
	function startTimer(duration) {
		var timer = duration, seconds;
		var	display = $('#time');
		var gametime = setInterval(function () {
			gameTimer = timer;
			seconds = parseInt(timer % 60, 10);
			seconds = seconds < 10 ? "0" + seconds : seconds;

			display.text(seconds);

			if (--timer < 0) {
				 clearInterval(gametime);
				 // if(playing == true){
					 // if(theWord == "Once upon a time"){
						 // theWord = "time";
					 // }
					 // $.getJSON("https://api.datamuse.com/words?lc="+theWord, function(data){
						 // console.log(data);
						 // var rnd = Math.floor(Math.random() * data.length);
						 // theWord = data[rnd]["word"];
						// $("#word").val(theWord);
						 // getImgs(theWord);	
						// send();
						// $("#word").val('');
					// });
				 // }
			}
		}, 1000);
	}
	
	// Get JSON
	function getImgs(theWord){
		console.log("THE WORD "+theWord);
		played.push(theWord);
		if("<?php echo $mode ?>" == "Story Telling"){
			$("#table").append(theWord+" ");
		}
		if(mute != false){
			speak(theWord);	
		}
		
		var API_KEY = '11206552-81af773c8ab39e451fc54cae5';
		var URL = "https://pixabay.com/api/?key="+API_KEY+"&q="+encodeURIComponent(theWord)+"&image_type=photo&safesearch=true&orientation=horizontal";
		var c=0;
		$.getJSON(URL, function(data){
			if (parseInt(data.totalHits) > 0){
					//console.log("HITS: "+data.hits);
					$("#thumbs").html(" ");
					$.each(data.hits, function(i, hit){
						//console.log(hit.tags);  
						if(hit.tags.indexOf(theWord) != -1){
							//console.log(hit.previewURL); 
							c++;
							addImages(hit.previewURL);
							if(c > 3){
								return false;
							}
						}
					});
				
			}else{
				console.log('No hits');
			}
			
		});
		startTimer(10);
	}
		
	function addImages(img){
		$("#thumbs").append("<img src='"+img+"'>");
	}
	
	$("#word").focus(function(){
		$(this).val('')
	});
	
	$(document).bind("keypress",'#word', function(e){
		if(e.which ==13){
			send();
		}
	});
	
	function send(){
		var tmp = $('#word').val();
		var tmp2 = tmp.charAt(0);
		console.log(letter + " ~ " + tmp2);
		if(played.indexOf($('#word').val()) == -1 && tmp2 == letter || "<?php echo $mode ?>" == "Story Telling"){
		played.push(tmp);
		$.ajax({
		  method: 'get',
		  url: "php/played.php?file=<?php echo $key ?>&word="+$('#word').val()+"&timer="+gameTimer,
		  success: function(result) {
			result = result.split('*');
			theWord = result[0];
			if("<?php echo $mode ?>" != "Story Telling"){
				$("#table").html(result[1]);
			}
			console.log(result);
		  }	
		});	
		}else if(tmp2 != letter && "<?php echo $mode ?>" != "Story Telling"){
				speak("ah oe, "+tmp+" is not allowed");		
				// PENALTY?
		}else if("<?php echo $mode ?>" != "Story Telling"){
				speak("ah oe "+tmp+" has already been played.");	
				//PENALTY
		}
	}
	$('.fas').click(function(){
		if($(this).hasClass("fa-volume-up") == true){
			$(this).alterClass("fa-volume*","fa-volume-mute");
			mute = false;
		}else if($(this).hasClass("fa-volume-mute") == true){
			$(this).alterClass("fa-volume*","fa-volume-up");
			mute = true;
		}else if($(this).hasClass("fa-play") == true){
			$(this).alterClass("fa-play","fa-stop");
			if("<?php echo $mode ?>" == "Story Telling"){
				speak($('#table').text());
			}else{
				speak(theWord);				
			}
		}else{			
			$(this).alterClass("fa-stop","fa-play");
			speechSynthesis.cancel();
		}
		
	});

	function speak(text){
		var msg = new SpeechSynthesisUtterance();
		var voices = window.speechSynthesis.getVoices();
		console.log(voices);
		msg.voice = voices[5];
		msg.rate = 7 / 10;
		msg.pitch = 1;
		msg.text = text;
		speechSynthesis.speak(msg);
		msg.onend = function(e) {
			$(".fa-stop").alterClass("fa-stop","fa-play");
		};
	};
});  // End Doc ready
</script>
</head>
<body class="invert txt-c">
<div class="row txt-c"><img src="assets/et-logo4.png" class="fullw" style="max-width:420px"><span id="time" style="font-size:3em;padding:0.5em 0;" class="share">10</span></div>
<h1><i class="fas fa-volume-up"></i> <span></span> <i class="fas fa-play"></i></h1>
 
    <div id="thumbsCont" class="ma ib" style="width:420px;max-width:420px;">
		<div id="thumbs" class="col"></div>
	</div>
	<br>
	<div id="wordh" class="hide">
		<input id="word" class="txt-c p-sml" type="text" size="15"><br><button id="send" class="btn">Send [Enter]</button>
	</div>
	<div id="table" class="txt-c" style=""></div> 
	<br>
  <button id="leave">Leave</button>
<script src="js/BC-CMS.js"></script>
</body>
</html>