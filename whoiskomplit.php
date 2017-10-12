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

class whoiskomplit{
	
	function __construct(){
		//Construct for load config
		include('config.php');
		global $konfigurasi;
	}
	
	function hapus($namadomain){
		//Removing space from domain
		$namadomain = str_replace(" ","",$namadomain);
		
		//Removing 'http://' if any
		if(substr($namadomain, 0, 7) == "http://") $namadomain = substr($namadomain, 7);
		
		//Removing 'www.' if any
		if(substr($namadomain, 0, 4) == "www.") $namadomain = substr($namadomain, 4);
		
		return $namadomain;	
	}
	
	function validasi1($namadomain){
		//Validation if autoselect is true
		if(preg_match("/^([-a-z0-9]{2,100})$/i",$namadomain)) return true;
		else return false;	
	}
	
	function validasi2($namadomain){
		//Validation if autoselect is false
		if(preg_match("/^([-a-z0-9]{2,100})\.([a-z\.]{2,8})$/i", $namadomain)) return true;
		else return false;	
	}
	
	function cekdomainsupport($eks){
		global $konfigurasi;
		
		if(($konfigurasi['autoselect']) OR ($konfigurasi['domainsupport'][0] == "-")){
			$stop = false;
		}else{
			//Inisialization
			$i=0;
			$stop = true;
			
			//While increment <= domain array list (on file config.php) then do
			while($i<=count($konfigurasi['domainsupport'])-1 && $stop==true){
				if($eks == $konfigurasi['domainsupport'][$i]){
					$stop = false;
				}
				$i = $i + 1;
			}
			//If the extension does not exist in config.php ($domainsupport)
			if($stop) echo "<b>Domain extension is not supported!</b>";
		}
		return $stop;
	}
	
	function memproses($namadomain,$eks){
		//Get TLD data from json list
		$data = json_decode(file_get_contents("list/listdomain.json"), true);
		
		//Initialization
		$i=0;
		$stop = $this->cekdomainsupport($eks);
		
		//While increment <= amount of data AND data not found yet, then do
		while(($i<=count($data)-1) AND ($stop==false)){
			//Exploding TLD from list
			$tld = explode(",",$data[$i]['extensions']);
			$x=0;
			//Exploding TLD from array list
			while(($x<=count($tld)-1)){
				//If explode result = extension
				if($tld[$x]==$eks){
					//Get specific TLD data
					$this->hasil($namadomain.$tld[$x],$data[$i]['url'],$data[$i]['available']);
					$stop = true;
				}
				$x = $x+1;
			}
			$i = $i+1;
		}
		//If increment > data
		if($i > count($data)) echo "<b>Extension is not valid!</b>";
	}
	
	function cek($domain,$server){
		//Send the requested domain name
		$koneksi = fsockopen($server, 43);
		fputs($koneksi, $domain."\r\n");
			
		return $koneksi;
	}
	
	function whoischecker($server,$domain){
		//Calling 'cek' function
		$koneksi = $this->cek($domain,$server);
		
		//Whois checker
		$respon = '';
		while(!feof($koneksi)){
			$respon .= fgets($koneksi,128); 
		}
		fclose($koneksi);
		
		$hasil = "";
		if((strpos(strtolower($respon), "error") === FALSE) AND (strpos(strtolower($respon), "not allocated") === FALSE)) {
			$rows = explode("\n", $respon);
			foreach($rows as $row) {
				$row = trim($row);
				if(($row != '') && ($row{0} != '#') && ($row{0} != '%')) {
					$hasil .= $row."\n";
				}
			}
		}
		
		//If data not found
		if($hasil == "") $hasil = "No whois data found!";
		
		return $hasil;
	}
	
	function cekdomain($domain,$server,$status){
		//Calling 'cek' function
		$koneksi = $this->cek($domain,$server);
		
		//Check domain function
		$respon = ' :';
		while(!feof($koneksi)){
			$respon .= fgets($koneksi,128); 
		}
		fclose($koneksi);
		
		//Check the response whether the domain is available
		if(strpos($respon, $status)){
			return true;
		}else{
			return false;   
		}
	}
	
	function hasil($namadomain,$server,$status){
		global $konfigurasi;
		$hasil = $this->whoischecker($server,$namadomain);
		
		//Calling 'cekdomain' function
		if($this->cekdomain($namadomain,$server,$status)){
			//If domain available
			echo "Domain <u><b>$namadomain</b></u> available, You can use this Domain. <b><a href='$konfigurasi[buylink]' style='color: #fff;'>Buy <i class='fa fa-arrow-right'></i></a></b>";
		}else{
			//If domain unavailable
			$this->whoischecker($server,$namadomain);
			define("BASEPATH", dirname(__FILE__));
			include ("include/popup.php");
			echo "Domain <u><b><a href='http://$namadomain' style='color: #fff;' target='_blank'>$namadomain</a></b></u> unavailable, You can't use this Domain.<br><b><a href='javascript:void(0);' style='color: #fff;' id='popupLink'>WHOIS?</a></b>";
		}
	}

}
?>