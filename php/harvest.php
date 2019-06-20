 <?php
$_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

// $form is new array []
$form = [];

if(!empty($_POST) && isset($_POST)){
	foreach($_POST as $key => $value){
		$form[$key] = $value;
	}
}

// Harvest $_GET data if it exists
$query = [];

if(!empty($_GET)){
	foreach($_GET as $key => $value){
		// Collect others as $query_value[key]
		$query[$key] = $value;
	}
}
?>
