<?php
/*
 * UniFi Voucher Service v2.0
 * Copyright 2018 Sass-Projects (https://www.sass-projects.info)
 * Licensed under GNU General Public License v3.0
 * (https://github.com/PaintSplasher/unifi-voucher-service/blob/master/README.md)
*/

// Include the Unifi Voucher Service config file
require_once ('../config/config.php');

require_once ('./Voucher.php');

class FreeVoucher extends Voucher {

	// Fonts convert function for the printing voucher
	public function create_printimage($t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8, $webroot) {
		$im = imagecreate(696,271);
		$background_color = imagecolorallocate($im, 255, 255, 255);
		$text_color = imagecolorallocate($im, 0, 0, 0);
		$font = $webroot ."/assets/fonts/montserrat-regular.otf";
		$color = imagecolorallocate($im, 0, 0, 0);

		imagettftext($im, 45, 0, 290, 160, $color, $font, $t1);
		imagettftext($im, 20, 0, 54, 245, $color, $font, $t2);
		imagettftext($im, 20, 0, 54, 174, $color, $font, $t3);
		imagettftext($im, 20, 0, 54, 96, $color, $font, $t4);
		imagettftext($im, 25, 0, 300, 200, $color, $font, $t5);
		imagettftext($im, 20, 0, 275, 255, $color, $font, $t6);
		imagettftext($im, 25, 0, 12, 38, $color, $font, $t7);
		imagettftext($im, 20, 0, 380, 255, $color, $font, $t8);

		imagepng($im, $webroot ."/codeimage/voucher.png");
	 }
}

// Change the button if the voucher is printed
$selected_voucher = $_GET["selected_voucher"];

echo "<button type=\"submit\" name=\"".$selected_voucher."\" id=\"".$selected_voucher."\">";
echo "<img src=\"assets/img/done_printing.png\" class=\"img-responsive\" />";
echo "</button>";

$voucher_config = $uvs_vouchers[$selected_voucher];
$free_voucher = new FreeVoucher($uvs_config, $voucher_config["site_id"]);

$unifi_voucher = $free_voucher->create_voucher_in_unifi($voucher_config);
$wlan_ssid = $free_voucher->get_wifi_ssid();
$free_voucher->print_voucher($unifi_voucher, $wlan_ssid);

// Reload the page after the print was successful
echo "<script type=\"text/javascript\">setTimeout(\"document.location.reload();\",3000);</script>";
?>
