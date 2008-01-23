--
-- Copyright (c) 2006-2007, Joseph B. Kowalski
-- See LICENSE for licensing information

USE TorNetworkStatus;


DROP TABLE IF EXISTS `TorNetworkStatus`.`Descriptor1`;
CREATE TABLE  `TorNetworkStatus`.`Descriptor1` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `Fingerprint` varchar(256) default NULL,
  `Name` varchar(256) default NULL,
  `LastDescriptorPublished` datetime default NULL,
  `IP` varchar(256) default NULL,
  `ORPort` int(10) unsigned default NULL,
  `DirPort` int(10) unsigned default NULL,
  `Platform` varchar(256) default NULL,
  `Contact` varchar(256) default NULL,
  `Uptime` int(10) unsigned default NULL,
  `BandwidthMAX` int(10) unsigned default NULL,
  `BandwidthBURST` int(10) unsigned default NULL,
  `BandwidthOBSERVED` int(10) unsigned default NULL,
  `OnionKey` varchar(1024) default NULL,
  `SigningKey` varchar(1024) default NULL,
  `WriteHistoryLAST` datetime default NULL,
  `WriteHistoryINC` int(10) unsigned default NULL,
  `WriteHistorySERDATA` varchar(8192) character set latin1 collate latin1_bin default NULL,
  `ReadHistoryLAST` datetime default NULL,
  `ReadHistoryINC` int(10) unsigned default NULL,
  `ReadHistorySERDATA` varchar(8192) character set latin1 collate latin1_bin default NULL,
  `ExitPolicySERDATA` varchar(8192) character set latin1 collate latin1_bin default NULL,
  `FamilySERDATA` varchar(8192) character set latin1 collate latin1_bin default NULL,
  `Hibernating` tinyint(1) unsigned default NULL,
  `DescriptorSignature` varchar(1024) default NULL,
  PRIMARY KEY  (`ID`),
  KEY `Index_Fingerprint` (`Fingerprint`),
  KEY `Index_Bandwidth`(`BandwidthOBSERVED`),
  KEY `Index_Uptime`(`Uptime`),
  KEY `Index_Platform`(`Platform`),
  KEY `Index_Contact`(`Contact`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `TorNetworkStatus`.`Descriptor2`;
CREATE TABLE  `TorNetworkStatus`.`Descriptor2` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `Fingerprint` varchar(256) default NULL,
  `Name` varchar(256) default NULL,
  `LastDescriptorPublished` datetime default NULL,
  `IP` varchar(256) default NULL,
  `ORPort` int(10) unsigned default NULL,
  `DirPort` int(10) unsigned default NULL,
  `Platform` varchar(256) default NULL,
  `Contact` varchar(256) default NULL,
  `Uptime` int(10) unsigned default NULL,
  `BandwidthMAX` int(10) unsigned default NULL,
  `BandwidthBURST` int(10) unsigned default NULL,
  `BandwidthOBSERVED` int(10) unsigned default NULL,
  `OnionKey` varchar(1024) default NULL,
  `SigningKey` varchar(1024) default NULL,
  `WriteHistoryLAST` datetime default NULL,
  `WriteHistoryINC` int(10) unsigned default NULL,
  `WriteHistorySERDATA` varchar(8192) character set latin1 collate latin1_bin default NULL,
  `ReadHistoryLAST` datetime default NULL,
  `ReadHistoryINC` int(10) unsigned default NULL,
  `ReadHistorySERDATA` varchar(8192) character set latin1 collate latin1_bin default NULL,
  `ExitPolicySERDATA` varchar(8192) character set latin1 collate latin1_bin default NULL,
  `FamilySERDATA` varchar(8192) character set latin1 collate latin1_bin default NULL,
  `Hibernating` tinyint(1) unsigned default NULL,
  `DescriptorSignature` varchar(1024) default NULL,
  PRIMARY KEY  (`ID`),
  KEY `Index_Fingerprint` (`Fingerprint`),
  KEY `Index_Bandwidth`(`BandwidthOBSERVED`),
  KEY `Index_Uptime`(`Uptime`),
  KEY `Index_Platform`(`Platform`),
  KEY `Index_Contact`(`Contact`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `TorNetworkStatus`.`NetworkStatus1`;
CREATE TABLE  `TorNetworkStatus`.`NetworkStatus1` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `Fingerprint` varchar(256) default NULL,
  `Name` varchar(256) default NULL,
  `LastDescriptorPublished` datetime default NULL,
  `DescriptorHash` varchar(256) default NULL,
  `IP` varchar(256) default NULL,
  `Hostname` varchar(256) default NULL,
  `ORPort` int(10) unsigned default NULL,
  `DirPort` int(10) unsigned default NULL,
  `CountryCode` varchar(4) default NULL,
  `FAuthority` tinyint(1) unsigned default NULL, 
  `FBadDirectory` tinyint(1) unsigned default NULL,
  `FBadExit` tinyint(1) unsigned default NULL,
  `FExit` tinyint(1) unsigned default NULL,
  `FFast` tinyint(1) unsigned default NULL,
  `FGuard` tinyint(1) unsigned default NULL,
  `FNamed` tinyint(1) unsigned default NULL,
  `FStable` tinyint(1) unsigned default NULL,
  `FRunning` tinyint(1) unsigned default NULL,
  `FValid` tinyint(1) unsigned default NULL,
  `FV2Dir` tinyint(1) unsigned default NULL,
  PRIMARY KEY  (`ID`),
  KEY `Index_Fingerprint` (`Fingerprint`),
  KEY `Index_Name`(`Name`),
  KEY `Index_CountryCode`(`CountryCode`),
  KEY `Index_LastDescriptorPublished`(`LastDescriptorPublished`),
  KEY `Index_IP`(`IP`),
  KEY `Index_Hostname`(`Hostname`),
  KEY `Index_ORPort`(`ORPort`),
  KEY `Index_DirPort`(`DirPort`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `TorNetworkStatus`.`NetworkStatus2`;
CREATE TABLE  `TorNetworkStatus`.`NetworkStatus2` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `Fingerprint` varchar(256) default NULL,
  `Name` varchar(256) default NULL,
  `LastDescriptorPublished` datetime default NULL,
  `DescriptorHash` varchar(256) default NULL,
  `IP` varchar(256) default NULL,
  `Hostname` varchar(256) default NULL,
  `ORPort` int(10) unsigned default NULL,
  `DirPort` int(10) unsigned default NULL,
  `CountryCode` varchar(4) default NULL,
  `FAuthority` tinyint(1) unsigned default NULL,
  `FBadDirectory` tinyint(1) unsigned default NULL,
  `FBadExit` tinyint(1) unsigned default NULL,
  `FExit` tinyint(1) unsigned default NULL,
  `FFast` tinyint(1) unsigned default NULL,
  `FGuard` tinyint(1) unsigned default NULL,
  `FNamed` tinyint(1) unsigned default NULL,
  `FStable` tinyint(1) unsigned default NULL,
  `FRunning` tinyint(1) unsigned default NULL,
  `FValid` tinyint(1) unsigned default NULL,
  `FV2Dir` tinyint(1) unsigned default NULL,
  PRIMARY KEY  (`ID`),
  KEY `Index_Fingerprint` (`Fingerprint`),
  KEY `Index_Name`(`Name`),
  KEY `Index_CountryCode`(`CountryCode`),
  KEY `Index_LastDescriptorPublished`(`LastDescriptorPublished`),
  KEY `Index_IP`(`IP`),
  KEY `Index_Hostname`(`Hostname`),
  KEY `Index_ORPort`(`ORPort`),
  KEY `Index_DirPort`(`DirPort`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `TorNetworkStatus`.`DNSEL`;
CREATE TABLE  `TorNetworkStatus`.`DNSEL` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `IP` varchar(256) default NULL,
  `ExitPolicy` varchar(8192) character set latin1 collate latin1_bin default NULL,
  PRIMARY KEY  (`ID`),
  KEY `Index_IP`(`IP`)
) ENGINE=Memory AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `TorNetworkStatus`.`DNSEL_INACT`;
CREATE TABLE  `TorNetworkStatus`.`DNSEL_INACT` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `IP` varchar(256) default NULL,
  `ExitPolicy` varchar(8192) character set latin1 collate latin1_bin default NULL,
  PRIMARY KEY  (`ID`),
  KEY `Index_IP`(`IP`)
) ENGINE=Memory AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `TorNetworkStatus`.`DNSEL_LOG`;
CREATE TABLE  `TorNetworkStatus`.`DNSEL_LOG` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `Timestamp` datetime default NULL,
  `TotalResponses` int(10) unsigned default NULL,
  `NOERROR` int(10) unsigned default NULL,
  `SERVFAIL` int(10) unsigned default NULL,
  `NXDOMAIN` int(10) unsigned default NULL,
  `NOTIMP` int(10) unsigned default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `TorNetworkStatus`.`NetworkStatusSource`;
CREATE TABLE  `TorNetworkStatus`.`NetworkStatusSource` (
  `ID` int(10) unsigned NOT NULL default '1',
  `Fingerprint` varchar(256) default NULL,
  `Name` varchar(256) default NULL,
  `LastDescriptorPublished` datetime default NULL,
  `IP` varchar(256) default NULL,
  `ORPort` int(10) unsigned default NULL,
  `DirPort` int(10) unsigned default NULL,
  `Platform` varchar(256) default NULL,
  `Contact` varchar(256) default NULL,
  `Uptime` int(10) unsigned default NULL,
  `BandwidthMAX` int(10) unsigned default NULL,
  `BandwidthBURST` int(10) unsigned default NULL,
  `BandwidthOBSERVED` int(10) unsigned default NULL,
  `OnionKey` varchar(1024) default NULL,
  `SigningKey` varchar(1024) default NULL,
  `WriteHistoryLAST` datetime default NULL,
  `WriteHistoryINC` int(10) unsigned default NULL,
  `WriteHistorySERDATA` varchar(8192) character set latin1 collate latin1_bin default NULL,
  `ReadHistoryLAST` datetime default NULL,
  `ReadHistoryINC` int(10) unsigned default NULL,
  `ReadHistorySERDATA` varchar(8192) character set latin1 collate latin1_bin default NULL,
  `ExitPolicySERDATA` varchar(8192) character set latin1 collate latin1_bin default NULL,
  `FamilySERDATA` varchar(8192) character set latin1 collate latin1_bin default NULL,
  `Hibernating` tinyint(1) unsigned default NULL,
  `DescriptorSignature` varchar(1024) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `NetworkStatusSource` DISABLE KEYS;
INSERT INTO `TorNetworkStatus`.`NetworkStatusSource` (`ID`,`Fingerprint`,`Name`,`LastDescriptorPublished`,`IP`,`ORPort`,`DirPort`,`Platform`,`Contact`,`Uptime`,`BandwidthMAX`,`BandwidthBURST`,`BandwidthOBSERVED`,`OnionKey`,`SigningKey`,`WriteHistoryLAST`,`WriteHistoryINC`,`WriteHistorySERDATA`,`ReadHistoryLAST`,`ReadHistoryINC`,`ReadHistorySERDATA`,`ExitPolicySERDATA`,`FamilySERDATA`,`Hibernating`,`DescriptorSignature`) VALUES 
 (1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
ALTER TABLE `NetworkStatusSource` ENABLE KEYS;



DROP TABLE IF EXISTS `TorNetworkStatus`.`Status`;
CREATE TABLE  `TorNetworkStatus`.`Status` (
  `ID` int(10) unsigned NOT NULL default '1',
  `LastUpdate` datetime default NULL,
  `LastUpdateElapsed` int(10) unsigned default NULL,
  `ActiveNetworkStatusTable` varchar(256) default NULL,
  `ActiveDescriptorTable` varchar(256) default NULL,
  `ActiveDNSELTable` varchar(256) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `Status` DISABLE KEYS;
INSERT INTO `TorNetworkStatus`.`Status` (`ID`,`LastUpdate`,`LastUpdateElapsed`,`ActiveNetworkStatusTable`,`ActiveDescriptorTable`,`ActiveDNSELTable`) VALUES 
 (1,'2000-01-01 00:00:00',NULL,NULL,NULL,NULL);
ALTER TABLE `Status` ENABLE KEYS;
