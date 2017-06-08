<?php
if(empty($_POST['input'])){
	header("Location: index.html");
}
//Blacklists
$blacklist = ["dnsbl-1.uceprotect.net","dnsbl-2.uceprotect.net","dnsbl-3.uceprotect.net","dnsbl.dronebl.org","dnsbl.sorbs.net","zen.spamhaus.org","bl.spamcop.net","list.dsbl.org","sbl.spamhaus.org","xbl.spamhaus.org","relays.osirusoft.com"];
//define variables
$inputMasterArray = array();

//sanitize input and split it into an array
$inputArray = array_filter(array_map('trim', preg_split("/\r?\n?\s/", $_POST['input'])));

//Process inputArryay
foreach($inputArray as $host) {
    $inputSubArray = array();
    $resultip = '';
    if(filter_var($host, FILTER_VALIDATE_IP)){
        $resultip = $host;
        $inputSubArray = array($host => $resultip);
        array_push($inputMasterArray, $inputSubArray);
    }
	elseif(filter_var($resultip = gethostbyname($host), FILTER_VALIDATE_IP)){
        $inputSubArray = array($host => $resultip);
        array_push($inputMasterArray, $inputSubArray);
    }
	else{
        $inputSubArray = array($host => False);
        array_push($inputMasterArray, $inputSubArray);
    }
}

foreach($inputMasterArray as $host){
	foreach($host as $entry => $ip){
		if($ip != False){
			$reverseip = implode('.', array_reverse(explode('.',$ip))); 
			print_r($reverseip);
		}
		else{
			print_r("user entered: " . $entry . " but it failed to resolve");
		}
	}
}
//Prints the current output of the foreach loop

?>
