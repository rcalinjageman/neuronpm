<?php
return "
CREATE TABLE `nsweep_clients` (
  `clientid` bigint(20) NOT NULL auto_increment,
  `ip` varchar(20) NOT NULL default '',
  `host` varchar(255) NOT NULL default '',
  `status` int(11) NOT NULL default '0',
  `approved` int(11) NOT NULL default '0',
  `started` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastcomm` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastmess` varchar(255) NOT NULL default '',
  `cameon` int(11) NOT NULL default '0',
  `timeon` int(11) NOT NULL default '0',
  `blockscomplete` int(11) NOT NULL default '0',
  `model` varchar(20) NOT NULL default '',
  `modelversion` int(11) NOT NULL default '0',
  `clientversion` int(11) NOT NULL default '0',
  `cblock` bigint(20) NOT NULL default '0',
  `lastreply` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`clientid`),
  KEY `status` (`status`),
  KEY `cblock` (`cblock`),
  KEY `model` (`model`),
  KEY `ip` (`ip`),
  KEY `ip1` (`ip`)
) TYPE=InnoDB AUTO_INCREMENT=5 ;



CREATE TABLE `nsweep_models` (
  `model` varchar(20) NOT NULL default '',
  `startfile` varchar(20) NOT NULL default '',
  `version` varchar(5) NOT NULL default '',
  `comments` varchar(255) NOT NULL default '',
  `blocksize` bigint(20) NOT NULL default '0',
  `reportline` mediumtext NOT NULL,
  `inlinereport` int(11) NOT NULL default '0',
  `runsneeded` bigint(20) NOT NULL default '0',
  `active` int(11) NOT NULL default '0',
  PRIMARY KEY  (`model`),
  KEY `active` (`active`)
) TYPE=InnoDB;



CREATE TABLE `nsweep_params` (
  `paramid` bigint(20) NOT NULL auto_increment,
  `model` varchar(20) NOT NULL default '',
  `number` int(11) NOT NULL default '0',
  `name` varchar(20) NOT NULL default '',
  `setline` varchar(255) NOT NULL default '',
  `setoperator` char(1) NOT NULL default '',
  `type` varchar(20) NOT NULL default '',
  `ubound` int(11) NOT NULL default '0',
  `p1` float NOT NULL default '-999',
  `p2` float NOT NULL default '-999',
  `list` varchar(255) NOT NULL default '',
  `active` int(11) NOT NULL default '0',
  PRIMARY KEY  (`paramid`),
  KEY `model` (`model`),
  KEY `number` (`number`)
) TYPE=InnoDB AUTO_INCREMENT=12 ;


CREATE TABLE `nsweep_work` (
  `workid` bigint(20) NOT NULL auto_increment,
  `model` varchar(20) NOT NULL default '',
  `workstart` bigint(20) NOT NULL default '0',
  `blocksize` int(11) NOT NULL default '0',
  `assignment` varchar(20) NOT NULL default '',
  `clientid` bigint(50) NOT NULL default '0',
  `pdone` float NOT NULL default '0',
  `checkins` int(11) NOT NULL default '0',
  `timestarted` datetime NOT NULL default '0000-00-00 00:00:00',
  `timeon` int(11) NOT NULL default '0',
  `timefinished` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`workid`),
  KEY `assignment` (`assignment`),
  KEY `model` (`model`),
  KEY `checkins` (`checkins`)
) TYPE=InnoDB AUTO_INCREMENT=415 ;


ALTER TABLE `nsweep_params`
  ADD CONSTRAINT `params_ibfk_1` FOREIGN KEY (`model`) REFERENCES `nsweep_models` (`model`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `nsweep_work`
  ADD CONSTRAINT `work_ibfk_1` FOREIGN KEY (`model`) REFERENCES `nsweep_models` (`model`) ON DELETE CASCADE ON UPDATE CASCADE;";
?>