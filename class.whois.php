<?php
// *************************************************************************
// *                                                                       *
// * WHOIS KOMPLIT - Find Your Domain								       *
// * Version: 1.0                                                          *
// * Build Date: 28 September 2017                                         *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: helmy.hudiya@gmail.com                                         *
// *                                                                       *
// *************************************************************************

class whoiskomplit{
	function memproses($namadomain,$eks){
		//Get TLD data from json list
		$data = json_decode(file_get_contents("list/listdomain.json"), true);
		
		//Initialization
		$i=0;
		$ketemu = false;
		
		while($i<=count($data)-1 && $ketemu==false) {
			//Exploding TLD from list
			$tld = explode (",",$data[$i]['extensions']);
			$x=0;
			//Exploding TLD from array list
			while($x<=count($tld)-1 && $ketemu==false){
				//If explode result = extension
				if ($tld[$x]==$eks){
					//Get specific TLD data
					$this->hasil($namadomain.$tld[$x],
									$data[$i]['uri'],
									$data[$i]['available']);
					$ketemu = true;
				} 
				$x = $x+1;
			} 
			$i = $i+1;
		}
	}
	
	function cek($domain,$server){
		global $koneksi;
		
		//Send the requested domain name
		$koneksi = fsockopen($server, 43);
		fputs($koneksi, $domain."\r\n");
			
		return $koneksi;
	}
	
	function whoischecker($server,$domain){
		global $koneksi;
		global $hasil;
		
		//Calling 'cek' function
		$this->cek($domain,$server);
		
		//Whois checker
		$respon = '';
		while(!feof($koneksi)){
			$respon .= fgets($koneksi,128); 
		}
		fclose($koneksi);
		
		$hasil = "";
		if((strpos(strtolower($respon), "error") === FALSE) && (strpos(strtolower($respon), "not allocated") === FALSE)) {
			$rows = explode("\n", $respon);
			foreach($rows as $row) {
				$row = trim($row);
				if(($row != '') && ($row{0} != '#') && ($row{0} != '%')) {
					$hasil .= $row."\n";
				}
			}
		}
	}
	
	function cekdomain($domain,$server,$tersedia){
		global $koneksi;
		
		//Calling 'cek' function
		$this->cek($domain,$server);
		
		//Check domain function
		$respon = ' :';
		while(!feof($koneksi)){
			$respon .= fgets($koneksi,128); 
		}
		fclose($koneksi);
		
		//Check the response whether the domain is available
		if(strpos($respon, $tersedia)){
			return true;
		}else{
			return false;   
		}
	}
	
	function hasil($namadomain,$server,$tersedia){
		global $hasil;
		
		//Calling 'cekdomain' function
		if($this->cekdomain($namadomain,$server,$tersedia)){
			//If domain available
			echo "Domain <u><b>$namadomain</b></u> available, You can use this Domain. <b><a href='#' style='color: #fff;'>Buy <i class='fa fa-arrow-right'></i></a></b>";
		}else{
			//If domain unavailable
			$this->whoischecker($server,$namadomain);
			define("BASEPATH", dirname(__FILE__));
			include ("popup.php");
			echo "Domain <u><b><a href='http://$namadomain' style='color: #fff;' target='_blank'>$namadomain</a></b></u> unavailable, You can't use this Domain.<br><b><a href='javascript:void(0);' style='color: #fff;' id='popupLink'>WHOIS?</a></b>";
		}
	}

}
?>