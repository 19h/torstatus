<?php

// Copyright (c) 2006-2007, Joseph B. Kowalski
// See LICENSE for licensing information

// See README file for description of values listed here

// This config file utilizes folds.  For VIM, you may activate this using
// :set foldmethod=marker

$TorNetworkStatus_Version = "4.0trunk";

// ++++++++++ Tor Connection ++++++++++ {{{

$LocalTorServerIP = "127.0.0.1";
$LocalTorServerControlPort = "9051";
$LocalTorServerPassword = null;

// }}}

// ++++++++++ Squid and SSL ++++++++++ {{{

$UsingSquid = 0;
$RealServerIP = "1.2.3.4";
$DetermineUsingSSL = 1; // Set this to 0 if you do not want to try to 
                        // detect whether or not SSL is being used
$UsingSSL = 0;
$SSLUsingSquid = 0;
$AllowSSL = 0;
$SSLLink = "https://ssl.enabled.site.url/";

// }}}

// ++++++++++ Database ++++++++++ {{{

$SQL_Server = "localhost";
$SQL_User = "TorNetworkStatus";
$SQL_Pass = "PASSWORD";
$SQL_Catalog = "TorNetworkStatus";

// }}}

// ++++++++++ Paths ++++++++++ {{{
$JPGraph_Path = "jpgraph/";
$GEOIP_Path = "geoip/";
$GEOIP_Database_Path = "geoip/";
$PHP_Path = "/usr/bin/";
$TNS_Path = "/home/torstatus-kgprog-com/project/trunk/";
// Comment the following line if you do not provide a WHOIS service
define("WHOISPath","/whois.php?ip=");
// If you want to provide a bandwidth history, uncomment the following line
//$BandwidthHistory = "true";

// }}}

// ++++++++++ Mirrors ++++++++++ {{{
$myMirrorName = "MyMirrorName";
// Optionaly, if your mirror is not named, you might want to provide a
// fingerprint here
// $SourceFingerprint = "optionalfingerprint";
// Change this value to 0 if you do not wish to download the mirror list
$useMirrorList = 1;
$mirrorListURI = "http://trunk.torstatus.kgprog.com/currentmirrors.php";
$manualMirrorList = array('all.de' => 'http://torstatus.all.de/','blutmagie' => 'http://torstatus.blutmagie.de/','kgprog' => 'http://torstatus.kgprog.com','Kradense' => 'http://kradense.whsites.net/tns/', 'cyberphunk' => 'http://torstatus.cyberphunk.org/');

// }}}

//  ++++++++++ Cache ++++++++++ {{{
$Cache_Expire_Time = 300;

// }}}

// ++++++++++ Interface ++++++++++ {{{

// Set this to 0 if you wish to use JPGraph's libraries
$usePerlGraphs = 1;

$footerText = "<b><a class='plainbox' href='/CHANGES' target='_new'>View Complete Change History</a><br/>Source code is available under <a class='plainbox' href='/LICENSE' target='_new'>BSD license</a> at <a class='plainbox' href='http://project.torstatus.kgprog.com/' target='_new'>project.torstatus.kgprog.com</a></b>";
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
	'V2Dir',
	'HSDir',
	'Platform',
	'Hibernating',
	'BadDir',
	'BadExit'
);

$ColumnList_INACTIVE_DEFAULT = array
(
	'Fingerprint',
	'LastDescriptorPublished',
	'Contact'
);

// If you wish to include a web banner, uncomment the following lines
//$BannerHTML = "Your banner here.";
//$BannerHeight = "50px";
//$BannerWidth = "400px";

// }}}

// ++++++++++ Other ++++++++++ {{{
$LocalTimeZone = "GMT";
$OffsetFromGMT = 0;

$DNSEL_Domain = null;
$Hidden_Service_URL = null;

$FlagOrder = "Authority,BadDirectory,BadExit,Exit,Fast,Fast,Named,Stable,Stable,Running,Valid,V2Dir,HSDir";

// }}}

?>
