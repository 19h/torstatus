-- phpMyAdmin SQL Dump
-- version 2.9.1.1-Debian-6
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Mar 14, 2008 at 10:03 PM
-- Server version: 5.0.32
-- PHP Version: 5.2.0-8+etch10
-- 
-- Database: `TorStatus`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `DNSEL`
-- 

CREATE TABLE `DNSEL` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `IP` varchar(256) default NULL,
  `ExitPolicy` varchar(8192) character set latin1 collate latin1_bin default NULL,
  PRIMARY KEY  (`ID`),
  KEY `Index_IP` (`IP`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2383 ;

-- 
-- Dumping data for table `DNSEL`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `DNSEL_INACT`
-- 

CREATE TABLE `DNSEL_INACT` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `IP` varchar(256) default NULL,
  `ExitPolicy` varchar(8192) character set latin1 collate latin1_bin default NULL,
  PRIMARY KEY  (`ID`),
  KEY `Index_IP` (`IP`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `DNSEL_INACT`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `DNSEL_LOG`
-- 

CREATE TABLE `DNSEL_LOG` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `Timestamp` datetime default NULL,
  `TotalResponses` int(10) unsigned default NULL,
  `NOERROR` int(10) unsigned default NULL,
  `SERVFAIL` int(10) unsigned default NULL,
  `NXDOMAIN` int(10) unsigned default NULL,
  `NOTIMP` int(10) unsigned default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- 
-- Dumping data for table `DNSEL_LOG`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Descriptor1`
-- 

CREATE TABLE `Descriptor1` (
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
  KEY `Index_Bandwidth` (`BandwidthOBSERVED`),
  KEY `Index_Uptime` (`Uptime`),
  KEY `Index_Platform` (`Platform`),
  KEY `Index_Contact` (`Contact`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Descriptor1`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Descriptor2`
-- 

CREATE TABLE `Descriptor2` (
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
  KEY `Index_Bandwidth` (`BandwidthOBSERVED`),
  KEY `Index_Uptime` (`Uptime`),
  KEY `Index_Platform` (`Platform`),
  KEY `Index_Contact` (`Contact`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Descriptor2`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Mirrors`
-- 

CREATE TABLE `Mirrors` (
  `id` int(11) NOT NULL auto_increment,
  `mirrors` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Mirrors`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `NetworkStatus1`
-- 

CREATE TABLE `NetworkStatus1` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `Fingerprint` varchar(256) NOT NULL,
  `Name` varchar(256) NOT NULL,
  `LastDescriptorPublished` datetime NOT NULL,
  `DescriptorHash` varchar(256) NOT NULL,
  `IP` varchar(256) NOT NULL,
  `Hostname` varchar(256) NOT NULL,
  `ORPort` int(10) NOT NULL,
  `DirPort` int(10) NOT NULL,
  `CountryCode` varchar(4) NOT NULL,
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
  `FHSDir` tinyint(1) unsigned default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `NetworkStatus1`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `NetworkStatus2`
-- 

CREATE TABLE `NetworkStatus2` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `Fingerprint` varchar(256) NOT NULL,
  `Name` varchar(256) NOT NULL,
  `LastDescriptorPublished` datetime NOT NULL,
  `DescriptorHash` varchar(256) NOT NULL,
  `IP` varchar(256) NOT NULL,
  `Hostname` varchar(256) NOT NULL,
  `ORPort` int(10) NOT NULL,
  `DirPort` int(10) NOT NULL,
  `CountryCode` varchar(4) NOT NULL,
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
  `FHSDir` tinyint(1) unsigned default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `NetworkStatus2`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `NetworkStatusSource`
-- 

CREATE TABLE `NetworkStatusSource` (
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

-- 
-- Dumping data for table `NetworkStatusSource`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Status`
-- 

CREATE TABLE `Status` (
  `ID` int(10) unsigned NOT NULL default '1',
  `LastUpdate` datetime default NULL,
  `LastUpdateElapsed` int(10) unsigned default NULL,
  `ActiveNetworkStatusTable` varchar(256) default NULL,
  `ActiveDescriptorTable` varchar(256) default NULL,
  `ActiveDNSELTable` varchar(256) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `Status`
-- 

INSERT INTO `Status` (`ID`, `LastUpdate`, `LastUpdateElapsed`, `ActiveNetworkStatusTable`, `ActiveDescriptorTable`, `ActiveDNSELTable`) VALUES 
(1, NULL, NULL, NULL, NULL, NULL);

