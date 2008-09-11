<?php 

// Copyright (c) 2006-2007, Joseph B. Kowalski
// See LICENSE for licensing information 

// Start new session
session_start();

// Include configuration settings
include("config.php");

// Declare and initialize variables
$ActiveNetworkStatusTable = null;
$ActiveDescriptorTable = null;

$Name = null;
$IP = null;
$Hostname = null;
$ORPort = null;
$DirPort = null;
$Fingerprint = null;
$Platform = null;
$LastDescriptorPublished = null;
$Uptime = null;
$Bandwidth_MAX = null;
$Bandwidth_BURST = null;
$Bandwidth_OBSERVED = null;
$OnionKey = null;
$SigningKey = null;
$Contact = null;
$ExitPolicy_DATA_ARRAY = null;
$Family_DATA_ARRAY = null;
$FAuthority = null;
$FBadDirectory = null;
$FBadExit = null;
$FExit = null;
$FFast = null;
$FGuard = null;
$FHibernating = null;
$FNamed = null;
$FStable = null;
$FRunning = null;
$FValid = null;
$FV2Dir = null;
$FHSDir = null;
$CountryCode = null;

// Read in submitted variables
if (isset($_GET["FP"]))
{
	$Fingerprint = $_GET["FP"];
}

// Perform variable scrubbing
$Fingerprint = strip_tags($Fingerprint);
if (strlen($Fingerprint) != 40)
{
	$Fingerprint = null;
}

// Get active tables from database
$link = mysql_connect($SQL_Server, $SQL_User, $SQL_Pass) or die('Could not connect: ' . mysql_error());
mysql_select_db($SQL_Catalog) or die('Could not open specified database');

$query = "select ActiveNetworkStatusTable, ActiveDescriptorTable from Status";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$record = mysql_fetch_assoc($result);

$ActiveNetworkStatusTable = $record['ActiveNetworkStatusTable'];
$ActiveDescriptorTable = $record['ActiveDescriptorTable'];

// Populate variables from database
$query = "select $ActiveNetworkStatusTable.Name, $ActiveDescriptorTable.LastDescriptorPublished, $ActiveNetworkStatusTable.IP, $ActiveNetworkStatusTable.Hostname, $ActiveNetworkStatusTable.ORPort, $ActiveNetworkStatusTable.DirPort, $ActiveDescriptorTable.Platform, $ActiveDescriptorTable.Contact, CAST(((UNIX_TIMESTAMP() - (UNIX_TIMESTAMP($ActiveDescriptorTable.LastDescriptorPublished) + $OffsetFromGMT)) + $ActiveDescriptorTable.Uptime) AS SIGNED) as Uptime, $ActiveDescriptorTable.BandwidthMAX, $ActiveDescriptorTable.BandwidthBURST, $ActiveDescriptorTable.BandwidthOBSERVED, $ActiveDescriptorTable.OnionKey, $ActiveDescriptorTable.SigningKey, $ActiveDescriptorTable.WriteHistoryLAST, $ActiveDescriptorTable.WriteHistoryINC, $ActiveDescriptorTable.WriteHistorySERDATA, $ActiveDescriptorTable.ReadHistoryLAST, $ActiveDescriptorTable.ReadHistoryINC, $ActiveDescriptorTable.ReadHistorySERDATA, $ActiveDescriptorTable.ExitPolicySERDATA, $ActiveDescriptorTable.FamilySERDATA, $ActiveNetworkStatusTable.CountryCode, $ActiveDescriptorTable.Hibernating, $ActiveNetworkStatusTable.FAuthority, $ActiveNetworkStatusTable.FBadDirectory, $ActiveNetworkStatusTable.FBadExit, $ActiveNetworkStatusTable.FExit, $ActiveNetworkStatusTable.FFast, $ActiveNetworkStatusTable.FGuard, $ActiveNetworkStatusTable.FNamed, $ActiveNetworkStatusTable.FStable, $ActiveNetworkStatusTable.FRunning, $ActiveNetworkStatusTable.FValid, $ActiveNetworkStatusTable.FV2Dir, $ActiveNetworkStatusTable.FHSDir from $ActiveNetworkStatusTable inner join $ActiveDescriptorTable on $ActiveNetworkStatusTable.Fingerprint = $ActiveDescriptorTable.Fingerprint where $ActiveNetworkStatusTable.Fingerprint = '$Fingerprint'";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$record = mysql_fetch_assoc($result);

