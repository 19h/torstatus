<?php

// Copyright (c) 2006-2007, Joseph B. Kowalski
// See LICENSE for licensing information

// See README file for description of values listed here


$LocalTorServerIP = "127.0.0.1";
$LocalTorServerControlPort = "9051";
$LocalTorServerPassword = null;

$SQL_Server = "localhost";
$SQL_User = "TorNetworkStatus";
$SQL_Pass = "PASSWORD";
$SQL_Catalog = "TorNetworkStatus";

$UsingSquid = 0;
// If you are using Squid, fill out the following:
$RealServerIP = "1.2.3.4";

$JPGraph_Path = "jpgraph/";
$GEOIP_Path = "geoip/";
$GEOIP_Database_Path = "geoip/";
$PHP_Path = "/usr/bin/";
$TNS_Path = "/path/to/tns/install/";

$Cache_Expire_Time = 300;
$ColumnHeaderInterval = 20;

$ColumnList_ACTIVE_DEFAULT = array
(
	'CountryCode',
	'Bandwidth',
	'Uptime',
	'IP',
	'Hostname',
	'ORPort',
	'DirPort',
	'Authority',
	'Exit',
	'Fast',
	'Guard',
	'Named',
	'Stable',
	'Running',
	'Valid',
	'V2Dir'
);

$ColumnList_INACTIVE_DEFAULT = array
(
	'Fingerprint',
	'LastDescriptorPublished',
	'Platform',
	'Contact',
	'BadDir',
	'BadExit',
	'Hibernating'
);

$LocalTimeZone = "GMT";
$OffsetFromGMT = 0;

$DNSEL_Domain = null;
$Hidden_Service_URL = null;

$TorNetworkStatus_Version = "3.4.2";

?>
