<?php
// *************************************************************************
// *                                                                       *
// * WHOIS KOMPLIT - Find Your Domain								       *
// * Version: 2.0                                                          *
// * Build Date: 28 September 2017                                         *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: helmy.hudiya@gmail.com                                         *
// *                                                                       *
// *************************************************************************

require_once("whoiskomplit.php");
require_once("config.php");

//Checking domain field
if(isset($_POST['domain']) && ($_POST['domain']) != ''){
	//If domain field isn't empty
	
	//Creating an object
	$whois = new whoiskomplit();
	
	if($konfigurasi['autoselect']){
		$domain = $whois->hapus($_POST['domain']);
	
		if($whois->validasi1($domain)) 
		//If validation returns true
		$whois->memproses($domain,$_POST['eks']);
		//If validation returns false
		else echo "<b>Domain is not valid!</b>";
	}else{
		$domain = $whois->hapus($_POST['domain']);
		$dot = strpos($domain,".");
		$tld = substr($domain,$dot);
		
		if($whois->validasi2($domain)) 
		//If validation returns true
		$whois->memproses(substr($domain,0,$dot),$tld);
		//If validation returns false
		else echo "<b>Domain is not valid!</b>";
	}
}else{
	//If domain field is empty
	echo "Please enter domain name!";
}
?>