$Name = $record['Name'];
$LastDescriptorPublished = $record['LastDescriptorPublished'];
$IP = $record['IP'];
$Hostname = $record['Hostname'];
$ORPort = $record['ORPort'];
$DirPort = $record['DirPort'];
$Platform = $record['Platform'];
// Break the platform after 55 characters
if (strlen($Platform) > 55)
{
	$Platform = substr($Platform,0,55) . "<br/>" . substr($Platform,-(strlen($Platform)-55));
}

$image = "NotAvailable";
// Map the platform to something we know
if (strpos($record['Platform'],'Linux',$record['Platform']) || strpos($record['Platform'],'linux',$record['Platform']))
{
	$image = "Linux";
}
if (strpos($record['Platform'],'Windows XP'))
{
	$image = "WindowsXP";
}
else if (strpos($record['Platform'],'Windows') && strpos($record['Platform'],'server'))
{
	$image = "WindowsServer";
}
else if (strpos($record['Platform'],'Windows'))
{
	$image = "WindowsOther";
}
if (strpos($record['Platform'],'Darwin'))
{
	$image = "Darwin";
}
if (strpos($record['Platform'],'DragonFly'))
{
	$image = "DragonFly";
}
if (strpos($record['Platform'],'FreeBSD'))
{
	$image = "FreeBSD";
}
if (strpos($record['Platform'],'NetBSD'))
{
	$image = "NetBSD";
}
if (strpos($record['Platform'],'IRIX'))
{
	$image = "IRIX64";
}
if (strpos($record['Platform'],'Cygwin'))
{
	$image = "Cygwin";
}
if (strpos($record['Platform'],'SunOS'))
{
	$image = "SunOS";
}
if (strpos($record['Platform'],'OpenBSD'))
{
	$image = "OpenBSD";
}

$Contact = $record['Contact'];
$Uptime = $record['Uptime'];
$Bandwidth_MAX = $record['BandwidthMAX'];
$Bandwidth_BURST = $record['BandwidthBURST'];
$Bandwidth_OBSERVED = $record['BandwidthOBSERVED'];
$OnionKey = $record['OnionKey'];
$SigningKey = $record['SigningKey'];
$ExitPolicy_DATA_ARRAY = unserialize($record['ExitPolicySERDATA']);
$Family_DATA_ARRAY = unserialize($record['FamilySERDATA']);
$CountryCode = $record['CountryCode'];
$FAuthority = $record['FAuthority'];
$FBadDirectory = $record['FBadDirectory'];
$FBadExit = $record['FBadExit'];
$FExit = $record['FExit'];
$FFast = $record['FFast'];
$FGuard = $record['FGuard'];
$FHibernating = $record['Hibernating'];
$FNamed = $record['FNamed'];
$FStable = $record['FStable'];
$FRunning = $record['FRunning'];
$FValid = $record['FValid'];
$FV2Dir = $record['FV2Dir'];
$FHSDir = $record['FHSDir'];

// Register necessary variables in session

if (!isset($_SESSION['WriteHistory_DATA_ARRAY_SERIALIZED'])) 
{
	$_SESSION['WriteHistory_DATA_ARRAY_SERIALIZED'] = $record['WriteHistorySERDATA'];
} 
else
{
	unset($_SESSION['WriteHistory_DATA_ARRAY_SERIALIZED']);
	$_SESSION['WriteHistory_DATA_ARRAY_SERIALIZED'] = $record['WriteHistorySERDATA'];
}

if (!isset($_SESSION['WriteHistory_INC'])) 
{
	$_SESSION['WriteHistory_INC'] = $record['WriteHistoryINC'];
} 
else
{
	unset($_SESSION['WriteHistory_INC']);
	$_SESSION['WriteHistory_INC'] = $record['WriteHistoryINC'];
}
if (!isset($_SESSION['WriteHistory_LAST'])) 
{
	$_SESSION['WriteHistory_LAST'] = $record['WriteHistoryLAST'];
} 
else
{
	unset($_SESSION['WriteHistory_LAST']);
	$_SESSION['WriteHistory_LAST'] = $record['WriteHistoryLAST'];
}

