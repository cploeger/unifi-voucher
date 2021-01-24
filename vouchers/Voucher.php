<?php
/*
 * UniFi Voucher Service v2.0
 * Copyright 2018 Sass-Projects (https://www.sass-projects.info)
 * Licensed under GNU General Public License v3.0
 * (https://github.com/PaintSplasher/unifi-voucher-service/blob/master/README.md)
*/

// Using the git Client.php
require_once ('/usr/src/UniFi-API-client/src/Client.php');

abstract class Voucher {
	
	private $config = null;
	private $unifi_connection = null;
	
	public function __construct($config, $site) {
		$this->config = $config;
		$unifi_config = $config["unifi"]["controller"];
		
		// Initialize the UniFi API connection class and log in to the controller
		$this->unifi_connection = new UniFi_API\Client($unifi_config["user"], $unifi_config["password"], $unifi_config["url"], $site, $unifi_config["version"]);
		$set_debug_mode   = $this->unifi_connection->set_debug($unifi_config["debug"]);
		$loginresults     = $this->unifi_connection->login();
	}
	
	public function __destruct() {
		$this->unifi_connection->logout();
	}

	// Fonts convert function for the printing voucher
	abstract public function create_printimage($t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8, $webroot);
	 
	public function create_voucher_in_unifi($voucher) {
		// Create the voucher with the requested expiration value and settings
		$voucher_result = $this->unifi_connection->create_voucher($voucher["expiration"]*60, 1, $voucher["max_devices"], $voucher["note"], $voucher["max_bandwidth_up"]*1024, $voucher["max_bandwidth_down"]*1024, $voucher["limit"]);

		// Fetch the newly created vouchers by the create_time returned
		$vouchers = $this->unifi_connection->stat_voucher($voucher_result[0]->create_time);
		return $vouchers[0];
	}
	 
	// To get a SSID and the needed key for our guest VLAN
	public function get_wifi_ssid() {
		$unifi_config = $this->config["unifi"];
		 
		if (isset($unifi_config["ssid"])) {
			$wlan_ssid = $unifi_config["ssid"];
		} else {
			$wlan_array = $this->unifi_connection->list_wlanconf();
			foreach ($wlan_array as $wlan) {
				if ($wlan->vlan === $unifi_config["vlan"]) {
					$wlan_ssid = $wlan->name;
				}
			}
		}
		return $wlan_ssid;
	}
	
	public function print_voucher($voucher, $wlan_ssid) {
		$intl = $this->config["intl"];
		
		// Time to collect all information and limits
		$t1 = $voucher->code;
		$t1 = substr($t1,0,5) . "-" . substr($t1,5,5);
		$t2 = $intl["bandwidth_up"] . " " . ($voucher->qos_rate_max_up) / 1024 . " " . $intl["bandwidth_up_unit"];
		$t3 = $intl["bandwidth_down"] . " " . ($voucher->qos_rate_max_down) / 1024 . " " . $intl["bandwidth_down_unit"];
		
		$duration = $voucher->duration / 60;
		if ($duration < 24) {
			$t4 = $intl["expiration"] ." " . $duration . " " . $intl["hours"];
		} else {
			if ($duration == 24) {
				$t4 = $intl["expiration"] ." " . $duration / 24 . " " . $intl["day"];
			} else {
				$t4 = $intl["expiration"] ." " . $duration / 24 . " " . $intl["days"];
			}
		}
		
		$t5 = $voucher->note;
		$t6 = $intl["quota"] ." ". $voucher->quota . " " . $intl["usages"];
		$t7 = $intl["ssid"] . " " . $wlan_ssid;
		$t8 = (date("d.m.Y", $voucher->create_time) . ", " . date("H:i", $voucher->create_time) ." Uhr");
		
		// Create the image to print
		$this->create_printimage($t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8, $this->config["webroot"]);

		// Composition of some outlines and all voucher information
		shell_exec( "sudo /usr/bin/convert ". $this->config["webroot"] ."/codeimage/voucher.png ". $this->config["webroot"] ."/codeimage/outlines.png -composite ". $this->config["webroot"] ."/codeimage/voucher_final.png" );

		// To get rid of some ASCII issues with python
		setlocale(LC_ALL,"C.UTF-8");
		putenv("LC_ALL=C.UTF-8");
		putenv("LANG=C.UTF-8");

		// Collect all information and send the print command
		$printer = $this->config["printer"];
		shell_exec("sudo brother_ql -p usb://" . $printer["usbid"] . " -m " . $printer["model"] . " print -l " . $printer["labelsize"] . " " . $this->config["webroot"] . "/codeimage/voucher_final.png");	
	}
}

?>
