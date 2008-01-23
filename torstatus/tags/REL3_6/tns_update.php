<?php 

// Copyright (c) 2006-2007, Joseph B. Kowalski
// See LICENSE for licensing information 

// Include configuration settings
include("web/config.php");

// Include GEOIP files
include($GEOIP_Path . "geoip.inc");   

// Declare and initialize variables
$StartTime = null;
$EndTime = null;

$FileHandle = null;
$TorCommandString = null;
$LineBuffer = null;

$Name = null;

$NetworkStatusArray = null;
$DescriptorArray = null;

$UpdateNetworkStatusTable = null;
$UpdateDescriptorTable = null;

$RouterCount = 0; 

// Record update start point
$StartTime = time();

// Connect to database, select schema
$link = mysql_connect($SQL_Server, $SQL_User, $SQL_Pass) or die('Could not connect: ' . mysql_error());
mysql_select_db($SQL_Catalog) or die('Could not open specified database');

// Verify necessary DB record exists in Status table
$query = "select count(*) as Count from Status";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$record = mysql_fetch_assoc($result);

if($record['Count'] < 1)
{
	$query = "INSERT INTO Status (LastUpdate,LastUpdateElapsed,ActiveNetworkStatusTable,ActiveDescriptorTable) VALUES ('2000-01-01 00:00:00',NULL,NULL,NULL)";
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
}

// Verify necessary DB record exists in NetworkStatusSource table
$query = "select count(*) as Count from NetworkStatusSource";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$record = mysql_fetch_assoc($result);

if($record['Count'] < 1)
{
	$query = "INSERT INTO NetworkStatusSource (Fingerprint,Name,LastDescriptorPublished,IP,ORPort,DirPort,Platform,Contact,Uptime,BandwidthMAX,BandwidthBURST,BandwidthOBSERVED,OnionKey,SigningKey,WriteHistoryLAST,WriteHistoryINC,WriteHistorySERDATA,ReadHistoryLAST,ReadHistoryINC,ReadHistorySERDATA,ExitPolicySERDATA,FamilySERDATA,Hibernating,DescriptorSignature) VALUES (NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL)";
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
}

// Determine which tables to update in this cycle
$query = "select ActiveNetworkStatusTable, ActiveDescriptorTable from Status where ID = 1";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$record = mysql_fetch_assoc($result);

if($record['ActiveNetworkStatusTable'] == 'NetworkStatus1' && $record['ActiveDescriptorTable'] == 'Descriptor1')
{
	$UpdateNetworkStatusTable = 'NetworkStatus2';
	$UpdateDescriptorTable = 'Descriptor2';
}
else if ($record['ActiveNetworkStatusTable'] == 'NetworkStatus2' && $record['ActiveDescriptorTable'] == 'Descriptor2')
{
	$UpdateNetworkStatusTable = 'NetworkStatus1';
	$UpdateDescriptorTable = 'Descriptor1';
}
else
{
	$UpdateNetworkStatusTable = 'NetworkStatus1';
	$UpdateDescriptorTable = 'Descriptor1';
}

