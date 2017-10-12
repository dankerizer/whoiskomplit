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

include('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
		
		<title>WHOIS KOMPLIT - Find Your Domain</title>
		
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/popup.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		
		<script src="js/jquery.js"></script>
		<script>
			$(document).ready(function(){
				$('#tombol-cek').click(function(){
					$('.message').html('<img style="margin-left:10px; width:30px" src="images/loading.gif">');
					var domain = $('#domain').val();
					var eks = $('#eks').find(":selected").text();
					
					$.ajax({
						type	: 'POST',
						url 	: 'process.php',
						data : {
							domain: domain,
							eks: eks
							},
						success	: function(data){
							$('.message').html(data);
						}
					})

				});
			});
		</script>
	</head>
	<body>
		<div class="domain-box">
			<input type="text" id="domain" placeholder="Enter Domain Name!" autocomplete="off">
			<?php if($konfigurasi['autoselect']){ 
				echo "<select id='eks'>";
					$i = 0;
					while($i <= count($konfigurasi['domainonindexpage'])-1){
						echo "<option value='".$konfigurasi['domainonindexpage'][$i]."'>".$konfigurasi['domainonindexpage'][$i]."</option>";
						$i = $i + 1;
					}
				echo "</select>";
			} ?>
			<input id="tombol-cek" type="submit" value="Check">
			<div class="message"></div>			
		</div>
	</body>
</html>