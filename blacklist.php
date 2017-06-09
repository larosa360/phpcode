<?php
if(empty($_POST['input'])){
	header("Location: index.html");
}
//Blacklists
$blacklist = ["dnsbl-1.uceprotect.net","dnsbl-2.uceprotect.net","dnsbl-3.uceprotect.net","dnsbl.dronebl.org","dnsbl.sorbs.net","zen.spamhaus.org","bl.spamcop.net","list.dsbl.org","sbl.spamhaus.org","xbl.spamhaus.org","relays.osirusoft.com"];
//define variables
$inputMasterArray = [];
$blackListMasterArray = [];
//sanitize input and split it into an array
$inputArray = array_filter(array_map('trim', preg_split("/\r?\n?\s/", $_POST['input'])));
//Process inputArryay
foreach($inputArray as $host) {
    $inputSubArray = [];
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

print_r("<html>");
print_r("this is the first module");
print_r("<br />");
print_r($inputMasterArray);
print_r("<br />");
print_r("<br />");
print_r("this is the second module");
print_r("<br />");


foreach($inputMasterArray as $host){
	foreach($host as $userInput => $ip){
		if($ip != False){
			$reverseip = implode('.', array_reverse(explode('.',$ip))); 
			$blackListSubArray = [];
			foreach($blacklist as $blacklHost){
				if(checkdnsrr($reverseip . "." . $blacklHost . ".", "A")){
					array_push($blackListSubArray, "yes");
				}
				else{
					array_push($blackListSubArray, "no");
				}
			}
			$blacklistLabelArray = array($userInput => $blackListSubArray);
			array_push($blackListMasterArray, $blacklistLabelArray );
		}
		else{
			print_r("user entered: " . $userInput . " but it failed to resolve");
		}
	}
}


print_r($blackListMasterArray);
print_r("</html>");
//Prints the current output of the foreach loop
?>