// Open connection to Tor server
$FileHandle = fsockopen($LocalTorServerIP, $LocalTorServerControlPort);
if ($FileHandle) 
{
	// Perform authentication with Tor server
	if ($LocalTorServerPassword != null)
	{
		$TorCommandString = "AUTHENTICATE \"$LocalTorServerPassword\" \r\n";
		fwrite($FileHandle, $TorCommandString);
	}
	else
	{
		$TorCommandString = "AUTHENTICATE \r\n";
		fwrite($FileHandle, $TorCommandString);
	}
	
	// Condition to exit if Tor server returned an error
	$LineBuffer = fgets($FileHandle);
	if (!(strpos($LineBuffer, "250 OK") === 0))
	{
		echo $LineBuffer;
		
		// Close connection
		mysql_close($link);

		// Close file handle
		fclose($FileHandle);

		exit();
	}

	// Clear out line buffer
	$LineBuffer = null;

	// Send request for list of descriptors
	$TorCommandString = "GETINFO desc/all-recent-extrainfo-hack \r\n";
	fwrite($FileHandle, $TorCommandString);
			
	$LineBuffer = fgets($FileHandle);
	if (strpos($LineBuffer, "552 Unrecognized key") === 0)
	{
		// Use the old method of gathering the info
		$TorCommandString = "GETINFO desc/all-recent \r\n";
		fwrite($FileHandle, $TorCommandString);
		$LineBuffer = fgets($FileHandle);
	}
	if (strpos($LineBuffer, "250+desc/all-recent") === 0)
	{
		// Clear out old records from active descriptor table
		$query = "truncate table $UpdateDescriptorTable";
		$result = mysql_query($query) or die('Query failed: ' . mysql_error());

		// Initialize DescriptorArray for first run
		$DescriptorArray = array(null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);

		while (!(strpos($LineBuffer, "250 OK") === 0))
		{
	       	// Get a line from file
			$LineBuffer = fgets($FileHandle);

			// "router" line
			if (strpos($LineBuffer, "router ") === 0)
			{
				$LineBuffer = substr($LineBuffer,7);
				$TempArray = explode(" ", $LineBuffer);
				
				// Name
				$DescriptorArray[0] = mysql_real_escape_string($TempArray[0]);

				// IP
				$DescriptorArray[1] = mysql_real_escape_string($TempArray[1]);

				// ORPort
				$DescriptorArray[2] = mysql_real_escape_string($TempArray[2]);

				// DirPort
				$DescriptorArray[3] = mysql_real_escape_string(rtrim($TempArray[4]));

				continue;
			}

			// "platform" line
			if (strpos($LineBuffer, "platform ") === 0)
			{
				$DescriptorArray[4] = mysql_real_escape_string(rtrim(substr($LineBuffer,9)));

				continue;
			}

			// "published" line
			if (strpos($LineBuffer, "published ") === 0)
			{
				$DescriptorArray[5] = mysql_real_escape_string(rtrim(substr($LineBuffer,10)));

				continue;
			}

			// "opt fingerprint" line
			if (strpos($LineBuffer, "opt fingerprint ") === 0)
			{
				$DescriptorArray[6] = mysql_real_escape_string(str_replace(" ","",rtrim(substr($LineBuffer,16))));

				continue;
			}

			// "uptime" line
			if ((strpos($LineBuffer, "uptime ") === 0) || (strpos($LineBuffer, "opt uptime ") === 0))
			{
				if (strpos($LineBuffer, "uptime ") === 0)
				{
					$DescriptorArray[7] = mysql_real_escape_string(rtrim(substr($LineBuffer,7)));
							
					continue;
				}
				else if (strpos($LineBuffer, "opt uptime ") === 0)
				{
					$DescriptorArray[7] = mysql_real_escape_string(rtrim(substr($LineBuffer,11)));
							
					continue;
				}
			}

			// "bandwidth" line
			if (strpos($LineBuffer, "bandwidth ") === 0)
			{
				$LineBuffer = substr($LineBuffer,10);
				$TempArray = explode(" ", $LineBuffer);
	
				//Max
				$DescriptorArray[8] = mysql_real_escape_string($TempArray[0]);

				//Burst
				$DescriptorArray[9] = mysql_real_escape_string($TempArray[1]);

				//Observed
				$DescriptorArray[10] = mysql_real_escape_string(rtrim($TempArray[2]));
	
				continue;
			}
	
			// "onion-key" line
			if (strpos($LineBuffer, "onion-key") === 0)
			{
				$LineBuffer = fgets($FileHandle);
				$DescriptorArray[11] = $LineBuffer;
								
				while(!(strpos($LineBuffer, "-----END RSA PUBLIC KEY-----") === 0))
				{
					$LineBuffer = fgets($FileHandle);
					$DescriptorArray[11] = $DescriptorArray[11] . $LineBuffer;
				}
				$DescriptorArray[11] = mysql_real_escape_string(rtrim($DescriptorArray[11]));
	
				continue;	
			}
	
			// "signing-key" line
			if (strpos($LineBuffer, "signing-key") === 0)
			{
				$LineBuffer = fgets($FileHandle);
				$DescriptorArray[12] = $LineBuffer;
								
				while(!(strpos($LineBuffer, "-----END RSA PUBLIC KEY-----") === 0))
				{
					$LineBuffer = fgets($FileHandle);
					$DescriptorArray[12] = $DescriptorArray[12] . $LineBuffer;
				}
				$DescriptorArray[12] = mysql_real_escape_string(rtrim($DescriptorArray[12]));

				continue;	
			}

			// "opt hibernating" line
			if (strpos($LineBuffer, "opt hibernating ") === 0)
			{
				$DescriptorArray[13] = mysql_real_escape_string(rtrim(substr($LineBuffer,16)));

				continue;
			}
	
			// "contact" line
			if (strpos($LineBuffer, "contact ") === 0)
			{
				$DescriptorArray[14] = mysql_real_escape_string(rtrim(substr($LineBuffer,8)));
	
				continue;
			}

			// "opt write-history" line
			if (strpos($LineBuffer, "opt write-history ") === 0)
			{
				$LineBuffer = substr($LineBuffer,18);

				// Check for routers that publish broken bandwidth history descriptors
				if (strpos($LineBuffer, " ") === 0)
				{
					$DescriptorArray[15] = null;
					$DescriptorArray[16] = 0;
					$DescriptorArray[17] = null;
					
					continue;
				}
						
				$TempArray = explode(" ", $LineBuffer);
	
				//Last
				$DescriptorArray[15] = mysql_real_escape_string($TempArray[0] . " " . $TempArray[1]);

				//Inc
				$DescriptorArray[16] = mysql_real_escape_string(substr($TempArray[2],1));	

				//Serialized data array
				$TempArray[4] = rtrim($TempArray[4]);
				$TempArray[4] = mysql_real_escape_string($TempArray[4]);
				$DescriptorArray[17] = serialize(explode(",", $TempArray[4]));

				continue;
			}

			// "opt read-history" line
			if (strpos($LineBuffer, "opt read-history ") === 0)
			{
				$LineBuffer = substr($LineBuffer,17);

				// Check for routers that publish broken bandwidth history descriptors
				if (strpos($LineBuffer, " ") === 0)
				{
					$DescriptorArray[18] = null;
					$DescriptorArray[19] = 0;
					$DescriptorArray[20] = null;
					
					continue;
				}

				$TempArray = explode(" ", $LineBuffer);

				//Last
				$DescriptorArray[18] = mysql_real_escape_string($TempArray[0] . " " . $TempArray[1]);

				//Inc
				$DescriptorArray[19] = mysql_real_escape_string(substr($TempArray[2],1));

				//Serialized data array
				$TempArray[4] = rtrim($TempArray[4]);
				$TempArray[4] = mysql_real_escape_string($TempArray[4]);
				$DescriptorArray[20] = serialize(explode(",", $TempArray[4]));

				continue;
			}

			// "family" line
			if (strpos($LineBuffer, "family ") === 0)
			{
				$LineBuffer = substr($LineBuffer,7);
				$Family_DATA_ARRAY = explode(" ", mysql_real_escape_string(rtrim($LineBuffer)));

				//Serialized family data array
				$DescriptorArray[21] = serialize($Family_DATA_ARRAY);

				continue;
			}

			// "reject" or "accept" lines (Exit Policy), "router-signature" line, insert descriptor record into database
			if ((strpos($LineBuffer, "reject ") === 0) || (strpos($LineBuffer, "accept ") === 0))
			{				
				$ExitPolicy_DATA_ARRAY = null;
				$ExitPolicy_DATA_ARRAY_COUNTER = 0;
						
				while((strpos($LineBuffer, "reject ") === 0) || (strpos($LineBuffer, "accept ") === 0))
				{
					$ExitPolicy_DATA_ARRAY[$ExitPolicy_DATA_ARRAY_COUNTER] = mysql_real_escape_string(rtrim($LineBuffer));
					$ExitPolicy_DATA_ARRAY_COUNTER++;
					$LineBuffer = fgets($FileHandle);
				}

				//Serialized exit policy data array
				$DescriptorArray[22] = serialize($ExitPolicy_DATA_ARRAY);

				// "router-signature" line
				if (strpos($LineBuffer, "router-signature") === 0)
				{
					$LineBuffer = fgets($FileHandle);
					$DescriptorArray[23] = $LineBuffer;
							
					while(!(strpos($LineBuffer, "-----END SIGNATURE-----") === 0))
					{
						$LineBuffer = fgets($FileHandle);
						$DescriptorArray[23] = $DescriptorArray[23] . $LineBuffer;
					}
					$DescriptorArray[23] = mysql_real_escape_string(rtrim($DescriptorArray[23]));
				}
				
				// Insert descriptor record into database
				$query = "insert into $UpdateDescriptorTable (Name, IP, ORPort, DirPort, Platform, LastDescriptorPublished, Fingerprint, Uptime, BandwidthMAX, BandwidthBURST, BandwidthOBSERVED, OnionKey, SigningKey, Hibernating, Contact, WriteHistoryLAST, WriteHistoryINC, WriteHistorySERDATA, ReadHistoryLAST, ReadHistoryINC, ReadHistorySERDATA, FamilySERDATA, ExitPolicySERDATA, DescriptorSignature) values ('$DescriptorArray[0]','$DescriptorArray[1]',$DescriptorArray[2],$DescriptorArray[3],'$DescriptorArray[4]','$DescriptorArray[5]','$DescriptorArray[6]',$DescriptorArray[7],$DescriptorArray[8],$DescriptorArray[9],$DescriptorArray[10],'$DescriptorArray[11]','$DescriptorArray[12]','$DescriptorArray[13]','$DescriptorArray[14]','$DescriptorArray[15]',$DescriptorArray[16],'$DescriptorArray[17]','$DescriptorArray[18]',$DescriptorArray[19],'$DescriptorArray[20]','$DescriptorArray[21]','$DescriptorArray[22]','$DescriptorArray[23]')";

				$result = mysql_query($query) or die('Query failed: ' . mysql_error()); 

				// Clear out DescriptorArray for next run
				$DescriptorArray = array(null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);

				// Handle "router" line again explicitly here, since it was advanced to by end of "router-signature" process block
				if (strpos($LineBuffer, "router ") === 0)
				{
					$LineBuffer = substr($LineBuffer,7);
					$TempArray = explode(" ", $LineBuffer);
				
					// Name
					$DescriptorArray[0] = mysql_real_escape_string($TempArray[0]);

					// IP
					$DescriptorArray[1] = mysql_real_escape_string($TempArray[1]);

					// ORPort
					$DescriptorArray[2] = mysql_real_escape_string($TempArray[2]);

					// DirPort
					$DescriptorArray[3] = mysql_real_escape_string(rtrim($TempArray[4]));

					continue;
				}
			}
		}
	}
	else
	{
		echo $LineBuffer;
		
		// Close connection
		mysql_close($link);

		// Close file handle
		fclose($FileHandle);

		exit();
	}

	// Clear out line buffer
	$LineBuffer = null;

	// Send request for directory status
	$TorCommandString = "GETINFO ns/all \r\n";
	fwrite($FileHandle, $TorCommandString);

	$LineBuffer = fgets($FileHandle);
	if (strpos($LineBuffer, "250+ns/all=") === 0)
	{
		// Clear out old records from active network status table in database
		$query = "truncate table $UpdateNetworkStatusTable";
		$result = mysql_query($query) or die('Query failed: ' . mysql_error());

		while (!(strpos($LineBuffer, "250 OK") === 0)) 
		{
 			// Get a line from file
			$LineBuffer = fgets($FileHandle);

			// "Router" line
			if (strpos($LineBuffer, "r ") === 0)
			{
				$NetworkStatusArray = null;
			
				$LineBuffer = substr($LineBuffer,2);
				$TempArray = explode(" ", $LineBuffer);
	
				$NetworkStatusArray[0] = mysql_real_escape_string($TempArray[0]);
				$NetworkStatusArray[1] = mysql_real_escape_string(bin2hex(base64_decode($TempArray[1])));
				$NetworkStatusArray[2] = mysql_real_escape_string($TempArray[2]);
				$NetworkStatusArray[3] = mysql_real_escape_string($TempArray[3] . " " . $TempArray[4]);
				$NetworkStatusArray[4] = mysql_real_escape_string($TempArray[5]);
				$NetworkStatusArray[5] = mysql_real_escape_string($TempArray[6]);
				$NetworkStatusArray[6] = mysql_real_escape_string(rtrim($TempArray[7]));

				$LineBuffer = fgets($FileHandle);

				if (!(strpos($LineBuffer, "Authority") === false))
				{
					$NetworkStatusArray[7] = 1;
				}
				else
				{
				$NetworkStatusArray[7] = 0;
				}

				if (!(strpos($LineBuffer, "BadDirectory") === false))
				{
					$NetworkStatusArray[19] = 1;
				}
				else
				{
					$NetworkStatusArray[19] = 0;
				}

				if (!(strpos($LineBuffer, "BadExit") === false))
				{
					$NetworkStatusArray[8] = 1;
				}
				else
				{
					$NetworkStatusArray[8] = 0;
				}


				if (!(strpos($LineBuffer, "Exit") === false))
				{
					$NetworkStatusArray[9] = 1;
				}
				else
				{
					$NetworkStatusArray[9] = 0;
				}


				if (!(strpos($LineBuffer, "Fast") === false))
				{
					$NetworkStatusArray[10] = 1;
				}
				else
				{
					$NetworkStatusArray[10] = 0;
				}


				if (!(strpos($LineBuffer, "Guard") === false))
				{
					$NetworkStatusArray[11] = 1;
				}
				else
				{
					$NetworkStatusArray[11] = 0;
				}


				if (!(strpos($LineBuffer, "Named") === false))
				{
					$NetworkStatusArray[12] = 1;
				}
				else
				{
					$NetworkStatusArray[12] = 0;
				}


				if (!(strpos($LineBuffer, "Stable") === false))
				{
					$NetworkStatusArray[13] = 1;
				}
				else
				{
					$NetworkStatusArray[13] = 0;
				}


				if (!(strpos($LineBuffer, "Running") === false))
				{
					$NetworkStatusArray[14] = 1;
				}
				else
				{
					$NetworkStatusArray[14] = 0;
				}


				if (!(strpos($LineBuffer, "Valid") === false))
				{
					$NetworkStatusArray[15] = 1;
				}
				else
				{
					$NetworkStatusArray[15] = 0;
				}

				if (!(strpos($LineBuffer, "V2Dir") === false))
				{
					$NetworkStatusArray[16] = 1;
				}
				else
				{
					$NetworkStatusArray[16] = 0;
				}
			
				// Obtain country code
				$geoip_object = geoip_open($GEOIP_Database_Path . "GeoIP.dat",GEOIP_STANDARD);
				$NetworkStatusArray[17] = mysql_real_escape_string(geoip_country_code_by_addr($geoip_object, $NetworkStatusArray[4]));

				// Obtain hostname
				$NetworkStatusArray[18] = mysql_real_escape_string(strtolower(rtrim(gethostbyaddr($NetworkStatusArray[4]))));
				if ($NetworkStatusArray[18] == '.')
				{
					$NetworkStatusArray[18] = $NetworkStatusArray[4];
				}

				// Insert records into active network status table in database
				$query = "insert into $UpdateNetworkStatusTable (Name,Fingerprint,DescriptorHash,LastDescriptorPublished,IP,Hostname,ORPort,DirPort,FAuthority,FBadDirectory,FBadExit,FExit,FFast,FGuard,FNamed,FStable,FRunning,FValid,FV2Dir,CountryCode) values ('$NetworkStatusArray[0]','$NetworkStatusArray[1]','$NetworkStatusArray[2]','$NetworkStatusArray[3]','$NetworkStatusArray[4]','$NetworkStatusArray[18]',$NetworkStatusArray[5],$NetworkStatusArray[6],'$NetworkStatusArray[7]','$NetworkStatusArray[19]','$NetworkStatusArray[8]','$NetworkStatusArray[9]','$NetworkStatusArray[10]','$NetworkStatusArray[11]','$NetworkStatusArray[12]','$NetworkStatusArray[13]','$NetworkStatusArray[14]','$NetworkStatusArray[15]','$NetworkStatusArray[16]','$NetworkStatusArray[17]')";
				$result = mysql_query($query) or die('Query failed: ' . mysql_error());  
			
				// Increment router counter
				$RouterCount++;
			}
		}
	}
	else
	{
		echo $LineBuffer;
		
		// Close connection
		mysql_close($link);

		// Close file handle
		fclose($FileHandle);

		exit();
	}

	// Clear out line buffer
	$LineBuffer = null;

	// Send request for server nickname
	$TorCommandString = "GETCONF nickname \r\n";
	fwrite($FileHandle, $TorCommandString);
	
	$LineBuffer = fgets($FileHandle);
	if (strpos($LineBuffer, "250 Nickname=") === 0)
	{
		$Name = mysql_real_escape_string(rtrim(substr($LineBuffer,13)));
	}
	else
	{
		echo "Error getting Nickname of Tor server: " . $LineBuffer;

		$Name = mysql_real_escape_string('UNKNOWNNICK');
		
		// Close connection
		//mysql_close($link);

		// Close file handle
		//fclose($FileHandle);

		//exit();
	}

	// Get descriptor for network status source server, populate into network status source table in database
	$query = "select Fingerprint, Name, LastDescriptorPublished, IP, ORPort, DirPort, Platform, Contact, Uptime, BandwidthMAX, BandwidthBURST, BandwidthOBSERVED, OnionKey, SigningKey, WriteHistoryLAST, WriteHistoryINC, WriteHistorySERDATA, ReadHistoryLAST, ReadHistoryINC, ReadHistorySERDATA, ExitPolicySERDATA, FamilySERDATA, Hibernating, DescriptorSignature from $UpdateDescriptorTable where Name = '$Name'";
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	$record = mysql_fetch_assoc($result);

	$query = "update NetworkStatusSource set Fingerprint = '" . $record['Fingerprint'] . "', Name = '" . $record['Name'] . "', LastDescriptorPublished = '" . $record['LastDescriptorPublished'] . "', IP = '" . $record['IP'] . "', ORPort = " . $record['ORPort'] . ", DirPort = " . $record['DirPort'] . ", Platform = '" . $record['Platform'] . "', Contact = '" . $record['Contact'] . "', Uptime = " . $record['Uptime'] . ", BandwidthMAX = " . $record['BandwidthMAX'] . ", BandwidthBURST = " . $record['BandwidthBURST'] . ", BandwidthOBSERVED = " . $record['BandwidthOBSERVED'] . ", OnionKey = '" . $record['OnionKey'] . "', SigningKey = '" . $record['SigningKey'] . "', WriteHistoryLAST = '" . $record['WriteHistoryLAST'] . "', WriteHistoryINC = " . $record['WriteHistoryINC'] . ", WriteHistorySERDATA = '" . $record['WriteHistorySERDATA'] . "', ReadHistoryLAST = '" . $record['ReadHistoryLAST'] . "', ReadHistoryINC = " . $record['ReadHistoryINC'] . ", ReadHistorySERDATA = '" . $record['ReadHistorySERDATA'] . "', ExitPolicySERDATA = '" . $record['ExitPolicySERDATA'] . "', FamilySERDATA = '" . $record['FamilySERDATA'] . "', Hibernating = '" . $record['Hibernating'] . "', DescriptorSignature = '" . $record['DescriptorSignature'] . "' where ID = 1";
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());

	// Get info for DNSEL table, populate
	$query = "truncate table DNSEL_INACT";
	mysql_query($query) or die('Truncate failed: ' . mysql_error());

	$query = "select $UpdateNetworkStatusTable.IP, $UpdateDescriptorTable.ExitPolicySERDATA from $UpdateNetworkStatusTable inner join $UpdateDescriptorTable on $UpdateNetworkStatusTable.Fingerprint = $UpdateDescriptorTable.Fingerprint";
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	while($record = mysql_fetch_assoc($result))
	{      
		$temp_array = unserialize($record['ExitPolicySERDATA']);
		$temp_exitpolicy_string = "";
		
		foreach($temp_array as $value)
		{
			$temp_exitpolicy_string .= $value . "::";
		}
		
		$temp_exitpolicy_string = substr($temp_exitpolicy_string, 0, -2);
		
		$insert_query = "insert into DNSEL_INACT (IP,ExitPolicy) VALUES ('" . $record['IP'] . "','$temp_exitpolicy_string')";
		mysql_query($insert_query) or die('Insert failed: ' . mysql_error());
	}

	// Close file handle
	fclose($FileHandle);
}
else
{
	echo "Connection to Tor server failed!\n";
		
	// Close connection
	mysql_close($link);

	exit();
}

// Record update end point
$EndTime = time();

// Update 'Status' table
$query = "update Status set LastUpdate = now(), LastUpdateElapsed = ($EndTime - $StartTime), ActiveNetworkStatusTable = '$UpdateNetworkStatusTable', ActiveDescriptorTable = '$UpdateDescriptorTable', ActiveDNSELTable = 'DNSEL' where ID = 1";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

// Swap DNSEL and DNSEL_INACT tables
$query = "RENAME TABLE DNSEL TO tmp_table, DNSEL_INACT TO DNSEL, tmp_table TO DNSEL_INACT";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	
// Close connection
mysql_close($link);

?>
