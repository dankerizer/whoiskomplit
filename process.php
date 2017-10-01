<?php
	require_once("class.whois.php");
	
	//Checking domain field
	if(isset($_POST['domain']) && ($_POST['domain']) != ''){
		//If domain field isn't empty
		$whois = new whoiskomplit();
		$whois->memproses($_POST['domain'],$_POST['eks']);
	}else{
		//If domain field is empty
		echo "Please enter domain name!";
	}
?>