// Do the same for the read history
if (!isset($_SESSION['ReadHistory_DATA_ARRAY_SERIALIZED'])) 
{
	$_SESSION['ReadHistory_DATA_ARRAY_SERIALIZED'] = $record['ReadHistorySERDATA'];
} 
else
{
	unset($_SESSION['ReadHistory_DATA_ARRAY_SERIALIZED']);
	$_SESSION['ReadHistory_DATA_ARRAY_SERIALIZED'] = $record['ReadHistorySERDATA'];
}
if (!isset($_SESSION['ReadHistory_INC'])) 
{
	$_SESSION['ReadHistory_INC'] = $record['ReadHistoryINC'];
} 
else
{
	unset($_SESSION['ReadHistory_INC']);
	$_SESSION['ReadHistory_INC'] = $record['ReadHistoryINC'];
}
if (!isset($_SESSION['ReadHistory_LAST'])) 
{
	$_SESSION['ReadHistory_LAST'] = $record['ReadHistoryLAST'];
} 
else
{
	unset($_SESSION['ReadHistory_LAST']);
	$_SESSION['ReadHistory_LAST'] = $record['ReadHistoryLAST'];
}

// Save the bandwidth value
if (!isset($_SESSION['ObservedBandwidth']))
{
	$_SESSION['ObservedBandwidth'] = $Bandwidth_OBSERVED;
}
else
{
	unset($_SESSION['ObservedBandwidth']);
	$_SESSION['ObservedBandwidth'] = $Bandwidth_OBSERVED;
}

// Handle no descriptor available situation
if ($Name == null)
{
	$pageTitle = "Router Detail";
	include("header.php");
	echo "<table width='70%' cellspacing='2' cellpadding='2' border='0' align='center'>\n";
	echo "<tr>\n";
	echo "<td class='TRSC'><br/><b>ERROR -- No Descriptor Available</b><br/><br/></td>\n";
	echo "</tr>\n";
	echo "</table>\n";
	echo "</body>\n";
	echo "</html>\n";

	// Close connection
	mysql_close($link);

	exit;
}

$pageTitle = "Router Detail";
include("header.php");

?>

<table width='100%' cellspacing='2' cellpadding='2'>
<tr>
<td>

