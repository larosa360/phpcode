<?php
//Checks to see if input post is set other wise sends back to index.html
if(empty($_POST['input'])){
	header("Location: index.html");

}
else{
	//Sets Variables
	$inputMasterArray = array();
	$inputSubArray = array();
	//Process Input
	$input = $_POST['input'];
	$input = preg_split("/\r?\n?\s/", $input);
	foreach($input as $host){
		if(filter_var($host, FILTER_VALIDATE_IP)){
			$inputSubArray = array($host=>$host);
		}
		elseif(filter_var($host, FILTER_VALIDATE_DOMAIN)){
			$inputSubArray = array($host=>$host);
		}
		endif;
		array_push($inputMasterArray,$inputSubArray);
	}
	print_r($inputMasterArray);
}

?>
