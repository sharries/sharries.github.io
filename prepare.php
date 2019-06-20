<?php 
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
<script   src="js/jquery-3.1.1.js"></script>	
<script   src="js/alterClass.js"></script>	
<script>
$('document').ready(function(){
	$('#go').click(function(){
		$.ajax({
		  method: 'get',
		  url: 'php/mode.php?file=<?php echo $key ?>&mode='+$("#gm").val(),
		  success: function(result) {
			window.location.href = "play.php?name=<?php echo $name ?>&key=<?php echo $key ?>&players=<?php echo $players ?>";
		  }	
		});
	});
});  // End Doc ready
</script>
</head>
<body class="invert txt-c">
<div class="row h8"><img src="assets/et-logo3.png" class="fullh"></div>
<h1>Go <?php echo $name ?>!</h1>
<label for="gm">Game Mode</label><br>
<select id="gm">
	<option selected>Story Telling</option>
	<option>Last Letter</option>
</select>
<h2>Click Go</h2>
<button id="go" class="btn">Go</button>
<script src="js/BC-CMS.js"></script>
</body>
</html>