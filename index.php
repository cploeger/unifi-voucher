<?php
/*
 * UniFi Voucher Service v2.0
 * Copyright 2018 Sass-Projects (https://www.sass-projects.info)
 * Licensed under GNU General Public License v3.0
 * (https://github.com/PaintSplasher/unifi-voucher-service/blob/master/README.md)
*/
require_once ('config/config.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="shortcut icon" href="assets/img/favicon.ico">
		<title><?php echo $uvs_config["website"]["title"] ?></title>
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="assets/css/style.min.css" rel="stylesheet">
		<link href="assets/css/font-awesome.min.css" rel="stylesheet">
	</head>
	<body>
		<section id="works"></section>
		<div class="container">
			<div class="row centered mt mb">
				<span class="shutdown_btn"><a href="shutdown.php"><img src="assets/img/shutdown.png" /></a></span>
				<p><a href="index_custom.php"><img src="assets/img/logo.png" /></a></p>
				<h4><?php echo $uvs_config["website"]["subtitle"] ?></h4>
				<form id="buttons">
<?php
				foreach ($uvs_vouchers as $key=>$voucher) {
					
					if ($voucher["type"] == "free") {
						echo "<div class=\"col-lg-4 col-md-4 col-sm-4 gallery1st ".$key."\">".PHP_EOL;
						echo "<button onCLick=\"\$.ajax({url:'vouchers/free-voucher.php?selected_voucher=".$key."',type:'GET',success:function(data){\$('.".$key."').html(data);}});\" type=\"submit\" name=\"".$key."\" id=\"".$key."\">".PHP_EOL;
					} else {
						echo "<div class=\"col-lg-4 col-md-4 col-sm-4 gallery2nd ".$key."\">".PHP_EOL;
						echo "<button onCLick=\"\$.ajax({url:'vouchers/paid-voucher.php?selected_voucher=".$key."',type:'GET',success:function(data){\$('.".$key."').html(data);}});\" type=\"submit\" name=\"".$key."\" id=\"".$key."\">".PHP_EOL;
					}
					echo "<div id=\"oben\">".PHP_EOL;
					echo "<img src=\"assets/img/printing.png\" id=\"".$key."-img\" width=\"208px\" class=\"img-responsive\" />".PHP_EOL;
					echo "</div>".PHP_EOL;
					echo "<div id=\"unten\">".PHP_EOL;
					echo "<img src=\"assets/img/".$key.".png\" class=\"img-responsive\" />".PHP_EOL;
					echo "</div>".PHP_EOL;
					echo "</button>".PHP_EOL;
					echo "</div>".PHP_EOL;
				}
?>					
				</form>
			</div>
		</div>
	
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script>
		$(document).ready(function() {
		$("#buttons").submit(function(e) {
			e.preventDefault();
<?php
			foreach ($uvs_vouchers as $key=>$voucher) {
				echo "\$(\"#".$key."\").attr(\"disabled\", true);".PHP_EOL;
			}
?>
			return true;
		  });
		});

		$(document).ready(function() {
<?php
			foreach ($uvs_vouchers as $key=>$voucher) {
				echo "\$('#".$key."-img').hide();\$(\"#".$key."\").click(function(){\$(\"#".$key."-img\").show(); });".PHP_EOL;
			}
?>
		});
		</script>
   </body>
</html>