<table class="displayTable" cellspacing="0" cellpadding="0" width='100%' align='center'>
<tr>
<td class='HRN' colspan='2'>Router Information</td>
<td class='HRN' style='border-left-color: #000072; border-left-style: solid; border-left-width: 1px;'>Router Flags</td>
</tr>
<tr>
<td class="TRS" colspan='2' style="vertical-align: top;">
<table>
<?php

	// Display router name
	echo "<tr>\n";
	echo "<td class='TRAR'><b>Router Name:</b></td>\n";
	echo "<td class='TRSB'>$Name</td>\n";
	echo "</tr>\n";

	// Display router Fingerprint
	echo "<tr>\n";
	echo "<td class='TRAR'><b>Fingerprint:</b></td>\n";
	echo "<td class='TRSB'>" . chunk_split(strtoupper($Fingerprint), 4, " ") . "</td>\n";
	echo "</tr>\n";

	// Display router Contact
	echo "<tr>\n";
	echo "<td class='TRAR'><b>Contact:</b></td>\n";
	echo "<td class='TRSB'>"; if($Contact == null){echo "None Given";} else{$Contact = htmlspecialchars($Contact, ENT_QUOTES); echo "$Contact";} echo "</td>\n";
	echo "</tr>\n";

	// Display router IP
	echo "<tr>\n";
	echo "<td class='TRAR'><b>IP Address:</b></td>\n";
	echo "<td class='TRSB'>";
	if (defined("WHOISPath"))
	{
		echo "<a class='who' href='".WHOISPath.$IP."'>".$IP."</a>";
	}
	else
	{
		echo $IP;
	}
	echo "</td>\n";
	echo "</tr>\n";

	// Display router Hostname
	echo "<tr>\n";
	echo "<td class='TRAR'><b>Hostname:</b></td>\n";
	echo "<td class='TRSB'>"; if($Hostname == $IP){echo "Unavailable";} else{echo "$Hostname";} echo "</td>\n";
	echo "</tr>\n";

	// Display ORPort
	echo "<tr>\n";
	echo "<td class='TRAR'><b>Onion Router Port:</b></td>\n";
	echo "<td class='TRSB'>$ORPort</td>\n";
	echo "</tr>\n";

	// Display DirPort
	echo "<tr>\n";
	echo "<td class='TRAR'><b>Directory Server Port:</b></td>\n";
	echo "<td class='TRSB'>"; if($DirPort == 0){echo "None";} else{echo "$DirPort";} echo "</td>\n";
	echo "</tr>\n";

	// Display CountryCode
	echo "<tr>\n";
	echo "<td class='TRAR'><b>Country Code:</b></td>\n";
	echo "<td class='TRSB'>"; if($CountryCode == null){echo "Unknown";} else{echo "$CountryCode";} echo "</td>\n";
	echo "</tr>\n";

	// Display Platform
	echo "<tr>\n";
	echo "<td class='TRAR'><b>Platform / Version:</b></td>\n";
	echo "<td class='TRSB'>$Platform <img src='img/os-icons/$image.png' alt='$Platform' /></td>\n";
	echo "</tr>\n";

	// Display LastDescriptorPublished
	echo "<tr>\n";
	echo "<td class='TRAR'><b>Last Descriptor Published (GMT):</b></td>\n";
	echo "<td class='TRSB'>$LastDescriptorPublished</td>\n";
	echo "</tr>\n";

	if ($Uptime > -1)
	{
		// Display Current Uptime
		$days = floor($Uptime/86400);
		$Uptime = $Uptime - ($days*86400);
		$hours = floor($Uptime/3600);
		$Uptime = $Uptime - ($hours*3600);
		$minutes = floor($Uptime/60);
		$Uptime = $Uptime - ($minutes*60);
		$seconds = $Uptime;

		echo "<tr>\n";
		echo "<td class='TRAR'><b>Current Uptime:</b></td>\n";
		echo "<td class='TRSB'>$days Day(s), $hours Hour(s), $minutes Minute(s), $seconds Second(s)</td>\n";
		echo "</tr>\n";
	}
	else
	{
		echo "<tr>\n";
		echo "<td class='TRAR'><b>Current Uptime:</b></td>\n";
		echo "<td class='TRSB'>Not Available</td>\n";
		echo "</tr>\n";
	}

	// Display Bandwidth stats
	echo "<tr>\n";
	echo "<td class='TRAR'><b>Bandwidth (Max/Burst/Observed - In Bps):</b></td>\n";
	echo "<td class='TRSB'>$Bandwidth_MAX&nbsp;/&nbsp;$Bandwidth_BURST&nbsp;/&nbsp;$Bandwidth_OBSERVED (In Kbps: ".round($Bandwidth_MAX/1024,2)." / ".round($Bandwidth_BURST/1024,2)." / ".round($Bandwidth_OBSERVED/1024,2).")</td>\n";
	echo "</tr>\n";

	// Display Family info
	echo "<tr>\n";
	echo "<td class='TRAR'><b>Family:</b></td>\n";
	echo "<td class='TRSB'>";
	if ($Family_DATA_ARRAY == null) {echo "No Info Given";}
	else
	{
		foreach ($Family_DATA_ARRAY as $FamilyMember)
		{
			// Link to the routers in the family, as well as
			// provide names for fingerprints
			if (substr($FamilyMember,0,1) == "$" && strlen($FamilyMember) == 41)
			{
				// It can be assumed to be a fingerprint
				// The name and countrycode should be found
				$fplink = strtolower(substr($FamilyMember,1));
				$query = "SELECT `CountryCode`, `Name` from `$ActiveNetworkStatusTable` WHERE `Fingerprint` LIKE '$fplink'";
				$result = mysql_query($query) or die('Query failed: ' . mysql_error());
				if (mysql_num_rows($result) == 1)
				{
					$record = mysql_fetch_assoc($result);
					// Display in the form
					//  [linked][countrycode] Name
					echo "<img title=\"FP: $fplink\" src=\"img/flags/".strtolower($record['CountryCode']).".gif\" class=\"flag\" /> <a title=\"FP: $fplink\" href=\"router_detail.php?FP=$fplink\">".$record['Name']."</a><br/>";
				}
				else
				{
					// The router was not found
					// Display in the form
					//  Fingerprint
					echo "<img title=\"Unknown router\" src=\"/img/routerdown.png\" alt=\"Unknown Router\"/> $FamilyMember<br/>";
				}
			}
			else
			{
				// It can be assumed to be a name
				// The countrycode and fingerprint are needed
				// - Test to make sure that there is only one
				//   router with the same name
				$query = "SELECT `CountryCode`, `Fingerprint` from `$ActiveNetworkStatusTable` WHERE `Name` LIKE '$FamilyMember'";
				$result = mysql_query($query) or die('Query failed: ' . mysql_error());
				if (mysql_num_rows($result) == 1)
				{
					$record = mysql_fetch_assoc($result);
					$fplink = strtolower($record['Fingerprint']);
					// Display in the form
					//  [linked][countrycode] Name
					echo "<img title=\"FP: $fplink\" src=\"img/flags/".strtolower($record['CountryCode']).".gif\" class=\"flag\" /> <a title=\"FP: $fplink\" href=\"router_detail.php?FP=$fplink\">$FamilyMember</a><br/>";
				}
				else
				{
					// Unfortunately, the name is 
					// meaningless
					// Display in the form
					//  Name
					echo "<img title=\"Unknown router\" src=\"/img/routerdown.png\" alt=\"Unknown Router\"/> $FamilyMember<br/>";
				}

			}
		}
	}
	echo "</td>\n";
	echo "</tr>\n";

