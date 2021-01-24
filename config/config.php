<?php
/*
 * UniFi Voucher Service v2.0
 * Copyright 2018 Sass-Projects (https://www.sass-projects.info)
 * Licensed under GNU General Public License v3.0
 * (https://github.com/PaintSplasher/unifi-voucher-service/blob/master/README.md)
*/

$uvs_config = array(
	// Möglichkeit zur Übersetzung
	"intl" => array(
		"bandwidth_down" => "",
		"bandwidth_down_unit" => "MBit/s",
		"bandwidth_up" => "",
		"bandwidth_up_unit" => "MBit/s",
		"day" => "Tag",
		"days" => "Tage",
		"expiration" => "", // Valid for
		"hours" => "Stunden",
		"quota" => "",
		"ssid" => "WLAN:",
		"usages" => "",
	),
	"printer" => array(
		"labelsize" => "62", // For more information about supported labels visit: https://pypi.org/project/brother_ql/
		"model" => "QL-500", // For more information about supported printers visit: https://pypi.org/project/brother_ql/
		"usbid" => "04f9:2015", // Remember your printer ID. To identify your printer at your usb-port type lsusb, as mention in step 5.
	),
	"unifi" => array(
		"controller" => array(
			"debug" => false, //set to true (without quotes) to enable debug output to the browser and the PHP error log
			"password" => "secret", // the password for access to the UniFi Controller
			"url" => "https://192.168.1.1", // full url to the UniFi Controller, eg. 'https://22.22.11.11:8443'
			"user" => "hotspot_operator", // the user name for access to the UniFi Controller
			"version"  => "6.0.42", // the version of the Controller software, eg. '4.6.6' (must be at least 4.0.0)
		),
		"vlan" => "",
		"ssid" => "",
	),
	"webroot" => "/var/www/html/unifi-voucher-service",
	"website" => array(
		"subtitle" => "Please choose a voucher to get access to our network!", // Here you can write down your subtitle or some comment
		"title" => "Unifi Voucher Service", // The title of your voucher page
	),
);

$uvs_vouchers = array(
	"3-day-free" => array(
		"expiration" => 72, // expiration time in hours
		"limit" => null, // Byte Quota per use in MB (null=unlimited)
		"max_bandwidth_down" => 5,  // Bandwidth Limit Download in MBit/s
		"max_bandwidth_up" => 1,  // Bandwidth Limit Download in MBit/s
		"max_devices" => 2, // number of devices that can be used parallelly
		"note" => "Kostenloser Zugang", // Note on the voucher
		"site_id" => "default", // The site where you want to create the voucher
		"type" => "free",
	),
	"7-day-free" => array(
		"expiration" => 168, // expiration time in hours
		"limit" => null, // Byte Quota per use in MB (null=unlimited)
		"max_bandwidth_down" => 5,  // Bandwidth Limit Download in MBit/s
		"max_bandwidth_up" => 1,  // Bandwidth Limit Download in MBit/s
		"max_devices" => 2, // number of devices that can be used parallelly
		"note" => "Kostenloser Zugang", // Note on the voucher
		"site_id" => "default", // The site where you want to create the voucher
		"type" => "free",
	),
	"14-day-free" => array(
		"expiration" => 336, // expiration time in hours
		"limit" => null, // Byte Quota per use in MB (null=unlimited)
		"max_bandwidth_down" => 5,  // Bandwidth Limit Download in MBit/s
		"max_bandwidth_up" => 1,  // Bandwidth Limit Download in MBit/s
		"max_devices" => 2, // number of devices that can be used parallelly
		"note" => "Kostenloser Zugang", // Note on the voucher
		"site_id" => "default", // The site where you want to create the voucher
		"type" => "free",
	),
	"3-day-paid" => array(
		"expiration" => 72, // expiration time in hours
		"limit" => null, // Byte Quota per use in MB (null=unlimited)
		"max_bandwidth_down" => 10,  // Bandwidth Limit Download in MBit/s
		"max_bandwidth_up" => 2,  // Bandwidth Limit Download in MBit/s
		"max_devices" => 5, // number of devices that can be used parallelly
		"note" => "Premium Zugang", // Note on the voucher
		"site_id" => "default", // The site where you want to create the voucher
		"type" => "pay",
	),
	"7-day-paid" => array(
		"expiration" => 168, // expiration time in hours
		"limit" => null, // Byte Quota per use in MB (null=unlimited)
		"max_bandwidth_down" => 10,  // Bandwidth Limit Download in MBit/s
		"max_bandwidth_up" => 2,  // Bandwidth Limit Download in MBit/s
		"max_devices" => 5, // number of devices that can be used parallelly
		"note" => "Premium Zugang", // Note on the voucher
		"site_id" => "default", // The site where you want to create the voucher
		"type" => "pay",
	),
	"14-day-paid" => array(
		"expiration" => 336, // expiration time in hours
		"limit" => null, // Byte Quota per use in MB (null=unlimited)
		"max_bandwidth_down" => 10,  // Bandwidth Limit Download in MBit/s
		"max_bandwidth_up" => 2,  // Bandwidth Limit Download in MBit/s
		"max_devices" => 5, // number of devices that can be used parallelly
		"note" => "Premium Zugang", // Note on the voucher
		"site_id" => "default", // The site where you want to create the voucher
		"type" => "pay",
	),
);

?>
