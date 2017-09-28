<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
		<link rel="stylesheet" href="css/style.css">
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
			<input type="text" id="domain" placeholder="Masukkan Nama Domain" autocomplete="off">
			<select id="eks">
				<option value=".com">.com</option>
				<option value=".net">.net</option>
				<option value=".org">.org</option>
				<option value=".info">.info</option>
				<option value=".biz">.biz</option>
				<option value=".name">.name</option>
				<option value=".us">.us</option>
				<option value=".ca">.ca</option>
				<option value=".asia">.asia</option>
				<option value=".co">.co</option>
				<option value=".de">.de</option>
				<option value=".eu">.eu</option>
				<option value=".in">.in</option>
				<option value=".mobi">.mobi</option>
				<option value=".me">.me</option>
			</select>
			<input id="tombol-cek" type="submit" value="Cek">
			<div class="message"></div>			
		</div>
	</body>
</html>