?>
</table>

</td>

<td class='TRS' style='padding: 10px; border-left-color: #59990e; border-left-style: solid; border-left-width: 1px; vertical-align: top;'>
<table cellspacing='0' cellpadding='0'>
<?php

	echo "<tr class='nr'>\n";
	echo "<td class='TRAR'><b>Running:</b></td>\n";
	echo "<td class='F$FRunning'>";
	echo "</td>\n";
	echo "</tr>\n";

	echo "<tr class='nr'>\n";
	echo "<td class='TRAR'><b>Valid:</b></td>\n";
	echo "<td class='F$FValid'>";
	echo "</td>\n";
	echo "</tr>\n";

	echo "<tr class='nr'>\n";
	echo "<td class='TRAR'><b>Fast:</b></td>\n";
	echo "<td class='F$FFast'>";
	echo "</td>\n";
	echo "</tr>\n";

	echo "<tr class='nr'>\n";
	echo "<td class='TRAR'><b>Exit:</b></td>\n";
	echo "<td class='F$FExit'>";
	echo "</td>\n";
	echo "</tr>\n";

	echo "<tr class='nr'>\n";
	echo "<td class='TRAR'><b>Named:</b></td>\n";
	echo "<td class='F$FNamed'>";
	echo "</td>\n";
	echo "</tr>\n";

	echo "<tr class='nr'>\n";
	echo "<td class='TRAR'><b>Stable:</b></td>\n";
	echo "<td class='F$FStable'>";
	echo "</td>\n";
	echo "</tr>\n";

	echo "<tr class='nr'>\n";
	echo "<td class='TRAR'><b>Guard:</b></td>\n";
	echo "<td class='F$FGuard'>";
	echo "</td>\n";
	echo "</tr>\n";

	echo "<tr class='nr'>\n";
	echo "<td class='TRAR'><b>Hibernating:</b></td>\n";
	echo "<td class='F$FHibernating'>";
	echo "</td>\n";
	echo "</tr>\n";

	echo "<tr class='nr'>\n";
	echo "<td class='TRAR'><b>Bad Exit:</b></td>\n";
	echo "<td class='bad$FBadExit'>";
	echo "</td>\n";
	echo "</tr>\n";

	echo "<tr class='nr'><td colspan='2' style='background-color: #59990E; height: 1px;'></td></tr>";

	echo "<tr class='nr'>\n";
	echo "<td class='TRAR'><b>Directory (v2):</b></td>\n";
	echo "<td class='F$FV2Dir'>";
	echo "</td>\n";
	echo "</tr>\n";

	echo "<tr class='nr'>\n";
	echo "<td class='TRAR'><b>HSDir:</b></td>\n";
	echo "<td class='F$FHSDir'>";
	echo "</td>\n";
	echo "</tr>\n";

	echo "<tr class='nr'>\n";
	echo "<td class='TRAR'><b>Authority:</b></td>\n";
	echo "<td class='F$FAuthority'>";
	echo "</td>\n";
	echo "</tr>\n";

	echo "<tr class='nr'>\n";
	echo "<td class='TRAR'><b>Bad Directory:</b></td>\n";
	echo "<td class='bad$FBadDirectory'>";
	echo "</td>\n";
	echo "</tr>\n";

?>
</table>
</td>

