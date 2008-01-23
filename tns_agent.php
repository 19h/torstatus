<?php 

// Copyright (c) 2006-2007, Joseph B. Kowalski
// See LICENSE for licensing information 

// Include configuration settings
include("web/config.php");

// Change to current directory
chdir($TNS_Path);

// Prepare run string
$Exec_String = $PHP_Path . "php" . " " . "tns_update.php";

// Start update loop
while(true)
{
	exec($Exec_String);
	sleep($Cache_Expire_Time);
}

?>
