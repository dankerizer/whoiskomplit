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
		$data = json_decode(file_get_contents("list/listdomain.json"), true);
		
		$i=0;
		$ketemu = false;
		while($i<=count($data)-1 && $ketemu==false) {
			$arr_kalimat = explode (",",$data[$i]['extensions']);
			$x=0;
			while($x<=count($arr_kalimat)-1 && $ketemu==false){
				if ($arr_kalimat[$x]==$eks){
					$this->hasil($namadomain.$arr_kalimat[$x],
											$data[$i]['uri'],
											$data[$i]['available']);
					$ketemu = true;
				} 
				$x = $x+1;
			} 
			$i = $i+1;
		}

	}

	function hasil($namadomain,$server,$tersedia){
		if($this->cekdomain($namadomain,$server,$tersedia)){
			echo "Domain <u><b>$namadomain</b></u> tersedia, Anda dapat menggunakan domain ini. <b><a href='#' style='color: #fff;'>Beli <i class='fa fa-arrow-right'></i></a></b>";
		}else{
			echo "Domain <u><b><a href='http://$namadomain' style='color: #fff;' target='_blank'>$namadomain</a></b></u> tidak tersedia, Anda tidak dapat menggunakan domain ini.";
		}
	}

	function cekdomain($domain,$server,$tersedia){
		$koneksi = fsockopen($server, 43);
		if(!$koneksi) {
			return false;
		}
			
		fputs($koneksi, $domain."\r\n");
			
		$respon = ' :';
		while(!feof($koneksi)){
			$respon .= fgets($koneksi,128); 
		}
			
		fclose($koneksi);
			
		if (strpos($respon, $tersedia)){
			return true;
		}else{
			return false;   
		}
	}
}
?>