</tr>
<tr>
<td class='HRN' colspan='2'>Bandwidth</td>
<td class='HRN' style='border-left-color: #000072; border-left-style: solid; border-left-width: 1px;'>Exit Policy Information</td>
</tr>
<tr>
<td class='TRS' style="text-align: center;">
<div style="text-align: left;">
<?php
if ($_GET['showbandwidth'] == "true")
{
	// Print the bandwidth
	echo "Write history bandwidth (in bytes per second):<br/>";
	foreach (unserialize($record['WriteHistorySERDATA']) as $bwvalue)
	{
		echo "$bwvalue<br/>";
	}
	echo "Ending at " . $record['WriteHistoryLAST'] . " with " . $record['WriteHistoryINC'] . " second intervals.";
}
else
{
	?><a href="?FP=<?php echo $Fingerprint; ?>&amp;showbandwidth=true">(show bandwidth values)</a><?php
}
?>
</div>
<?php if ($usePerlGraphs == 1) { ?>
<img src="/cgi-bin/perlgraph/plot.pl?plottype=rtw" alt="Write History" /><br/>
<?php } else { ?>
<img src='bandwidth_history_graph.php?MODE=WriteHistory' />
<?php } ?>
</td>
<td class='TRSB' style="text-align: center;">
<div style="text-align: left;">
<?php
if ($_GET['showbandwidth'] == "true")
{
	// Print the bandwidth
	echo "Read history bandwidth (in bytes per second):<br/>";
	foreach (unserialize($record['ReadHistorySERDATA']) as $bwvalue)
	{
		echo "$bwvalue<br/>";
	}
	echo "Ending at " . $record['ReadHistoryLAST'] . " with " . $record['ReadHistoryINC'] . " second intervals.";
}
else
{
	?>&nbsp;<?php
}
?>
</div>
<?php if ($usePerlGraphs == 1) { ?>
<img src="/cgi-bin/perlgraph/plot.pl?plottype=rtr" alt="Read History" /><br/>
<?php } else { ?>
<img src='bandwidth_history_graph.php?MODE=ReadHistory' />
<?php } ?>
</td>

<td class='TRS' style='padding: 10px; border-left-color: #59990e; border-left-style: solid; border-left-width: 1px; vertical-align: top;'><b>
<?php
	

	for ($i=0 ; $i<count($ExitPolicy_DATA_ARRAY) ; $i++)
	{
		echo "$ExitPolicy_DATA_ARRAY[$i]<br/>\n";
	}

	echo "<br/>\n";
?>
</b>
</td>


</tr>

<tr>
<td class='HRN' colspan='3'><? if ($BandwidthHistory == "true") { echo "Bandwidth History / "; } ?>Router Keys</td>
</tr>
<tr>
<td class='TRS' colspan='3'>
<?php
	
	echo "<br/>\n";
	if ($BandwidthHistory == "true")
	{
		if ($UsingSSL == 1)
		{
			$BandwidthURL = $SSLBandwidthURL;
		}
	?>
	<table class="bwhistory">
		<tr>
			<td>
			<img src="<?php echo $BandwidthURL . strtoupper($Fingerprint) . "_d.png"; ?>" alt="Past Day's Bandwidth"/>
			</td>
			<td>
			<img src="<?php echo $BandwidthURL . strtoupper($Fingerprint) . "_w.png"; ?>" alt="Past Week's Bandwidth"/>
			</td>
		</tr>
		<tr>
			<td>
			<img src="<?php echo $BandwidthURL . strtoupper($Fingerprint) . "_m.png"; ?>" alt="Past Month's Bandwidth"/>
			</td>
			<td>
			<img src="<?php echo $BandwidthURL . strtoupper($Fingerprint) . "_3m.png"; ?>" alt="Past Three Month's Bandwidth"/>
			</td>
		</tr>
		<tr>
			<td>
			<img src="<?php echo $BandwidthURL . strtoupper($Fingerprint) . "_y.png"; ?>" alt="Past Year's Bandwidth"/>
			</td>
			<td>
			</td>
		</tr>
	</table>
	<br/>
	<?php
	}
	echo "<b>Signing Key:</b><pre>" . $SigningKey . "</pre>";
	echo "<b>Onion Key:</b><pre>" . $OnionKey . "</pre>\n";
	echo "<br/>\n";

?>
</td>
</tr>
</table>

</td>
</tr>
</table>


<br/>

<table width='70%' cellspacing='2' cellpadding='2' border='0' align='center'>
<tr>
<td class='TRC'><?php echo $footerText; ?></td>
</tr>
</table>
</div>
</body>
</html>

<?php

// Close connection
mysql_close($link);

?>
