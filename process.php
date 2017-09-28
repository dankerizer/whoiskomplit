<?php
	require_once("class.whois.php");
	if(isset($_POST['domain']) && ($_POST['domain']) != ''){
		$whois = new whoiskomplit();
		$whois->memproses($_POST['domain'],$_POST['eks']);
	}else{
		echo "Silakan Masukkan Nama Domain!";
	}
?>