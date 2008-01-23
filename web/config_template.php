<?php

// Copyright (c) 2006-2007, Joseph B. Kowalski
// See LICENSE for licensing information

// See README file for description of values listed here

// This config file utilizes folds.  For VIM, you may activate this using
// :set foldmethod=marker

$TorNetworkStatus_Version = "3.6.1";

// ++++++++++ Tor Connection ++++++++++ {{{

$LocalTorServerIP = "127.0.0.1";
$LocalTorServerControlPort = "9051";
$LocalTorServerPassword = null;

// }}}

// ++++++++++ Squid ++++++++++ {{{

$UsingSquid = 0;
$RealServerIP = "1.2.3.4";

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
$TNS_Path = "/my/path/to/tns";
// Uncomment the following line if you provide a WHOIS service
//define("WHOISPath","/cgi-bin/whois.pl?ip=");

// }}}

// ++++++++++ Mirrors ++++++++++ {{{
$myMirrorName = "MyMirrorName";
$mirrorList = '<a href="http://torstatus.blutmagie.de/" class="plain">blutmagie</a> | <a href="http://tns.hermetix.org/" class="plain">hermetix</a> | <a href="http://torstatus.kgprog.com/" class="plain">kgprog</a> | <a href="http://torstat.kleine-eismaus.de" class="plain">kleine-eismaus.de</a>';

// }}}

//  ++++++++++ Cache ++++++++++ {{{
$Cache_Expire_Time = 300;

// }}}

// ++++++++++ Interface ++++++++++ {{{
$footerText = "<b><a class='plain' href='/index.php'>Tor Network Status</a> v".$TorNetworkStatus_Version."<br/><a class='plain' href='/CHANGES' target='_new'>View Complete Change History</a><br/>Copyright &copy; 2006-2007, Joseph B. Kowalski<br/>Portions Copyright &copy; 2007, Kasimir Gabert<br/>Source code is available under <a class='plain' href='/LICENSE' target='_new'>BSD license</a> at <a class='plain' href='http://project.torstatus.kgprog.com/' target='_new'>project.torstatus.kgprog.com</a></b>";
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
	'Platform',
	'Hibernating'
);

$ColumnList_INACTIVE_DEFAULT = array
(
	'Fingerprint',
	'LastDescriptorPublished',
	'Contact',
	'BadDir',
	'BadExit'
);

// }}}

// ++++++++++ Other ++++++++++ {{{
$LocalTimeZone = "GMT";
$OffsetFromGMT = 0;

$DNSEL_Domain = null;
$Hidden_Service_URL = null;

// See if WHOIS wants the footer
if ($argv[1] == 'printthefooter')
{
	echo $footerText;
}

// }}}

?>
