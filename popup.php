<?php defined("BASEPATH") or exit("No direct access allowed!"); ?>	
<div id="popupBox" class="popup">
	<div class="popup-content">
		<div class="popup-head">
			<span class="keluar">×</span>
			<h2>Whois <?php echo $namadomain."?"; ?></h2>
		</div>
		<div class="popup-main">
			<p><?php echo "<pre>\n" . $hasil . "\n</pre>\n";?></p>
		</div>
		<div class="popup-foot">
			<p>Footer Here.</p>
		</div>
	</div>
</div>
<script>	
	var popup = document.getElementById('popupBox');
	var tautan = document.getElementById("popupLink");
	var keluar = document.getElementsByClassName("keluar")[0];

	tautan.onclick = function(){
		popup.style.display = "block";
	}
	keluar.onclick = function(){
		popup.style.display = "none";
	}
	window.onclick = function(event){
		if (event.target == popup) {
			popup.style.display = "none";
		}
	}
</script>